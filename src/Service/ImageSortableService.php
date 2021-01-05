<?php


namespace App\Service;


use App\Entity\Image;
use App\Repository\ImageRepository;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class ImageSortableService
{

    private const CACHE_KEY = 'sorted_image_v1_';
    private const CACHE_TTL = 1800; // 30 minutes

    /**
     * @var ImageRepository
     */
    private $imageRepository;

    /**
     * @var CacheInterface
     */
    private $cache;

    /**
     * ImageSortableService constructor.
     * @param ImageRepository $imageRepository
     * @param CacheInterface $cache
     */
    public function __construct(ImageRepository $imageRepository, CacheInterface $cache)
    {
        $this->imageRepository = $imageRepository;
        $this->cache = $cache;
    }


    /**
     * @return array
     * @throws \Psr\Cache\InvalidArgumentException
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
     * @throws \Psr\Cache\InvalidArgumentException
     */
    private function sortImagesByWidth(array $images): array
    {
        $item = $this->getCacheItem();

        if ($item->get()) {

            return $item->get();
        }

        $result = [];
        $split = $this->splitValueByWeight($images);

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
        $this->setCache($item, $result);

        return $result;
    }

    /**
     * @param array $images
     * @return array
     */
    private function splitValueByWeight(array $images): array
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


    /**
     * @return ItemInterface
     * @throws \Psr\Cache\InvalidArgumentException
     */
    private function getCacheItem(): ItemInterface
    {
        return $this->cache->getItem(self::CACHE_KEY);

    }

    /**
     * @param ItemInterface $item
     * @param $value
     * @return bool
     */
    private function setCache(ItemInterface $item, $value): bool
    {
       $item->expiresAfter(self::CACHE_TTL);
       $item->set($value);
       return $this->cache->save($item);

    }
}