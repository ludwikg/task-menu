<?php
declare(strict_types = 1);

namespace App\Repositories;

use App\Entities\Item;
use App\Entities\ItemCollection;
use App\Entities\ItemMapper;
use Illuminate\Cache\Repository;

class ItemCacheDecoratorRepository implements ItemRepositoryInterface
{
    /**
     * @var ItemRepositoryInterface
     */
    private $itemRepository;
    /**
     * @var Repository
     */
    private $cache;

    public function __construct(
        ItemRepositoryInterface $itemRepository,
        Repository $cache
    ) {
        $this->itemRepository = $itemRepository;
        $this->cache = $cache;
    }

    public function findById(int $itemId): ?Item
    {
        $cacheKey = 'ITEM_BY_ID_' . $itemId;

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        $value = $this->itemRepository->findById($itemId);
        $this->cache->tags('item')->put($cacheKey, $value);

        return $value;
    }

    public function doesExist(Item $item): bool
    {
        $cacheKey = 'ITEM_EXISTS_' . md5(json_encode(ItemMapper::toEloquentArray($item)));

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        $value = $this->itemRepository->doesExist($item);
        $this->cache->tags('item')->put($cacheKey, $value);

        return $value;
    }

    public function findByParentId(int $parentId): ItemCollection
    {
        $cacheKey = 'ITEM_BY_PARENT_ID_' . $parentId;

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        $value = $this->itemRepository->findByParentId($parentId);
        $this->cache->tags('item')->put($cacheKey, $value);

        return $value;
    }

    public function doesExistById(int $itemId): bool
    {
        $cacheKey = 'ITEM_EXISTS_BY_ID_' . $itemId;

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        $value = $this->itemRepository->doesExistById($itemId);
        $this->cache->tags('item')->put($cacheKey, $value);

        return $value;
    }

    public function findByMenuId(int $menuId): ItemCollection
    {
        $cacheKey = 'ITEM_BY_MENU_ID_' . $menuId;

        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        $value = $this->itemRepository->findByMenuId($menuId);
        $this->cache->tags('item')->put($cacheKey, $value);

        return $value;
    }


    // other methods

    public function save(Item $item): void
    {
        $this->clearCache();
        $this->itemRepository->save($item);
    }

    public function update(Item $item): void
    {
        $this->clearCache();
        $this->itemRepository->update($item);
    }

    public function delete(int $itemId): void
    {
        $this->clearCache();
        $this->itemRepository->delete($itemId);
    }

    public function saveCollection(ItemCollection $itemCollection): ItemCollection
    {
        $this->clearCache();
        return $this->itemRepository->saveCollection($itemCollection);
    }

    public function deleteByMenuId(int $menuId): void
    {
        $this->clearCache();
        $this->itemRepository->deleteByMenuId($menuId);
    }

    public function deleteByParentId(int $parentId): void
    {
        $this->clearCache();
        $this->itemRepository->deleteByParentId($parentId);
    }

    public function updateCollection(ItemCollection $itemCollection): ItemCollection
    {
        $this->clearCache();
        return $this->itemRepository->updateCollection($itemCollection);
    }

    private function clearCache()
    {
        // it can be optimised to flush only items related with a given update / store (and collections)
        $this->cache->tags('item')->flush();
    }
}
