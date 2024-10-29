<?php

namespace Tests\Feature\Http\Controllers\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_store()
    {
        // $this->withoutExceptionHandling();

        $this->artisan('db:seed', ['--class' => 'DatabaseSeeder']);

        $response = $this->json('POST', '/api/posts', [
            'user_id' => 1,
            'title'  => 'Testing Post',
            'body' => 'test'
        ]);

        $response->assertJsonStructure(['id', 'title', 'created_at', 'updated_at'])
            ->assertJson(['title' => 'Testing Post'])
            ->assertStatus(201); // http OK 201 created
        
        $this->assertDatabaseHas('posts', ['title' => 'Testing Post']);
    }

    public function test_validate_title()
    {
        $this->artisan('db:seed', ['--class' => 'DatabaseSeeder']);

        $response = $this->json('POST', '/api/posts', [
            'user_id' => 1,
            'title'  => ''
        ]);

        // Request OK but imposible to be completed
        $response->assertStatus(422)
            ->assertJsonValidationErrors('title');
    }
}
