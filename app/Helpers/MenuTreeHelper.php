<?php
declare(strict_types = 1);

namespace App\Helpers;

use App\Entities\ItemCollection;
use App\Entities\MenuTree;
use App\Entities\MenuTreeNode;

class MenuTreeHelper
{
    public static function getItemSubCollectionByParentId(MenuTree $menuTree, ?int $parentId): ItemCollection
    {
        $returnItemCollection = new ItemCollection();
        /** @var MenuTreeNode $node */
        foreach ($menuTree as $node) {
            if ($node->getParentId() === $parentId) {
                $returnItemCollection->addItem($node->getItem());
            }
        }

        return $returnItemCollection;
    }
}


