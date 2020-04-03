<?php
declare(strict_types = 1);

namespace App\Entities;

class ItemFactory
{
    public static function createFromPayload(\stdClass $payload): Item
    {
        return new Item(null, $payload->field, $payload->menuId);
    }

    public static function createFromItemAndItemId(Item $item, int $itemId): Item
    {
        return new Item($itemId, $item->getField(), $item->getMenuId(), $item->getParentId());
    }
}
