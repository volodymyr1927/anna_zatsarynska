<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Banner;
use App\Repository\BannerRepository;
use App\Service\BannersService;
use App\Service\CacheService;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use Psr\Cache\InvalidArgumentException;
use RuntimeException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class BannerController extends AbstractCrudController
{
    private string $filename;

    public function __construct(
        private CacheService $cacheService,
        private BannerRepository $bannerRepository,
        private Filesystem $filesystem
    ) {
    }

    public static function getEntityFqcn(): string
    {
        return Banner::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $imageField = ImageField::new('path', 'Image');
        $imageField->setUploadDir('/public/banner/');
        $imageField->setUploadedFileNamePattern(function (UploadedFile $file): string {
            $this->filename = sprintf(
                'main-%d.%s',
                time(),
                $file->guessExtension()
            );

            return $this->filename;
        });


        return [
            $imageField,
            BooleanField::new('active', 'Active')
                ->setRequired(true),
        ];
    }

    /**
     * @throws InvalidArgumentException
     */
    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!($entityInstance instanceof Banner)) {
            throw new RuntimeException('Wrong entity type');
        }

        $entityInstance->setPath('/banner/' . $this->filename);
        if ($entityInstance->isActive()) {
            $activeBanners = $this->bannerRepository->getAllActiveBanners();
            if ($activeBanners !== []) {
                foreach ($activeBanners as $banner) {
                    $banner->setActive(false);
                    $banner->setUpdatedAt(new DateTime());
                }
                $this->bannerRepository->batchUpdate(...$activeBanners);
            }
        }
        $entityInstance->setCreatedAt(new DateTime());
        $entityInstance->setUpdatedAt(new DateTime());
        parent::persistEntity($entityManager, $entityInstance);

        $this->cacheService->delete(BannersService::BANNER_CACHE_KEY);
        $this->filesystem->copy(
            __DIR__ . '/../../../public/banner/' . $this->filename,
            __DIR__ . '/../../../public/banner/main.jpg',
            true
        );
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance->isActive()) {
            $activeBanners = $this->bannerRepository->getAllActiveBanners();
            if ($activeBanners !== []) {
                foreach ($activeBanners as $banner) {
                    $banner->setActive(false);
                    $banner->setUpdatedAt(new DateTime());
                }
                $this->bannerRepository->batchUpdate(...$activeBanners);
            }
        }
        $entityManager->persist($entityInstance);
        $entityManager->flush();
    }
}
