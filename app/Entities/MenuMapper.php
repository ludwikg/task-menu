<?php
declare(strict_types = 1);

namespace App\Entities;

use App\Menu as EloquentMenu;

class MenuMapper
{
    public static function fromEloquentObject(EloquentMenu $menuObject): Menu
    {
        $id = $menuObject->id !== null ? (int)$menuObject->id : null;
        return new Menu($id, $menuObject->field);

    }

    public static function toEloquentArray(Menu $menu): array
    {
        return [
            'field' => $menu->getField(),
        ];
    }
}
