<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\MenuItems;
use App\Repository\MenuItemsRepository;

final class MenuItemsService
{
    private const CACHE_KEY = 'menu_items';
    private const TTL = 3600;

    private MenuItemsRepository $menuItemsRepository;

    private CacheService $cacheService;

    public function __construct(
        MenuItemsRepository $menuItemsRepository,
        CacheService $cacheService
    ) {
        $this->menuItemsRepository = $menuItemsRepository;
        $this->cacheService = $cacheService;
    }

    /**
     * @return MenuItems[]
     */
    public function getMenuItems(): array
    {
        $item = $this->cacheService->getItem(self::CACHE_KEY);
        if ($result = $this->cacheService->get($item)) {
            return $result;
        }

        $result = $this->menuItemsRepository->findBy(
            ['active' => 1],
            ['itemOrder' => 'ASC']
        );

        if ($result !== []) {
            $this->cacheService->set($item, self::TTL, $result);
        }

        return $result;
    }
}
