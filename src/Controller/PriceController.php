<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\PriceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PriceController
 * @package App\Controller
 */
final class PriceController extends AbstractController
{
    private PriceRepository $priceRepository;

    public function __construct(PriceRepository $priceRepository)
    {
        $this->priceRepository = $priceRepository;
    }

    /**
     * @Route("/price", name="price")
     */
    public function index(): Response
    {
        $prices = $this->priceRepository->findByActive();

        return $this->render('price/index.html.twig', [
            'prices' => $prices
        ]);
    }

}
