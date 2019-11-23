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

        $result = Gate::allows('update-post', $post);

        $this->assertTrue($result);
    }

    /** @test */
    public function authors_can_update_posts()
    {
        $user = $this->createUser();

        $this->be($user);

        $post = factory(Post::class)->create([
            'user_id' => $user->id,
        ]);

        $result = Gate::allows('update-post', $post);

        $this->assertTrue($result);
    }

    /** @test */
    public function unauthorized_users_cannot_update_posts()
    {
        $user = $this->createUser();

        $post = new Post;

        $result = Gate::forUser($user)->allows('update-post', $post);

        $this->assertFalse($result);
    }


    /** @test */
    public function guests_cannot_update_posts()
    {
        $post = new Post;

        $result = Gate::allows('update-post', $post);

        $this->assertFalse($result);
    }
}
