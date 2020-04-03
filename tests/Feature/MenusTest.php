<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MenusTest extends TestCase
{
    use RefreshDatabase;

    public function testMenusCanBePosted()
    {
        $response = $this->postJson('/api/menus', ['field' => 'Menu1']);

        $response->assertStatus(200);
        $response->assertExactJson(['field' => 'Menu1']);
    }

    public function testMenusCanNotBePostedAgain()
    {
        $this->postJson('/api/menus', ['field' => 'Menu1']);
        $response = $this->postJson('/api/menus', ['field' => 'Menu1']);

        $response->assertStatus(409);
        $response->assertExactJson(['error' => 'Menu with name Menu1 already exists']);
    }

    public function testMenusCanBeGet()
    {
        $this->postJson('/api/menus', ['field' => 'Menu2']);
        $response = $this->get('/api/menus/1');

        $response->assertStatus(200);
        $response->assertExactJson(['field' => 'Menu2']);
    }

    public function testMenusCanBeUpdatedByPut()
    {
        $this->postJson('/api/menus', ['field' => 'Menu3']);
        $response = $this->putJson('/api/menus/1', ['field' => 'Menu4']);
        $response->assertStatus(200);
        $response->assertExactJson(['field' => 'Menu4']);

        // check if data has been saved
        $response = $this->get('/api/menus/1');
        $response->assertExactJson(['field' => 'Menu4']);
    }

    public function testMenusCanBeUpdatedByPatch()
    {
        $this->postJson('/api/menus', ['field' => 'Menu3']);
        $response = $this->patchJson('/api/menus/1', ['field' => 'Menu4']);
        $response->assertStatus(200);
        $response->assertExactJson(['field' => 'Menu4']);

        // check if data has been saved
        $response = $this->get('/api/menus/1');
        $response->assertExactJson(['field' => 'Menu4']);
    }

    public function testMenusCanBeDeleted()
    {
        $this->postJson('/api/menus', ['field' => 'Menu5']);

        $response = $this->delete('/api/menus/1');
        $response->assertStatus(200);
        $response->assertExactJson(['success' => 'Menu deleted']);

        // check if data has been deleted
        $response = $this->get('/api/menus/1');
        $response->assertStatus(404);
        $response->assertExactJson(['error' => 'Menu with id 1 does not exist.']);
    }
}
