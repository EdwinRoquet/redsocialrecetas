<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name'=> 'Edwin Roquet Flores',
            'email'=> 'correo@correo.com',
            'password'=> Hash::make('12345678'),
            'url'=> 'https://as.com/meristation/imagenes/2020/03/11/noticias/1583907550_650115_1583907595_noticia_normal.jpg',
        ]);
        // $user->perfil()->create();

        $user2 = User::create([
            'name'=> 'Jacob Roquet',
            'email'=> 'correo2@correo2.com',
            'password'=> Hash::make('12345678'),
            'url'=> 'https://as.com/meristation/imagenes/2020/03/11/noticias/1583907550_650115_1583907595_noticia_normal.jpg',
        ]);
        // $user2->perfil()->create();


    }
}
