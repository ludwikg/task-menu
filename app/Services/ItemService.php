<?php
declare(strict_types = 1);

namespace App\Services;

use App\Entities\Item;
use App\Entities\ItemFactory;
use App\Entities\ItemMapper;
use App\Exceptions\ConflictException;
use App\Exceptions\InvalidArgumentException;
use App\Exceptions\ResourceNotFoundException;
use App\Repositories\ItemRepositoryInterface;

class ItemService
{
    /**
     * @var ItemRepositoryInterface
     */
    private $itemRepository;

    public function __construct(
        ItemRepositoryInterface $itemRepository
    ) {
        $this->itemRepository = $itemRepository;
    }

    public function store(Item $item): void
    {
        // check if there is no such entry already
        $alreadyExists = $this->itemRepository->doesExist($item);
        if ($alreadyExists) {
            throw new ConflictException('Item already exists');
        }

        $this->itemRepository->save($item);
    }

    public function show(int $itemId): Item
    {
        $item = $this->itemRepository->findById($itemId);

        if ($item === null) {
            throw new ResourceNotFoundException('Item with id ' . $itemId . ' does not exist.');
        }

        return $item;
    }

    public function update(int $itemId, Item $item): void
    {
        $alreadyExists = $this->itemRepository->doesExistById($itemId);

        if (!$alreadyExists) {
            throw new InvalidArgumentException('Item with id ' . $itemId . ' does not exist');
        }

        $item = ItemFactory::createFromItemAndItemId($item, $itemId);
        $this->itemRepository->update($item);
    }

    public function delete(int $itemId): void
    {
        $this->itemRepository->delete($itemId);
    }
}
