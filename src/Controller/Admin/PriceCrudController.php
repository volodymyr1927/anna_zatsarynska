<?php

namespace App\Controller\Admin;

use App\Entity\Price;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 *
 * @IsGranted ("ROLE_ADMIN", statusCode=404, message="Not found")
 * Class PriceCrudController
 * @package App\Controller\Admin
 */
class PriceCrudController extends AbstractCrudController
{
    /**
     * @return string
     */
    public static function getEntityFqcn(): string
    {
        return Price::class;
    }

    /**
     * @param string $pageName
     * @return iterable
     */
    public function configureFields(string $pageName): iterable
    {
        return [
            (TextField::new('content_title', 'Price Content Title'))->setRequired(false),
            BooleanField::new('active', 'Active'),
            TextEditorField::new('content', 'Price Content'),
        ];
    }


    /**
     * @param EntityManagerInterface $entityManager
     * @param $entityInstance
     * @throws \Exception
     */
    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ( !($entityInstance instanceof Price) ) {
            throw new \Exception('Wrong entity type');
        }

        $entityInstance->setCreatedAt(new \DateTime());
        $entityInstance->setUpdatedAt(new \DateTime());
        parent::persistEntity($entityManager, $entityInstance);
    }
}
