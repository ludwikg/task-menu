<?php

namespace Tests\Unit;

use App\Entities\ItemCollection;
use App\Entities\Item;
use App\Entities\MenuTreeNode;
use App\Repositories\ItemRepositoryInterface;
use App\Services\MenuLayerService;
use Tests\TestCase;

class MenuLayerServiceTest extends TestCase
{
    /**
     * Beside @see \App\Services\MenuLayerService
     * all other are just simple CRUDs, so unit testing will be just mocking repositories
     *
     * @return void
     */
    public function testMenuLayerServiceCanGetDepth()
    {
        $itemRepositoryMock = \Mockery::mock(ItemRepositoryInterface::class);
        $itemRepositoryMock->shouldReceive('findByMenuId')->andReturn($this->getItemCollection());

        $menuLayerService = new MenuLayerService($itemRepositoryMock);

        $itemCollectionOnLayer = $menuLayerService->show(10, 2);

        $this->assertEquals(4, count($itemCollectionOnLayer));
        $this->assertInstanceOf(ItemCollection::class, $itemCollectionOnLayer);
    }


    public function testMenuLayerServiceCanDeleteLayer()
    {
        $itemRepositoryMock = \Mockery::mock(ItemRepositoryInterface::class);
        $itemRepositoryMock->shouldReceive('findByMenuId')->andReturn($this->getItemCollection());
        $itemRepositoryMock->shouldReceive('updateCollection');
        $itemRepositoryMock->shouldReceive('delete');

        $menuLayerService = new MenuLayerService($itemRepositoryMock);

        $menuTree = $menuLayerService->destroy(10, 2);


        $this->assertEquals(4, count($menuTree));
        // find node 'id8 - level 3 item (parent = item 6)', now parent should be 2

        /** @var MenuTreeNode $node */
        foreach ($menuTree as $node) {
            if ($node->getItem()->getField()=='id8 - level 3 item (parent = item 6)'){
                $this->assertEquals(2, $node->getParentId());
                break;
            }
        }



    }


    private function getItemCollection(): ItemCollection
    {
        $itemCollection = new ItemCollection();
        $itemCollection->addItem(new Item(
            1,
            'id1 - level 1 item',
            10,
            null
        ));
        $itemCollection->addItem(new Item(
            2,
            'id2 - level 1 item',
            10,
            null
        ));
        $itemCollection->addItem(new Item(
            3,
            'id3 - level 2 item (parent = item 1)',
            10,
            1
        ));
        $itemCollection->addItem(new Item(
            4,
            'id4 - level 2 item (parent = item 1)',
            10,
            1
        ));
        $itemCollection->addItem(new Item(
            5,
            'id5 - level 2 item (parent = item 1)',
            10,
            1
        ));
        $itemCollection->addItem(new Item(
            6,
            'id6 - level 2 item (parent = item 2)',
            10,
            2
        ));
        $itemCollection->addItem(new Item(
            7,
            'id7 - level 3 item (parent = item 6)',
            10,
            6
        ));
        $itemCollection->addItem(new Item(
            8,
            'id8 - level 3 item (parent = item 6)',
            10,
            6
        ));

        return $itemCollection;
    }
}
