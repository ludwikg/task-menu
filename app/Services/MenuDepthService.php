<?php
declare(strict_types = 1);

namespace App\Services;

use App\Entities\MenuTree;
use App\Repositories\ItemRepositoryInterface;

class MenuDepthService
{
    /**
     * @var ItemRepositoryInterface
     */
    private $itemRepository;

    public function __construct(ItemRepositoryInterface $itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }

    public function getDepth(int $menuId): int
    {
        $itemCollection = $this->itemRepository->findByMenuId($menuId);
        $menuTree = new MenuTree();
        $menuTree->addNodesFromItemCollection($itemCollection);
        return $menuTree->getMaxDepth();
    }
}
