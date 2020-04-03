<?php
declare(strict_types = 1);

namespace App\Dto;

class ItemChildrenPostPayload
{
    /**
     * @var int
     */
    private $parentId;

    /**
     * @var array<stdClass>
     */
    private $data;

    public function __construct(int $parentId, array $payloadArray)
    {
        $this->parentId = $parentId;
        $this->data = $payloadArray;
    }

    public function getParentId(): int
    {
        return $this->parentId;
    }

    public function getData(): array
    {
        return $this->data;
    }
}
