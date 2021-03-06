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
        $this->createAdmin();

        $this->createAuthor();

        $this->createUser();
    }

    protected function createAdmin()
    {
        $admin = factory(User::class)->create([
            'name' => 'Administrador',
            'email' => 'admin@gmail.com'
        ]);

        $admin->assign('admin');
    }

    protected function createAuthor()
    {
        $user = factory(User::class)->create([
            'name' => 'Luis Antonio Parrado',
            'email' => 'luisprmat@gmail.com',
            'password' => '$2y$10$ObpYZqdhJ9lXFRjAC085W.jRmJMCJFxGNNGlJzfaBXti0e12NkBj2' //lpklprplus
        ]);
        $user->assign('author');
    }

    protected function createUser()
    {
        $user = factory(User::class)->create([
            'name' => 'Natalia Manrique',
            'email' => 'natis_andru@hotmail.com',
            'password' => '$2y$10$xTMERYEyKNCiWMAozt/mpuwxOOIGosd24sbNcNiIo4gw0LVE7kSrC' //12345678
        ]);
    }

}
