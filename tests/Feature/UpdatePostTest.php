<?php

namespace Tests\Feature;

use App\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdatePostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function admins_can_update_posts()
    {
        $this->withoutExceptionHandling();

        $post = factory(Post::class)->create();

        $admin = $this->createAdmin();

        $this->actingAs($admin);

        $response = $this->put("admin/posts/{$post->id}", [
            'title' => 'Updated post title',
        ]);

        $response->assertStatus(200)
            ->assertSee('¡Post actualizado!');

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Updated post title'
        ]);
    }

    /** @test */
    function authors_can_update_posts()
    {
        $this->withoutExceptionHandling();

        $user = $this->createUser();

        $post = factory(Post::class)->create([
            'user_id' => $user->id,
        ]);

        $this->actingAs($user);

        $response = $this->put("admin/posts/{$post->id}", [
            'title' => 'Updated post title',
        ]);

        $response->assertStatus(200)
            ->assertSee('¡Post actualizado!');

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Updated post title'
        ]);
    }

    /** @test */
    function unauthorized_users_cannot_update_posts()
    {
        $post = factory(Post::class)->create();

        $user = $this->createUser();

        $this->actingAs($user);

        $response = $this->put("admin/posts/{$post->id}", [
            'title' => 'Updated post title',
        ]);

        $response->assertStatus(403);

        $this->assertDatabaseMissing('posts', [
            'id' => $post->id,
            'title' => 'Updated post title'
        ]);
    }

    /** @test */
    function guest_cannot_update_posts()
    {
        // $this->withoutExceptionHandling();

        $post = factory(Post::class)->create();

        $response = $this->put("admin/posts/{$post->id}", [
            'title' => 'Updated post title',
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseMissing('posts', [
            'id' => $post->id,
            'title' => 'Updated post title'
        ]);
    }
}
