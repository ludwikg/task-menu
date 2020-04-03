<?php
declare(strict_types = 1);

namespace App\Entities;

class ItemCollectionFactory
{
    public static function createFromPayload(array $array, $menuId, ?int $parentId = null): ItemCollection
    {
        $itemCollection = new ItemCollection();

        foreach ($array as $stdClass) {
            $itemCollection->addItem(new Item(null, $stdClass->field, $menuId, $parentId));
        }
        return $itemCollection;
    }
}
