<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ItemsChildrenTest extends TestCase
{
    use RefreshDatabase;

    public function testChildrenCanBePosted()
    {
        $this->postJson('/api/menus', ['field' => 'Menu1']);
        $this->postJson('/api/items', ['field' => 'Item1', 'menuId' => 1]);

        $response = $this->postJson('/api/items/1/children', [['field' => 'Child1'], ['field' => 'Child2']]);
        $response->assertStatus(200);
        $response->assertExactJson([['field' => 'Child1'], ['field' => 'Child2']]);
    }

    public function testChildrenCanBeGet()
    {
        $this->postJson('/api/menus', ['field' => 'Menu1']);
        $this->postJson('/api/items', ['field' => 'Item1', 'menuId' => 1]);
        $this->postJson('/api/items/1/children', [['field' => 'Child1'], ['field' => 'Child2']]);

        $response = $this->get('/api/items/1/children');
        $response->assertStatus(200);
        $response->assertExactJson([['field' => 'Child1'], ['field' => 'Child2']]);
    }

    public function testChildrenCanBeDeleted()
    {
        $this->postJson('/api/menus', ['field' => 'Menu1']);
        $this->postJson('/api/items', ['field' => 'Item1', 'menuId' => 1]);
        $this->postJson('/api/items/1/children', [['field' => 'Child1'], ['field' => 'Child2']]);

        $response = $this->delete('/api/items/1/children');
        $response->assertStatus(200);
        $response->assertExactJson(['success' => 'Items deleted']);

        $response = $this->get('/api/items/1/children');
        $response->assertStatus(200);
        $response->assertExactJson([]);
    }
}
