<?php

declare(strict_types=1);

namespace App\Controller;

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
    private ImageSortableService $imageService;

    private MenuItemsService $menuItemsService;

    public function __construct(
        ImageSortableService $imageService,
        MenuItemsService $menuItemsService
    ) {
        $this->imageService = $imageService;
        $this->menuItemsService = $menuItemsService;
    }

    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        $thumbs = $this->imageService->getSortedImages();
        $menuItems = $this->menuItemsService->getMenuItems();

        return $this->render('index/index.html.twig', [
            'thumbs' => $thumbs,
            'menu_items' => $menuItems,
        ]);
    }
}
