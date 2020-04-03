<?php
declare(strict_types = 1);

namespace App\Entities;

use App\Item as EloquentItem;

class ItemMapper
{
    public static function fromEloquentObject(EloquentItem $itemObject): Item
    {
        $id = $itemObject->id !== null ? (int)$itemObject->id : null;
        $parentId = $itemObject->parent_id !== null ? (int)$itemObject->parent_id : null;
        return new Item($id, $itemObject->field, (int)$itemObject->menu_id, $parentId);
    }

    public static function toEloquentArray(Item $item): array
    {
        return [
            'field' => $item->getField(),
            'menu_id' => $item->getMenuId(),
            'parent_id' => $item->getParentId(),
        ];
    }
}
