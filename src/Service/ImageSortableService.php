<?php

declare(strict_types=1);


namespace App\Service;

use App\Entity\Image;
use App\Repository\ImageRepository;

/**
 * Class ImageSortableService
 * @package App\Service
 */
final class ImageSortableService
{
    public const CACHE_KEY = 'sorted_image_v1';
    private const CACHE_TTL = 1800; // 30 minutes

    private ImageRepository $imageRepository;

    private CacheService $cacheService;

    /**
     * ImageSortableService constructor.
     * @param ImageRepository $imageRepository
     * @param CacheService $cacheService
     */
    public function __construct(ImageRepository $imageRepository, CacheService $cacheService)
    {
        $this->imageRepository = $imageRepository;
        $this->cacheService = $cacheService;
    }

    public function getSortedImages(): array
    {
        $images = $this->imageRepository->findByActive();

        if (!empty($images)) {

            return $this->sortByWidthAndWage($images);
        }

        return $images;
    }

    private function sortByWidthAndWage(array $images): array
    {
        $item = $this->cacheService->getItem(self::CACHE_KEY);
        if ($result = $this->cacheService->get($item)) {

            return $result;
        }

        $result = $this->sortImagesByWidth($images);
        if (empty($result)) {

            return  [];
        }

        $result = $this->sortImagesByWage($result);
        if (empty($result)) {

            return  [];
        }

        $this->cacheService->set($item, self::CACHE_TTL, $result);

        return $result;
    }

    private function sortImagesByWidth(array $images): array
    {
        $result = [];
        $split = $this->splitValueByWidth($images);

        if (!empty($split[ImageRepository::FULL_WIDTH])) {
            $k = 0;
            foreach ($split[ImageRepository::FULL_WIDTH] as $value) {
                $result[$k] = $value;
                $k += 3;
            }
        }

        if (!empty($split[ImageRepository::HALF_WIDTH])) {
            $k = 1;
            foreach ($split[ImageRepository::HALF_WIDTH] as $value) {
                $result[$k] = $value;
                while (array_key_exists($k, $result)) {
                    $k++;
                }
            }
        }
        ksort($result);

        return $result;
    }

    private function sortImagesByWage(array $images): array
    {
        uasort($images,[$this,'comparison']);

        return $images;
    }

    function comparison(Image $a, Image $b): int
    {
        if ($a->getWeight() === $b->getWeight()) {
            return 0;
        }
        return ($a->getWeight() < $b->getWeight()) ? -1 : 1;
    }

    private function splitValueByWidth(array $images): array
    {
        $splits = [];
        foreach (ImageRepository::$widths as $width) {
            $splits[$width] = array_filter($images, static function (Image $value) use ($width) {
                return ((int) $value->getWidth() === (int) $width);
            });

        }

        return $splits;
    }
}
