<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\BannerRepository;
use App\Service\BannersService;
use App\Service\ImageSortableService;
use App\Service\MenuItemsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class IndexController
 * @package App\Controller
 */
final class IndexController extends AbstractController
{
    public function __construct(
        private ImageSortableService $imageService,
        private MenuItemsService $menuItemsService,
        private BannersService $bannersService
    ) {
    }

    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        $thumbs = $this->imageService->getSortedImages();
        $menuItems = $this->menuItemsService->getMenuItems();
        $banner = $this->bannersService->getMainBanner();

        return $this->render('index/index.html.twig', [
            'thumbs' => $thumbs,
            'menu_items' => $menuItems,
            'banner' => $banner,
        ]);
    }
}
