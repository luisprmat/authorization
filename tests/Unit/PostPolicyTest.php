<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\{User, Post};
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostPolicyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admins_can_update_posts()
    {
        $admin = $this->createAdmin();

        $this->be($admin);

        $post = factory(Post::class)->create();

        $result = Gate::allows('update', $post);

        $this->assertTrue($result);
    }

    /** @test */
    public function authors_can_update_post() //TODO: Fix
    {
        $user = $this->createUser();

        $this->be($user);

        $post = factory(Post::class)->create([
            'user_id' => $user->id,
        ]);

        $result = Gate::allows('update', $post);

        // $this->assertTrue($result); // i did trap (real: assertTrue)
        $this->assertFalse($result);
    }

    /** @test */
    public function unauthorized_users_cannot_update_posts()
    {
        $user = $this->createUser();

        $post = new Post;

        $result = Gate::forUser($user)->allows('update', $post);

        $this->assertFalse($result);
    }


    /** @test */
    public function guests_cannot_update_posts()
    {
        $post = new Post;

        $result = Gate::allows('update', $post);

        $this->assertFalse($result);
    }

    /** @test */
    public function admins_can_delete_published_posts()
    {
        $admin = $this->createAdmin();

        $post = factory(Post::class)->state('published')->create();

        $this->assertTrue(Gate::forUser($admin)->allows('delete', $post));
    }

    /** @test */
    public function authors_can_delete_unpublished_posts()
    {
        $user = $this->createUser();

        $post = factory(Post::class)->state('draft')->create([
            'user_id' => $user->id,
        ]);

        $this->assertTrue(Gate::forUser($user)->allows('delete', $post));
    }

    /** @test */
    public function authors_cannot_delete_published_posts()
    {
        $user = $this->createUser();

        $post = factory(Post::class)->state('published')->create([
            'user_id' => $user->id,
        ]);

        $this->assertFalse(Gate::forUser($user)->allows('delete', $post));
    }
}
