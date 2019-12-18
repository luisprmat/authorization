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

        $response = $this->post('admin/posts', [
            'title' => 'New post'
        ]);

        $response->assertStatus(200)->assertSee('Post created');

        $this->assertDatabaseHas('posts', [
            'title' => 'New post'
        ]);
    }

    /** @test */
    function authors_can_create_posts()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($user = $this->aUser());

        $user->assign('author');

        $response = $this->post('admin/posts', [
            'title' => 'New post'
        ]);

        $response->assertStatus(200)
            ->assertSee('Post created');

        $this->assertDatabaseHas('posts', [
            'title' => 'New post'
        ]);
    }

    /** @test */
    function unauthorized_users_cannot_create_posts()
    {
        $this->actingAs($user = $this->aUser());

        $response = $this->post('admin/posts', [
            'title' => 'New post'
        ]);

        $response->assertStatus(403);

        $this->assertDatabaseEmpty('posts');
    }
}
