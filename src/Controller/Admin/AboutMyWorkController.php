<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\AboutMyWork;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use RuntimeException;

final class AboutMyWorkController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return AboutMyWork::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            BooleanField::new('active', 'Active')->setRequired(true),
            TextField::new('content', 'About Me Content')->setRequired(true),
        ];
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!($entityInstance instanceof AboutMyWork)) {
            throw new RuntimeException('Wrong entity type');
        }

        $entityInstance->setCreatedAt(new \DateTime());
        $entityInstance->setUpdatedAt(new \DateTime());
        parent::persistEntity($entityManager, $entityInstance);
    }
}
