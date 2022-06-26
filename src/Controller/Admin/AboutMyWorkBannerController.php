<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\AboutMyWorkBanner;
use App\Repository\AboutMyWorkBannerRepository;
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

final class AboutMyWorkBannerController extends AbstractCrudController
{
    private string $filename;

    public function __construct(
        private CacheService $cacheService,
        private AboutMyWorkBannerRepository $aboutMyWorkRepository,
        private Filesystem $filesystem
    ) {
    }

    public static function getEntityFqcn(): string
    {
        return AboutMyWorkBanner::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $imageField = ImageField::new('path', 'Image');
        $imageField->setUploadDir('/public/banner/');
        $imageField->setUploadedFileNamePattern(function (UploadedFile $file): string {
            $this->filename = sprintf(
                'about-me-banner-%d.%s',
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
        if (!($entityInstance instanceof AboutMyWorkBanner)) {
            throw new RuntimeException('Wrong entity type');
        }
        $entityInstance->setPath('/banner/' . $this->filename);

        if ($entityInstance->isActive()) {
            $activeBanners = $this->aboutMyWorkRepository->getAllActiveBanners();
            if ($activeBanners !== []) {
                foreach ($activeBanners as $banner) {
                    $banner->setActive(false);
                    $banner->setUpdatedAt(new DateTime());
                }
                $this->aboutMyWorkRepository->batchUpdate(...$activeBanners);
            }
        }
        $entityInstance->setCreatedAt(new DateTime());
        $entityInstance->setUpdatedAt(new DateTime());
        parent::persistEntity($entityManager, $entityInstance);

        $this->cacheService->delete(BannersService::ABOUT_MY_WORK_BANNER);

        $this->filesystem->copy(
            __DIR__ . '/../../../public/banner/' . $this->filename,
            __DIR__ . '/../../../public/banner/about-me.jpg',
            true
        );
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance->isActive()) {
            $activeBanners = $this->aboutMyWorkRepository->getAllActiveBanners();
            if ($activeBanners !== []) {
                foreach ($activeBanners as $banner) {
                    $banner->setActive(false);
                    $banner->setUpdatedAt(new DateTime());
                }
                $this->aboutMyWorkRepository->batchUpdate(...$activeBanners);
            }
        }
        $entityManager->persist($entityInstance);
        $entityManager->flush();
    }
}
