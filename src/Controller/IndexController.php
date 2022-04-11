<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Image;
use App\Service\ImageSortableService;
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

    public function __construct(ImageSortableService $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        $thumbs = $this->getAllActiveThumbs();

        return $this->render('index/index.html.twig', [
            'thumbs' => $thumbs,
        ]);
    }

    /**
     * @return Image[]
     */
    private function getAllActiveThumbs(): array
    {
        return $this->imageService->getSortedImages();
    }
}
