<?php
declare(strict_types = 1);

namespace App\Services;

use App\Entities\Menu;
use App\Entities\MenuFactory;
use App\Exceptions\ConflictException;
use App\Exceptions\InvalidArgumentException;
use App\Exceptions\ResourceNotFoundException;
use App\Repositories\MenuRepositoryInterface;

class MenuService
{
    /**
     * @var MenuRepositoryInterface
     */
    private $menuRepository;

    public function __construct(MenuRepositoryInterface $menuRepository)
    {
        $this->menuRepository = $menuRepository;
    }

    public function store(Menu $menu)
    {
        // check if such field already exists
        // we can also skip this part, add unique on DB field and try to catch eloquent exception, then throw
        // custom one on repository level, then we will have 1 query instead of 2, however it might be more complicated
        // to read
        $alreadyExists = $this->menuRepository->doesExistByField($menu->getField());

        if ($alreadyExists) {
            throw new ConflictException('Menu with name ' . $menu->getField() . ' already exists');
        }

        $this->menuRepository->save($menu);
    }

    public function getById(int $menuId): Menu
    {
        $menu = $this->menuRepository->findById($menuId);
        if ($menu === null) {
            throw new ResourceNotFoundException('Menu with id ' . $menuId . ' does not exist.');
        }

        return $menu;
    }

    public function update(int $menuId, Menu $menu): void
    {
        // check if such field already exists
        // we can also skip this part, try to catch eloquent exception during update, then throw
        // custom one on repository level, then we will have 1 query instead of 2, however it might be more complicated
        // to read
        $alreadyExists = $this->menuRepository->doesExistById($menuId);

        if (!$alreadyExists) {
            throw new InvalidArgumentException('Menu with id ' . $menuId . ' does not exist');
        }

        $menu = MenuFactory::createFromItemAndItemId($menu, $menuId);
        $this->menuRepository->update($menu);
    }

    public function destroy($menuId)
    {
        // check if such field already exists
        // we can also skip this part, try to catch eloquent exception during update, then throw
        // custom one on repository level, then we will have 1 query instead of 2, however it might be more complicated
        // to read
        $alreadyExists = $this->menuRepository->doesExistById($menuId);

        if (!$alreadyExists) {
            throw new InvalidArgumentException('Menu with id ' . $menuId . ' does not exist');
        }

        $this->menuRepository->delete($menuId);
    }
}
