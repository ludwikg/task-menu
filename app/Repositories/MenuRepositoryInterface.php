<?php
declare(strict_types = 1);

namespace App\Repositories;

use App\Entities\Menu;

interface MenuRepositoryInterface
{
    public function save(Menu $item): void;

    public function update(Menu $menu): void;

    public function delete(int $menuId): void;

    public function doesExistByField(string $field): bool;

    public function findById(int $menuId): ?Menu;

    public function doesExistById(int $menuId): bool;
}
