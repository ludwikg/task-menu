<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MenusItemTest extends TestCase
{
    use RefreshDatabase;

    public function testItemCanNotBeAddedToMenuWhenThereIsNoMenu()
    {
        $response = $this->postJson('/api/menus/1/items', [['field' => 'Item1']]);
        $response->assertStatus(400);
        $response->assertExactJson(['error' => 'MenuItem can not be added, Menu with given Id probably does not exists']);
    }

    public function testItemsCanBeAddedToMenu()
    {
        $this->postJson('/api/menus', ['field' => 'Menu1']);
        $response = $this->postJson('/api/menus/1/items', [['field' => 'Item1']]);
        $response->assertStatus(200);
        $response->assertExactJson([['field' => 'Item1']]);
    }


    public function testItemsCanBeGet()
    {
        $this->postJson('/api/menus', ['field' => 'Menu1']);
        $response = $this->postJson('/api/menus/1/items', [['field' => 'Item1'], ['field' => 'Item2']]);
        $response->assertStatus(200);
        $response->assertExactJson([['field' => 'Item1'], ['field' => 'Item2']]);

        $response = $this->getJson('/api/menus/1/items');
        $response->assertStatus(200);
        $response->assertExactJson([['field' => 'Item1'], ['field' => 'Item2']]);
    }


    public function testItemsCanBeDeleted()
    {
        $this->postJson('/api/menus', ['field' => 'Menu1']);
        $response = $this->postJson('/api/menus/1/items', [['field' => 'Item1'], ['field' => 'Item2']]);
        $response->assertStatus(200);
        $response->assertExactJson([['field' => 'Item1'], ['field' => 'Item2']]);

        $response = $this->delete('/api/menus/1/items');
        $response->assertStatus(200);
        $response->assertExactJson(['success' => 'Items deleted']);

        $response = $this->getJson('/api/menus/1/items');
        $response->assertStatus(200);
        $response->assertExactJson([]);
    }


}
