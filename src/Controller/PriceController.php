<?php

namespace App\Controller;

use App\Repository\PriceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PriceController
 * @package App\Controller
 */
class PriceController extends AbstractController
{
    /**
     * @var PriceRepository
     */
    private $priceRepository;

    /**
     * PriceController constructor.
     * @param PriceRepository $priceRepository
     */
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
