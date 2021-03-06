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

        $this->get("admin/posts/{$post->id}/edit")
            ->assertSuccessful()
            ->assertSee("Editar post {$post->id}");

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
    function editors_can_update_posts()
    {
        $this->withoutExceptionHandling();

        $user = $this->aUser();

        $user->assign('editor');

        $post = factory(Post::class)->create();

        $this->actingAs($user);

        $this->get("admin/posts/{$post->id}/edit")
            ->assertSuccessful()
            ->assertSee("Editar post {$post->id}");

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
    function authors_can_update_posts_they_own()
    {
        $this->withoutExceptionHandling();

        $user = $this->aUser();

        $user->assign('author');

        $post = factory(Post::class)->create([
            'user_id' => $user->id,
        ]);

        $this->actingAs($user);

        $this->get("admin/posts/{$post->id}/edit")
            ->assertSuccessful()
            ->assertSee("Editar post {$post->id}");

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
    function authors_cannot_update_posts_they_dont_own()
    {
        $user = $this->aUser();

        $user->assign('author');

        $post = factory(Post::class)->create();

        $this->actingAs($user);

        $this->get("admin/posts/{$post->id}/edit")
            ->assertStatus(403);

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
    function unauthorized_users_cannot_update_posts()
    {
        $post = factory(Post::class)->create();

        $user = $this->aUser();

        $this->actingAs($user);

        $this->get("admin/posts/{$post->id}/edit")
            ->assertStatus(403)
            ->assertSee('No dispones de permisos para editar ningún post');

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

        $response->assertRedirect('login');

        $this->assertDatabaseMissing('posts', [
            'id' => $post->id,
            'title' => 'Updated post title'
        ]);
    }
}
