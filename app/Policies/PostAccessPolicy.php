<?php

namespace App\Policies;

use App\{Post, User};
use Illuminate\Auth\Access\{HandlesAuthorization, Response};

class PostAccessPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        //
    }

    /**
     * Determine whether the user can view any posts.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the post.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return mixed
     */
    public function view(User $user, Post $post)
    {
        //
    }

    /**
     * Determine whether the user can create posts.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the post.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return mixed
     */
    public function update(User $user, Post $post)
    {
        if ($user->isAn('editor')) {
            return Response::allow('Puedes editar este post porque eres un editor');
        }

        if ($user->isAn('author')) {
            if ($user->owns($post)) {
                return Response::allow('Eres el autor del post');
            }

            return Response::deny('No puedes editar este post porque no eres su autor');
        }

        return Response::deny('No dispones de permisos para editar ningún post');
    }

    /**
     * Determine whether the user can delete the post.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return mixed
     */
    public function delete(User $user, Post $post)
    {
        if ($user->can('delete-published', $post)) {
            return true;
        }

        return $post->isDraft() && $user->can('delete-draft', $post);
    }

    public function deleteAll()
    {
        return false;
    }

    /**
     * Determine whether the user can restore the post.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return mixed
     */
    public function restore(User $user, Post $post)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the post.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return mixed
     */
    public function forceDelete(User $user, Post $post)
    {
        //
    }
}
