<?php
declare(strict_types = 1);

namespace App\Services;

use App\Entities\ItemCollection;
use App\Repositories\ItemRepositoryInterface;
use App\Repositories\MenuRepositoryInterface;

class MenuItemService
{
    /**
     * @var MenuRepositoryInterface
     */
    private $menuRepository;
    /**
     * @var ItemRepositoryInterface
     */
    private $itemRepository;

    public function __construct(
        MenuRepositoryInterface $menuRepository,
        ItemRepositoryInterface $itemRepository
    ) {
        $this->menuRepository = $menuRepository;
        $this->itemRepository = $itemRepository;
    }

    public function store(ItemCollection $itemCollection)
    {
        // in this case, checking if menu exists will be on Repository level (just to show different option),
        // eventually it should be in the same way of course
        $this->itemRepository->saveCollection($itemCollection);
    }

    public function getByMenuId(int $menuId): ItemCollection
    {
        return $this->itemRepository->findByMenuId($menuId);
    }

    public function deleteByMenuId(int $menuId): void
    {
        $this->itemRepository->deleteByMenuId($menuId);
    }
}
