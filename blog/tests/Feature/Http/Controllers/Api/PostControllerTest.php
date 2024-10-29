<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Post;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_store()
    {
        // $this->withoutExceptionHandling();

        $user = factory(User::class)->create();

        $response = $this->json('POST', '/api/posts', [
            'user_id' => $user->id,
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
        $user = factory(User::class)->create();

        $response = $this->json('POST', '/api/posts', [
            'user_id' => $user->id,
            'title'  => ''
        ]);

        // Request OK but imposible to be completed
        $response->assertStatus(422)
            ->assertJsonValidationErrors('title');
    }

    public function test_show()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create();

        $response = $this->json('GET', "/api/posts/{$post->id}");

        $response->assertJsonStructure(['id', 'title', 'created_at', 'updated_at'])
            ->assertJson(['title' => $post->title])
            ->assertStatus(200); // http OK
    }

    public function test_404_show()
    {
        $response = $this->json('GET', '/api/posts/1000');

        $response->assertStatus(404); // http not found
    }

    public function test_update()
    {
        // $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create();

        $response = $this->json('PUT', "/api/posts/{$post->id}", [
            'title'  => 'Testing Post Updated',
            'body' => 'test 2'
        ]);

        $response->assertJsonStructure(['id', 'title', 'created_at', 'updated_at'])
            ->assertJson(['title' => 'Testing Post Updated'])
            ->assertStatus(200); // http OK 200
        
        $this->assertDatabaseHas('posts', ['title' => 'Testing Post Updated']);
    }

    public function test_delete()
    {
        // $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create();

        $response = $this->json('DELETE', "/api/posts/{$post->id}");

        $response->assertSee(null)
            ->assertStatus(204); // http ok non-content
        
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }

    public function test_index()
    {
        factory(User::class)->create();
        factory(Post::class, 5)->create();

        $response = $this->json('GET', 'api/posts');

        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'title', 'created_at', 'updated_at']
            ]
        ])->assertStatus(200);
    }
}
