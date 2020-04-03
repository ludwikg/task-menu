<?php
declare(strict_types = 1);

namespace App\Entities;

class Item implements \JsonSerializable
{
    /**
     * @var int|null
     */
    private $id;
    /**
     * @var string
     */
    private $field;
    /**
     * @var int
     */
    private $menuId;
    /**
     * @var int|null
     */
    private $parentId;

    public function __construct(?int $id, string $field, int $menuId, ?int $parentId = null)
    {
        $this->id = $id;
        $this->field = $field;
        $this->menuId = $menuId;
        $this->parentId = $parentId;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getField(): string
    {
        return $this->field;
    }

    public function getMenuId(): int
    {
        return $this->menuId;
    }

    public function getParentId(): ?int
    {
        return $this->parentId;
    }

    public function setParentId(?int $parentId): self
    {
        $this->parentId = $parentId;
        return $this;
    }

    public function jsonSerialize()
    {
        $stdClass = new \stdClass();
        $stdClass->field = $this->field;

        return $stdClass;
    }
}
