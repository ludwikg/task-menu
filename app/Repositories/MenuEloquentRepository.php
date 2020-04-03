<?php
declare(strict_types = 1);

namespace App\Repositories;

use App\Entities\Menu;
use App\Entities\MenuMapper;

class MenuEloquentRepository implements MenuRepositoryInterface
{
    /**
     * @var \App\Menu
     */
    private $menuModel;

    public function __construct(\App\Menu $menuModel)
    {
        $this->menuModel = $menuModel;
    }

    public function save(Menu $menu): void
    {
        $this->menuModel->insert(MenuMapper::toEloquentArray($menu));
    }

    public function update(Menu $menu): void
    {
        $this->menuModel->where('id', $menu->getId())->update(MenuMapper::toEloquentArray($menu));
    }

    public function delete(int $menuId): void
    {
        $this->menuModel->where('id', $menuId)->delete();
    }

    public function doesExistByField(string $field): bool
    {
        $count = $this->menuModel->where('field', $field)->limit(1)->count();
        return (bool)$count;
    }

    public function doesExistById(int $menuId): bool
    {
        $count = $this->menuModel->where('id', $menuId)->limit(1)->count();
        return (bool)$count;
    }

    public function findById(int $menuId): ?Menu
    {
        $object = $this->menuModel->where('id', $menuId)->limit(1)->first();
        return $object !== null ? MenuMapper::fromEloquentObject($object) : null;
    }
}
