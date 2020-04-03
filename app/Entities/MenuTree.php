<?php
declare(strict_types = 1);

namespace App\Entities;

use Traversable;

class MenuTree implements \IteratorAggregate, \Countable
{
    /** @var  MenuTreeNode */
    private $nodes;

    public function addNodesFromItemCollection(ItemCollection $itemCollection)
    {
        $this->addNodesByParentId(null, $itemCollection, 1);
    }

    public function getMaxDepth(): int
    {
        $maxDepth = 0;
        /** @var MenuTreeNode $node */
        foreach ($this->nodes as $node) {
            if ($node->getDepth() > $maxDepth) {
                $maxDepth = $node->getDepth();
            }
        }
        return $maxDepth;
    }

    private function addNodesByParentId(?int $parentId, ItemCollection $itemCollection, int $currentDepth): void
    {
        /** @var Item $item */
        foreach ($itemCollection as $item) {
            if ($item->getParentId() === $parentId) {
                $this->nodes[] = new MenuTreeNode($item, $currentDepth);
                $this->addNodesByParentId($item->getId(), $itemCollection, $currentDepth + 1);
            }
        }
    }

    public function deleteNode(MenuTreeNode $nodeToDelete): self
    {
        /**
         * @var int $k
         * @var MenuTreeNode $node
         */
        foreach ($this->nodes as $k => $node) {
            if ($node->getItem()->getId() === $nodeToDelete->getItem()->getId()) {
                unset($this->nodes[$k]);
            }
        }
        return $this;
    }

    public function getIterator()
    {
        yield from $this->nodes;
    }

    /**
     * Count elements of an object
     * @link http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     * @since 5.1.0
     */
    public function count()
    {
        return count($this->nodes);
    }
}
