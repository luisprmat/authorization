<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\{User, Post};
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class),
    ];
});

$factory->state(Post::class, 'draft', ['status' => 'draft']);
$factory->state(Post::class, 'published', ['status' => 'published']);
