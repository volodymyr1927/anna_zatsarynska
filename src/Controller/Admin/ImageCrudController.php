<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Image;
use App\Repository\ImageRepository;
use App\Service\CacheService;
use App\Service\ImageSortableService;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Psr\Cache\InvalidArgumentException;
use RuntimeException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @IsGranted("ROLE_ADMIN", statusCode=404, message="Not found")
 * Class ImageCrudController
 * @package App\Controller\Admin
 */
final class ImageCrudController extends AbstractCrudController
{
    private CacheService $cacheService;

    public function __construct(CacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }

    public static function getEntityFqcn(): string
    {
        return Image::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $imageField = ImageField::new('image', 'Image');
        $imageField->setUploadDir(ImageRepository::UPLOAD_DIR);
        $imageField->setBasePath(ImageRepository::BASE_PATH);
        $imageField->setUploadedFileNamePattern(function (UploadedFile $file) {

            return sprintf(
                'upload_%d_%s.%s',
                random_int(1, 999),
                $file->getFilename(),
                $file->guessExtension()
            );
        });
        $imageField->setRequired(false);

        $widthField = ChoiceField::new('width', 'Width');
        $widthField->setChoices(['50' => '50', '100' => '100']);
        $widthField->setRequired(true);

        $weightField = IntegerField::new('weight', 'Weight');
        $weightField->setRequired(true);

        $textField = TextField::new('description', 'Description');
        $textField->setRequired(false);

        return [
            $imageField,
            BooleanField::new('active', 'Active'),
            $widthField,
            $weightField,
            $textField,
        ];
    }

    /**
     * @throws InvalidArgumentException
     */
    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!($entityInstance instanceof Image)) {
            throw new RuntimeException('Wrong entity type');
        }
        $entityInstance->setNameCrc32(crc32($entityInstance->getImage()));
        $entityInstance->setCreatedAt(new DateTime());
        $entityInstance->setUpdatedAt(new DateTime());
        parent::persistEntity($entityManager, $entityInstance);

        $this->cacheService->delete(ImageSortableService::CACHE_KEY);
    }
}
