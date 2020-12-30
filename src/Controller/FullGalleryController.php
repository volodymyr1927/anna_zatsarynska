<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FullGalleryController extends AbstractController
{
    /**
     * @Route("/full/gallery", name="full_gallery")
     */
    public function index(): Response
    {
        return $this->render('full_gallery/index.html.twig', [
            'controller_name' => 'FullGalleryController',
        ]);
    }
}
