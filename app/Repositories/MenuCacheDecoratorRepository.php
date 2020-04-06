<?php
declare(strict_types = 1);

namespace App\Repositories;

use App\Entities\Menu;
use Illuminate\Cache\Repository;

class MenuCacheDecoratorRepository implements MenuRepositoryInterface
{
    /**
     * @var MenuRepositoryInterface
     */
    private $itemRepository;
    /**
     * @var Repository
     */
    private $cache;

    public function __construct(
        MenuRepositoryInterface $itemRepository,
        Repository $cache
    ) {

        $this->itemRepository = $itemRepository;
        $this->cache = $cache;
    }

    public function doesExistByField(string $field): bool
    {
        $cacheKey = 'MENU_EXISTS_BY_FIELD_' . md5($field);

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        $value = $this->itemRepository->doesExistByField($field);
        $this->cache->tags('menu')->put($cacheKey, $value);

        return $value;
    }

    public function doesExistById(int $menuId): bool
    {
        $cacheKey = 'MENU_EXISTS_BY_ID_' . $menuId;

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        $value = $this->itemRepository->doesExistById($menuId);
        $this->cache->tags('menu')->put($cacheKey, $value);

        return $value;
    }

    public function findById(int $menuId): ?Menu
    {
        $cacheKey = 'MENU_BY_ID_' . $menuId;

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        $value = $this->itemRepository->findById($menuId);
        $this->cache->tags('menu')->put($cacheKey, $value);

        return $value;
    }

    public function save(Menu $menu): void
    {
        $this->clearCache();
        $this->itemRepository->save($menu);
    }

    public function update(Menu $menu): void
    {
        $this->clearCache();
        $this->itemRepository->update($menu);
    }

    public function delete(int $menuId): void
    {
        $this->clearCache();
        $this->itemRepository->delete($menuId);
    }

    private function clearCache()
    {
        // it can be optimised to flush only menus related with a given update / store (and collections)
        $this->cache->tags('menu')->flush();
    }
}
