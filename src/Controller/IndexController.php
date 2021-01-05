<?php

namespace App\Controller;

use App\Service\ImageSortableService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class IndexController
 * @package App\Controller
 */
class IndexController extends AbstractController
{

    /**
     * @var ImageSortableService
     */
    private $imageService;

    /**
     * IndexController constructor.
     * @param ImageSortableService $imageService
     */
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
     * @return \App\Entity\Image[]
     */
    private function getAllActiveThumbs(): array
    {
        return $this->imageService->getSortedImages();
    }
}
