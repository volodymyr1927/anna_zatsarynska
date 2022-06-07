<?php

namespace App\Controller\Admin;

use App\Entity\MenuItems;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 *
 * @IsGranted ("ROLE_ADMIN", statusCode=404, message="Not found")
 * Class MenuItemsCrudController
 * @package App\Controller\Admin
 */
class MenuItemsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return MenuItems::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('item_name', 'Item Name'),
            BooleanField::new('active', 'Active'),
            TextField::new('item_link', 'Item Link'),
            IntegerField::new('item_order', 'Order'),
        ];
    }
}
