<?php
declare(strict_types = 1);

namespace App\Entities;

use Illuminate\Database\Eloquent\Collection;

class ItemCollectionMapper
{
    public static function fromEloquentCollection(Collection $collection): ItemCollection
    {
        $itemCollection = new ItemCollection();
        foreach ($collection as $itemObject) {
            $itemCollection->addItem(ItemMapper::fromEloquentObject($itemObject));
        }
        return $itemCollection;
    }

    public static function toEloquentArray(ItemCollection $itemCollection): array
    {
        $return = [];
        /** @var Item $item */
        foreach ($itemCollection as $item) {
            $return[] = ItemMapper::toEloquentArray($item);
        }
        return $return;
    }
}
