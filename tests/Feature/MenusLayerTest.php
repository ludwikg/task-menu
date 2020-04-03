<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MenusLayerTest extends TestCase
{
    use RefreshDatabase;

    public function testItemCanBeDisplayedByLayer()
    {
        $this->postJson('/api/menus/', ['field' => 'Menu1']);
        $this->postJson('/api/items', ['field' => 'Item1 - level 1', 'menuId' => 1]);
        $this->postJson('/api/items', ['field' => 'Item2 - level 1', 'menuId' => 1]);
        $this->postJson('/api/items', ['field' => 'Item3 - level 1', 'menuId' => 1]);
        $this->postJson('/api/items', ['field' => 'Item4 - level 1', 'menuId' => 1]);

        $this->postJson('/api/items/1/children', [['field' => 'Item 5 - level 2'], ['field' => 'Item 6 - level 2']]);
        $this->postJson('/api/items/2/children', [['field' => 'Item 7 - level 2'], ['field' => 'Item 7 - level 2']]);

        $this->postJson('/api/items/5/children', [['field' => 'Item 8 - level 3']]);


        $response = $this->get('/api/menus/1/layers/2');
        $response->assertStatus(200);
        $response->assertExactJson([
            ['field' => 'Item 5 - level 2'],
            ['field' => 'Item 6 - level 2'],
            ['field' => 'Item 7 - level 2'],
            ['field' => 'Item 7 - level 2'],
        ]);
    }

    public function testItemCanBeDeletedByLayer()
    {
        $this->postJson('/api/menus/', ['field' => 'Menu1']);
        $this->postJson('/api/items', ['field' => 'Item1 - level 1', 'menuId' => 1]);
        $this->postJson('/api/items', ['field' => 'Item2 - level 1', 'menuId' => 1]);
        $this->postJson('/api/items', ['field' => 'Item3 - level 1', 'menuId' => 1]);
        $this->postJson('/api/items', ['field' => 'Item4 - level 1', 'menuId' => 1]);

        $this->postJson('/api/items/1/children', [['field' => 'Item 5 - level 2'], ['field' => 'Item 6 - level 2']]);
        $this->postJson('/api/items/2/children', [['field' => 'Item 7 - level 2'], ['field' => 'Item 7 - level 2']]);

        $this->postJson('/api/items/5/children', [['field' => 'Item 8 - level 3']]);

        $response = $this->delete('/api/menus/1/layers/2');
        $response->assertStatus(200);
        $response->assertExactJson(['success' => 'Layer Removed']);

        $response = $this->get('/api/menus/1/layers/2');
        $response->assertStatus(200);
        $response->assertExactJson([
            ['field' => 'Item 8 - level 3'],
        ]);

        $response = $this->get('/api/items/1/children');
        $response->assertStatus(200);
        $response->assertExactJson([['field' => 'Item 8 - level 3']]);
    }
}
