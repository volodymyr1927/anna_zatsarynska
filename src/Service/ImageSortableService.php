<?php


namespace App\Service;


use App\Entity\Image;
use App\Repository\ImageRepository;

/**
 * Class ImageSortableService
 * @package App\Service
 */
class ImageSortableService
{

    public const CACHE_KEY = 'sorted_image_v1';
    private const CACHE_TTL = 1800; // 30 minutes

    /**
     * @var ImageRepository
     */
    private $imageRepository;

    /**
     * @var CacheService
     */
    private $cacheService;

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


    /**
     * @return array
     */
    public function getSortedImages(): array
    {
        $images = $this->imageRepository->findByActive();

        if (!empty($images)) {

            return $this->sortImagesByWidth($images);
        }

        return $images;
    }


    /**
     * @param array $images
     * @return array
     */
    private function sortImagesByWidth(array $images): array
    {
        $item = $this->cacheService->getItem(self::CACHE_KEY);

        if ($result = $this->cacheService->get($item)) {

            return $result;
        }

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
        $this->cacheService->set($item, self::CACHE_TTL, $result);

        return $result;
    }

    /**
     * @param array $images
     * @return array
     */
    private function splitValueByWidth(array $images): array
    {
        $splits = [];
        foreach (ImageRepository::$widths as $width) {

            $splits[$width] = array_filter($images, function ($value) use ($width) {
                if (!($value instanceof Image)) {
                    return false;
                }

                return ($value->getWidth() == $width);
            });

        }

        return $splits;
    }

}