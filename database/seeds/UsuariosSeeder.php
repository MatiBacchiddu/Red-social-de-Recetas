<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Juan',
            'email' => 'correo@correo.com',
            'password' => Hash::make('12345678'),
            'url' => 'http://codigoconjuan.com',
        ]);

      
        $user2 = User::create([
            'name' => 'Pablo',
            'email' => 'correo2@correo.com',
            'password' => Hash::make('12345678'),
            'url' => 'http://codigoconjuan.com',
        ]);

        $user2->perfil()->create();

        
    }
}

