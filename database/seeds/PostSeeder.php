<?php

use App\{User, Post};
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Post::class)->times(7)->create([
            'user_id' => User::where('email', 'luisprmat@gmail.com')->first()->id,
        ]);

        factory(Post::class)->times(20)->create();
    }
}
