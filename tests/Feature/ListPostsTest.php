<?php

namespace Tests\Feature;

use App\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ListPostsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admins_can_see_all_the_posts()
    {
        $this->withoutExceptionHandling();

        $post1 = factory(Post::class)->create();
        $post2 = factory(Post::class)->create();

        $this->actingAs($this->createAdmin());

        $response = $this->get('admin/posts');

        $response->assertStatus(200)
            ->assertViewIs('admin.posts.index')
            ->assertViewHas('posts', function ($posts) use ($post1, $post2) {
                return $posts->contains($post1) && $posts->contains($post2);
        });

        $this->assertNotRepeatedQueries();
    }

    /** @test */
    public function authors_can_only_see_their_posts()
    {
        $this->withoutExceptionHandling();

        $user = $this->aUser();

        $post1ByCurrentUser = factory(Post::class)->create(['user_id' => $user->id]);
        $post2ByAnotherUser = factory(Post::class)->create();
        $post3ByCurrentUser = factory(Post::class)->create(['user_id' => $user->id]);
        $post4ByAnotherUser = factory(Post::class)->create();

        $this->actingAs($user);

        $response = $this->get('admin/posts');

        $response->assertStatus(200)->assertViewIs('admin.posts.index');

        $response->assertViewCollection('posts')
            ->contains($post1ByCurrentUser)
            ->contains($post3ByCurrentUser)
            ->notContains($post2ByAnotherUser)
            ->notContains($post4ByAnotherUser);

    }
}
