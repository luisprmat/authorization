<?php

use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = factory(User::class)->create([
            'name' => 'Administrador',
            'email' => 'admin@gmail.com'
        ]);

        $admin->assign('admin');

        $user = factory(User::class)->create([
            'name' => 'Luis Antonio Parrado',
            'email' => 'luisprmat@gmail.com',
            'password' => '$2y$10$ObpYZqdhJ9lXFRjAC085W.jRmJMCJFxGNNGlJzfaBXti0e12NkBj2' //lpklprplus
        ]);
        $user->assign('author');
    }
}
