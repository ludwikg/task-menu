<?php
declare(strict_types = 1);

namespace App\Repositories;

use App\Entities\Item;
use App\Entities\ItemCollection;
use App\Entities\ItemCollectionMapper;
use App\Entities\ItemMapper;
use App\Exceptions\InvalidArgumentException;
use Illuminate\Database\QueryException;

class ItemEloquentRepository implements ItemRepositoryInterface
{
    /**
     * @var \App\Item
     */
    private $itemModel;

    public function __construct(\App\Item $itemModel)
    {
        $this->itemModel = $itemModel;
    }

    public function save(Item $item): void
    {
        $this->itemModel->insert(ItemMapper::toEloquentArray($item));
    }

    public function findById(int $itemId): ?Item
    {
        $object = $this->itemModel->where('id', $itemId)->limit(1)->first();
        return $object !== null ? ItemMapper::fromEloquentObject($object) : null;
    }

    public function update(Item $item): void
    {
        $this->itemModel->where('id', $item->getId())->update(ItemMapper::toEloquentArray($item));
    }

    public function delete(int $itemId): void
    {
        $this->itemModel->where('id', $itemId)->delete();
    }

    public function saveCollection(ItemCollection $itemCollection): ItemCollection
    {
        try {
            $this->itemModel->insert(ItemCollectionMapper::toEloquentArray($itemCollection));
        } catch (QueryException $exception) {
            // unfortunately eloquent does not return specific exception, however there is sql error code
            if (strpos($exception->getMessage(), 'SQLSTATE[23000]') !== false) {
                throw new InvalidArgumentException('MenuItem can not be added, Menu with given Id probably does not exists');
            }
        }

        // @todo good idea is to get inserted Ids and fill collection / or even better get db data and map to collection
        return $itemCollection;
    }

    public function findByMenuId(int $menuId): ItemCollection
    {
        $collection = $this->itemModel->where('menu_id', $menuId)->get();
        return ItemCollectionMapper::fromEloquentCollection($collection);
    }

    public function deleteByMenuId(int $menuId): void
    {
        $this->itemModel->where('menu_id', $menuId)->delete();
    }

    public function doesExist(Item $item): bool
    {
        $count = $this->itemModel->where(ItemMapper::toEloquentArray($item))->limit(1)->count();
        return (bool)$count;
    }

    public function doesExistById(int $itemId): bool
    {
        $count = $this->itemModel->where(['id' => $itemId])->limit(1)->count();
        return (bool)$count;
    }

    public function findByParentId(int $parentId): ItemCollection
    {
        $collection = $this->itemModel->where('parent_id', $parentId)->get();
        return ItemCollectionMapper::fromEloquentCollection($collection);
    }

    public function deleteByParentId(int $parentId): void
    {
        $this->itemModel->where('parent_id', $parentId)->delete();
    }

    public function updateCollection(ItemCollection $itemCollection): ItemCollection
    {
        /** @var Item $item */
        foreach ($itemCollection as $item) {
            $this->update($item);
        }
        return $itemCollection;
    }
}
