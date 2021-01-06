<?php


namespace App\Service;


use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

/**
 * Class CacheService
 * @package App\Service
 */
class CacheService
{
    /**
     * @var CacheInterface
     */
    private $cache;

    /**
     * CacheService constructor.
     * @param CacheInterface $cache
     */
    public function __construct(CacheInterface $cache)
    {
        $this->cache = $cache;
    }


    /**
     * @param string $key
     * @return ItemInterface
     */
    public function getItem(string $key): ItemInterface
    {
        return $this->cache->getItem($key);
    }

    /**
     * @param ItemInterface $item
     * @param int $ttl
     * @param $value
     * @return bool
     */
    public function set(ItemInterface $item, int $ttl, $value): bool
    {
        $item->expiresAfter($ttl);
        $item->set($value);

        return $this->cache->save($item);
    }

    /**
     * @param ItemInterface $item
     * @return mixed
     */
    public function get(ItemInterface $item)
    {
        return $item->get();
    }

}