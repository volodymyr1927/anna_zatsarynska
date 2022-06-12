<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\AboutMyWorkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AboutMyWorkController extends AbstractController
{
    public function __construct(private AboutMyWorkRepository $aboutMyWorkRepository)
    {
    }

    /**
     * @Route("/about-my-work", name="about-my-work")
     */
    public function index(): Response
    {
        $aboutMyWork = $this->aboutMyWorkRepository->getByActiveAndOrderByCreatedAtDesc();

        return $this->render('about-my-work/index.html.twig', [
            'about_my_work' => $aboutMyWork
        ]);
    }
}
