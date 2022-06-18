<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\AboutMyWorkRepository;
use App\Repository\MenuItemsRepository;
use App\Service\BannersService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

final class AboutMyWorkController extends AbstractController
{
    public function __construct(
        private AboutMyWorkRepository $aboutMyWorkRepository,
        private BannersService $bannersService,
        private MenuItemsRepository $itemsRepository
    ) {
    }

    /**
     * @Route("/about-my-work", name="about-my-work")
     */
    public function index(): Response
    {
        $aboutMyWorkItem = $this->itemsRepository->findOneBy(
            [
                'active' => true,
                'itemLink' => 'about-my-work'
                ]
        );

        if ($aboutMyWorkItem === null) {
            throw new NotFoundHttpException('Page does not exist');
        }

        $aboutMyWork = $this->aboutMyWorkRepository->getByActiveAndOrderByCreatedAtDesc();
        $banner = $this->bannersService->getAboutMyWorkBanner();

        return $this->render('about-my-work/index.html.twig', [
            'about_my_work' => $aboutMyWork,
            'banner' => $banner,
        ]);
    }
}
