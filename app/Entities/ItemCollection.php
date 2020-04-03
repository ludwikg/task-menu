<?php
declare(strict_types = 1);

namespace App\Entities;

use Illuminate\Contracts\Support\Arrayable;
use Traversable;

class ItemCollection implements \JsonSerializable, \IteratorAggregate, \Countable
{
    /**
     * @var array<Item>
     */
    private $data;

    /**
     * ItemCollection constructor.
     * @param array <Item> $items
     */
    public function __construct(array $items = [])
    {
        foreach ($items as $value) {
            if (!($value instanceof Item)) {
                throw new \LogicException('ItemCollection cant not be created with such parameters');
            }
        }
        $this->data = $items;
    }

    public function addItem(Item $item)
    {
        $this->data[] = $item;
    }

    function jsonSerialize()
    {
        return ($this->data);
    }

    public function toArray()
    {
        return $this->data;
    }

    public function setParentId(?int $parentId)
    {
        /** @var Item $item */
        foreach ($this->data as $item){
            $item->setParentId($parentId);
        }
    }

    /**
     * Retrieve an external iterator
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     * @since 5.0.0
     */
    public function getIterator()
    {
        yield from $this->data;
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
        return count($this->data);
    }
}
