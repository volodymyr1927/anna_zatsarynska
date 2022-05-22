<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\MenuItems;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 *
 * @method MenuItems|null find($id, $lockMode = null, $lockVersion = null)
 * @method MenuItems|null findOneBy(array $criteria, array $orderBy = null)
 * @method MenuItems[]    findAll()
 * @method MenuItems[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 *
 */
final class MenuItemsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MenuItems::class);
    }
}