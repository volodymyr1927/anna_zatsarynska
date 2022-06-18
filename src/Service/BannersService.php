<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\AboutMyWorkBanner;
use App\Entity\Banner;
use App\Repository\AboutMyWorkBannerRepository;
use App\Repository\BannerRepository;

final class BannersService
{
    public const BANNER_CACHE_KEY = 'banner';
    public const ABOUT_MY_WORK_BANNER = 'about_my_work_banner';
    private const TTL = 3600;

    public function __construct(
        private CacheService $cacheService,
        private BannerRepository $bannerRepository,
        private AboutMyWorkBannerRepository $aboutMyWorkBannerRepository
    ) {
    }

    public function getMainBanner(): ?Banner
    {
        $item = $this->cacheService->getItem(self::BANNER_CACHE_KEY);
        if ($result = $this->cacheService->get($item)) {
            return $result;
        }

        $result = $this->bannerRepository->getLastActiveBanner();

        if ($result !== []) {
            $this->cacheService->set($item, self::TTL, $result);
        }

        return $result;
    }

    public function getAboutMyWorkBanner(): ?AboutMyWorkBanner
    {
        $item = $this->cacheService->getItem(self::ABOUT_MY_WORK_BANNER);
        if ($result = $this->cacheService->get($item)) {
            return $result;
        }

        $result = $this->aboutMyWorkBannerRepository->getLastActiveBanner();

        if ($result !== []) {
            $this->cacheService->set($item, self::TTL, $result);
        }

        return $result;
    }
}
