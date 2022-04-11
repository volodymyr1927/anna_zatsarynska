<?php

declare(strict_types=1);

namespace App\Controller\Admin;


use App\Service\CacheService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use \Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class CacheHandlingController
 * @IsGranted("ROLE_ADMIN", statusCode=404, message="Not found")
 * @package App\Controller\Admin
 */
final class CacheHandlingController extends AbstractController
{
    private CacheService $cacheService;

    public function __construct(CacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }

    /**
     * @Route ("/admin/cache/clear", name="cacheClear")
     */
    public function clearCache(): RedirectResponse
    {
        set_time_limit(120);

        $this->cacheService->cacheClearAndWarmup();

       return $this->redirectToRoute("admin");
    }
}
