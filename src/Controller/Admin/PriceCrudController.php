<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Price;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use RuntimeException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 *
 * @IsGranted ("ROLE_ADMIN", statusCode=404, message="Not found")
 * Class PriceCrudController
 * @package App\Controller\Admin
 */
final class PriceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Price::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            (TextField::new('content_title', 'Price Content Title'))->setRequired(false),
            BooleanField::new('active', 'Active'),
            TextEditorField::new('content', 'Price Content'),
        ];
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!($entityInstance instanceof Price)) {
            throw new RuntimeException('Wrong entity type');
        }

        $entityInstance->setCreatedAt(new \DateTime());
        $entityInstance->setUpdatedAt(new \DateTime());
        parent::persistEntity($entityManager, $entityInstance);
    }
}
