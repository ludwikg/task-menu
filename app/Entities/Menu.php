<?php
declare(strict_types = 1);

namespace App\Entities;

class Menu implements \JsonSerializable
{
    /**
     * @var int|null
     */
    private $id;
    /**
     * @var string
     */
    private $field;

    public function __construct(?int $id, string $field)
    {
        $this->id = $id;
        $this->field = $field;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getField(): string
    {
        return $this->field;
    }

    public function jsonSerialize()
    {
        $stdClass = new \stdClass();
        $stdClass->field = $this->field;

        return $stdClass;
    }
}
