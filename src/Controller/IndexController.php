<?php

namespace App\Controller;

use App\Repository\ImageRepository;
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
     * @var ImageRepository
     */
    private $imageRepository;

    /**
     * IndexController constructor.
     * @param ImageRepository $imageRepository
     */
    public function __construct(ImageRepository $imageRepository)
    {
        $this->imageRepository = $imageRepository;
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
        return $this->imageRepository->findBy(['active' => true]);
    }
}
