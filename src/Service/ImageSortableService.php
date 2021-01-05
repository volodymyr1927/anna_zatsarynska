<?php


namespace App\Service;


use App\Entity\Image;
use App\Repository\ImageRepository;

class ImageSortableService
{

    /**
     * @var ImageRepository
     */
    private $imageRepository;

    /**
     * ImageSortableService constructor.
     * @param ImageRepository $imageRepository
     */
    public function __construct(ImageRepository $imageRepository)
    {
        $this->imageRepository = $imageRepository;
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
                while (array_key_exists($k, $result)){
                    $k++;
                }
            }
        }
        ksort($result);

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
}