<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\AboutMyWorkBanner;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AboutMyWorkBanner|null find($id, $lockMode = null, $lockVersion = null)
 * @method AboutMyWorkBanner|null findOneBy(array $criteria, array $orderBy = null)
 * @method AboutMyWorkBanner[]    findAll()
 * @method AboutMyWorkBanner[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class AboutMyWorkBannerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AboutMyWorkBanner::class);
    }

    public function getLastActiveBanner(): ?AboutMyWorkBanner
    {
        return $this
            ->findOneBy(
                ['active' => true],
                ['createdAt' => 'DESC']
            );
    }

    /**
     * @return AboutMyWorkBanner[]
     */
    public function getAllActiveBanners(): array
    {
        return $this
            ->findBy(['active' => true]);
    }

    public function batchUpdate(AboutMyWorkBanner ...$banners): void
    {
        foreach ($banners as $banner) {
            $this->getEntityManager()->persist($banner);
        }
        $this->getEntityManager()->flush();
    }
}
