<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class Items extends TestCase
{
    use RefreshDatabase;

    public function testItemCanBePosted()
    {
        $response = $this->postJson('/api/menus', ['field' => 'Menu1']);
        $response->assertStatus(200);
        $response->assertExactJson(['field' => 'Menu1']);

        $response = $this->postJson('/api/items', ['field' => 'Item1', 'menuId' => 1]);
        $response->assertStatus(200);
        $response->assertExactJson(['field' => 'Item1']);
    }

    public function testItemCanNotBePostedAgain()
    {
        $response = $this->postJson('/api/menus', ['field' => 'Menu1']);
        $response->assertStatus(200);
        $response->assertExactJson(['field' => 'Menu1']);

        $this->postJson('/api/items', ['field' => 'Item1', 'menuId' => 1]);
        $response = $this->postJson('/api/items', ['field' => 'Item1', 'menuId' => 1]);
        $response->assertStatus(409);
        $response->assertExactJson(['error' => 'Item already exists']);
    }

    public function testItemCanBeGet()
    {
        $this->postJson('/api/menus', ['field' => 'Menu1']);
        $this->postJson('/api/items', ['field' => 'Item1', 'menuId' => 1]);

        $response = $this->get('/api/items/1');
        $response->assertStatus(200);
        $response->assertExactJson(['field' => 'Item1']);
    }

    public function testItemCanBeUpdateByPut()
    {
        $this->postJson('/api/menus', ['field' => 'Menu1']);
        $this->postJson('/api/items', ['field' => 'Item1', 'menuId' => 1]);


        $response = $this->putJson('/api/items/1', ['field' => 'ItemNew', 'menuId' => 1]);
        $response->assertStatus(200);
        $response->assertExactJson(['field' => 'ItemNew']);

        $response = $this->get('/api/items/1');
        $response->assertStatus(200);
        $response->assertExactJson(['field' => 'ItemNew']);
    }

    public function testItemCanBeUpdatedByPath()
    {
        $this->postJson('/api/menus', ['field' => 'Menu1']);
        $this->postJson('/api/items', ['field' => 'Item1', 'menuId' => 1]);


        $response = $this->patchJson('/api/items/1', ['field' => 'ItemNew', 'menuId' => 1]);
        $response->assertStatus(200);
        $response->assertExactJson(['field' => 'ItemNew']);

        $response = $this->get('/api/items/1');
        $response->assertStatus(200);
        $response->assertExactJson(['field' => 'ItemNew']);
    }

    public function testItemCanBeDeleted()
    {
        $this->postJson('/api/menus', ['field' => 'Menu1']);
        $this->postJson('/api/items', ['field' => 'Item1', 'menuId' => 1]);

        $response = $this->delete('/api/items/1');
        $response->assertStatus(200);
        $response->assertExactJson(['success' => 'Item deleted']);
    }

    public function testItemCanNotBeDeletedTwice()
    {
        $this->postJson('/api/menus', ['field' => 'Menu1']);
        $this->postJson('/api/items', ['field' => 'Item1', 'menuId' => 1]);

        $response = $this->delete('/api/items/1');
        $response->assertStatus(200);
        $response->assertExactJson(['success' => 'Item deleted']);
    }
}
