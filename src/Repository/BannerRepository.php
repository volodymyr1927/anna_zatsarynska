<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Banner;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Banner|null find($id, $lockMode = null, $lockVersion = null)
 * @method Banner|null findOneBy(array $criteria, array $orderBy = null)
 * @method Banner[]    findAll()
 * @method Banner[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class BannerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Banner::class);
    }

    public function getLastActiveBanner(): ?Banner
    {
        return $this
            ->findOneBy(
                ['active' => true],
                ['createdAt' => 'DESC']
            );
    }

    /**
     * @return Banner[]
     */
    public function getAllActiveBanners(): array
    {
        return $this
            ->findBy(['active' => true]);
    }

    public function batchUpdate(Banner ...$banners): void
    {
        foreach ($banners as $banner) {
            $this->getEntityManager()->persist($banner);
        }
        $this->getEntityManager()->flush();
    }
}
