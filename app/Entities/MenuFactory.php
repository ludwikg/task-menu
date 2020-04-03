<?php
declare(strict_types = 1);

namespace App\Entities;

use App\Exceptions\InvalidArgumentException;

class MenuFactory
{
    public static function fromRequestObject(\stdClass $request): Menu
    {
        if (!isset($request->field)) {
            throw new InvalidArgumentException('Invalid argument');
        }
        return new Menu(null, $request->field);
    }

    public static function createFromItemAndItemId(Menu $menu, int $menuId): Menu
    {
        return new Menu($menuId, $menu->getField());
    }
}
