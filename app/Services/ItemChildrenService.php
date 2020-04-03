<?php
declare(strict_types = 1);

namespace App\Services;

use App\Dto\ItemChildrenPostPayload;
use App\Entities\ItemCollection;
use App\Entities\ItemCollectionFactory;
use App\Exceptions\InvalidArgumentException;
use App\Repositories\ItemRepositoryInterface;
use Illuminate\Foundation\PackageManifest;

class ItemChildrenService
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

    public function store(ItemChildrenPostPayload $itemChildrenPostPayload): ItemCollection
    {
        // get parent to check if exists and get menu Id
        $itemId = $itemChildrenPostPayload->getParentId();
        $item = $this->itemRepository->findById($itemId);
        if ($item === null) {
            throw new InvalidArgumentException('Item with id ' . $itemId . ' does not exist');
        }
        $itemCollection = ItemCollectionFactory::createFromPayload(
            $itemChildrenPostPayload->getData(),
            $item->getMenuId(),
            $item->getId()
        );

        $itemCollection = $this->itemRepository->saveCollection($itemCollection);

        return $itemCollection;
    }

    public function show(int $parentId): ItemCollection
    {
        return $this->itemRepository->findByParentId($parentId);
    }

    public function destroy(int $parentId)
    {
        $this->itemRepository->deleteByParentId($parentId);
    }
}
