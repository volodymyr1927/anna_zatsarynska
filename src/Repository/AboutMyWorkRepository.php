<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\AboutMyWork;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AboutMyWork|null find($id, $lockMode = null, $lockVersion = null)
 * @method AboutMyWork|null findOneBy(array $criteria, array $orderBy = null)
 * @method AboutMyWork[]    findAll()
 * @method AboutMyWork[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AboutMyWorkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AboutMyWork::class);
    }

    public function getByActiveAndOrderByCreatedAtDesc(): ?AboutMyWork
    {
        return $this
           ->findOneBy(
               ['active' => true],
               ['createdAt' => 'DESC']
           );
    }
}
