<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreatePostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function admins_can_create_posts()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($admin = $this->createAdmin());

        $this->get('admin/posts/create')
            ->assertSuccessful()
            ->assertViewIs('admin.posts.create')
            ->assertSee('Crear post');

        $response = $this->post('admin/posts', [
            'title' => 'New post',
            'teaser' => 'The teaser',
            'content' => 'Content of the post',
            'user_id' => $admin->id
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('posts', [
            'title' => 'New post',
            'teaser' => 'The teaser',
            'content' => 'Content of the post',
            'user_id' => $admin->id
        ]);
    }

    /** @test */
    function authors_can_create_posts()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($user = $this->aUser());

        $user->assign('author');

        $this->get('admin/posts/create')
            ->assertSuccessful()
            ->assertSee('Crear post');

        $response = $this->post('admin/posts', [
            'title' => 'New post'
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('posts', [
            'title' => 'New post'
        ]);
    }

    /** @test */
    function unauthorized_users_cannot_create_posts()
    {
        $this->actingAs($user = $this->aUser());

        $this->get('admin/posts/create')
            ->assertStatus(403);

        $response = $this->post('admin/posts', [
            'title' => 'New post'
        ]);

        $response->assertStatus(403);

        $this->assertDatabaseEmpty('posts');
    }
}
