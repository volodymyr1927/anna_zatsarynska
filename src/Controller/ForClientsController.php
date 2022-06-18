<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\MenuItemsRepository;
use App\Repository\PriceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

final class ForClientsController extends AbstractController
{
    public function __construct(
        private PriceRepository $priceRepository,
        private MenuItemsRepository $itemsRepository
    ) {
    }

    /**
     * @Route("/for-clients", name="for-clients")
     */
    public function index(): Response
    {
        $aboutMyWorkItem = $this->itemsRepository->findOneBy(
            [
                'active' => true,
                'itemLink' => 'for-clients'
            ]
        );

        if ($aboutMyWorkItem === null) {
            throw new NotFoundHttpException('Page does not exist');
        }

        $prices = $this->priceRepository->findByActive();

        return $this->render('for-clients/index.html.twig', [
            'prices' => $prices
        ]);
    }
}
