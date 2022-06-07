<?php

declare(strict_types=1);

namespace App\Service;

use Psr\Cache\InvalidArgumentException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

/**
 * Class CacheService
 * @package App\Service
 */
final class CacheService
{
    private CacheInterface $cache;

    private string $cacheDir;

    public function __construct(CacheInterface $cache, ParameterBagInterface $parameterBag)
    {
        $this->cache = $cache;
        $this->cacheDir = $parameterBag->get('kernel.cache_dir');
    }

    public function getItem(string $key): ItemInterface
    {
        return $this->cache->getItem($key);
    }

    public function set(ItemInterface $item, int $ttl, $value): bool
    {
        $item->expiresAfter($ttl);
        $item->set($value);

        return $this->cache->save($item);
    }

    public function get(ItemInterface $item)
    {
        return $item->get();
    }

    /**
     * @throws InvalidArgumentException
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

    public function clearFilesystemCache(): void
    {
        $fs = new Filesystem();
        $fs->remove($this->cacheDir);
    }
}
