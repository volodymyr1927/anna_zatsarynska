<?php


namespace App\Service;


use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Filesystem\Filesystem;
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

    private $cacheDir;

    /**
     * CacheService constructor.
     * @param CacheInterface $cache
     * @param ParameterBagInterface $parameterBag
     */
    public function __construct(CacheInterface $cache, ParameterBagInterface $parameterBag)
    {
        $this->cache = $cache;
        $this->cacheDir = $parameterBag->get('kernel.cache_dir');
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


    /**
     * @param string $key
     * @return bool
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function delete(string $key): bool
    {
       return $this->cache->delete($key);
    }

    public function cacheClearAndWarmup(): bool
    {
        $clear = sprintf('php %s/../../bin/console cache:clear', __DIR__);
        $warmup = sprintf('php %s/../../bin/console cache:warmup', __DIR__);

        exec($clear);
        exec($warmup);

        return true;
    }

    public function clearFilesystemCache()
    {
        $fs = new Filesystem();
        $fs->remove($this->cacheDir);
    }
}
