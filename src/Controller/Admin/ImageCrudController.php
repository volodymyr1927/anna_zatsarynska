<?php

namespace App\Controller\Admin;

use App\Entity\Image;
use App\Repository\ImageRepository;
use App\Service\CacheService;
use App\Service\ImageSortableService;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @IsGranted("ROLE_ADMIN", statusCode=404, message="Not found")
 * Class ImageCrudController
 * @package App\Controller\Admin
 */
class ImageCrudController extends AbstractCrudController
{
    /**
     * @var CacheService
     */
    private $cacheService;

    /**
     * ImageCrudController constructor.
     * @param CacheService $cacheService
     */
    public function __construct(CacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }

    /**
     * @return string
     */
    public static function getEntityFqcn(): string
    {
        return Image::class;
    }

    /**
     * @param string $pageName
     * @return iterable
     */
    public function configureFields(string $pageName): iterable
    {
       $imageField = ImageField::new('image','Image');
       $imageField->setUploadDir(ImageRepository::UPLOAD_DIR);
       $imageField->setBasePath(ImageRepository::BASE_PATH);
       $imageField->setUploadedFileNamePattern(function(UploadedFile $file) {
         return sprintf('upload_%d_%s.%s', random_int(1, 999), $file->getFilename(), $file->guessExtension());
       });

        $widthField = ChoiceField::new('width','Width');
        $widthField->setChoices(['50' => '50', '100' => '100']);
        $widthField->setRequired(true);

        $wageField = IntegerField::new('wage', 'Wage');
        $wageField->setRequired(true);

        $textField = TextField::new('description', 'Description');
        $textField->setRequired(false);

        return [
            $imageField,
            BooleanField::new('active', 'Active'),
            $widthField,
            $wageField,
            $textField,
        ];
    }

    /**
     * @param EntityManagerInterface $entityManager
     * @param $entityInstance
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ( !($entityInstance instanceof Image) ) {
            throw new \Exception('Wrong entity type');
        }
        $entityInstance->setNameCrc32(crc32($entityInstance->getImage()));
        $entityInstance->setCreatedAt(new \DateTime());
        $entityInstance->setUpdatedAt(new \DateTime());
        parent::persistEntity($entityManager, $entityInstance);

        $this->cacheService->delete(ImageSortableService::CACHE_KEY);
    }
}
