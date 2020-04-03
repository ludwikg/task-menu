<?php
declare(strict_types = 1);

namespace App\Repositories;

use App\Entities\Item;
use App\Entities\ItemCollection;

interface ItemRepositoryInterface
{
    public function save(Item $item): void;

    public function findById(int $id): ?Item;

    public function update(Item $item): void;

    public function delete(int $id): void;

    public function saveCollection(ItemCollection $itemCollection): ItemCollection;

    public function findByMenuId(int $menuId): ItemCollection;

    public function deleteByMenuId(int $menuId): void;

    public function doesExist(Item $item): bool;

    public function doesExistById(int $itemId): bool;

    public function findByParentId(int $parentId): ItemCollection;

    public function deleteByParentId(int $parentId): void;

    public function updateCollection(ItemCollection $itemCollection): ItemCollection;
}
