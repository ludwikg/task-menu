<?php
declare(strict_types = 1);

namespace App\Services;

use App\Entities\ItemCollection;
use App\Entities\MenuTree;
use App\Entities\MenuTreeNode;
use App\Helpers\MenuTreeHelper;
use App\Repositories\ItemRepositoryInterface;

class MenuLayerService
{
    /**
     * @var ItemRepositoryInterface
     */
    private $itemRepository;

    public function __construct(ItemRepositoryInterface $itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }

    public function show(int $menuId, int $depth)
    {
        $menuTree = $this->createTreeByMenuId($menuId);

        $returnItemCollection = new ItemCollection();
        /** @var MenuTreeNode $node */
        foreach ($menuTree as $node) {
            if ($node->getDepth() === $depth) {
                $returnItemCollection->addItem($node->getItem());
            }
        }

        return $returnItemCollection;
    }

    public function destroy($menuId, $depth): MenuTree
    {
        $menuTree = $this->createTreeByMenuId($menuId);
        /** @var MenuTreeNode $node */
        foreach ($menuTree as $node) {
            if ($node->getDepth() === $depth) {
                $children = MenuTreeHelper::getItemSubCollectionByParentId($menuTree, $node->getItem()->getId());
                $children->setParentId($node->getParentId());
                $this->itemRepository->updateCollection($children);
                $this->itemRepository->delete($node->getItem()->getId());
                $menuTree = $menuTree->deleteNode($node);
            }
        }
        return $menuTree;
    }

    private function createTreeByMenuId(int $menuId): MenuTree
    {
        $itemCollection = $this->itemRepository->findByMenuId($menuId);
        $menuTree = new MenuTree();
        $menuTree->addNodesFromItemCollection($itemCollection);
        return $menuTree;
    }
}
