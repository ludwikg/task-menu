<?php
declare(strict_types = 1);

namespace App\Entities;

class MenuTreeNode
{
    /**
     * @var Item
     */
    private $item;
    /**
     * @var int
     */
    private $depth;

    public function __construct(Item $item, int $depth)
    {
        $this->item = $item;
        $this->depth = $depth;
    }

    public function getItem(): Item
    {
        return $this->item;
    }

    public function getParentId(): ?int
    {
        return $this->item->getParentId();
    }

    public function getDepth(): int
    {
        return $this->depth;
    }
}
