<?php

namespace Database\Seeders;

use App\Models\Entry;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        User::factory()->admin()
                       ->has(Entry::factory()->count(30))
                       ->create(['name' => 'Administrador', 'email' => 'admin@demo.com']);

        User::factory()->manager()
                       ->has(Entry::factory()->count(30))
                       ->create(['name' => 'Gerencia', 'email' => 'gerencia@demo.com']);

        User::factory()->usersample()
                       ->has(Entry::factory()->count(30))
                       ->create(['name' => 'Usuario', 'email' => 'usuario@demo.com']);

        User::factory()->count(5)
                       ->has(Entry::factory()->count(30))
                       ->create();
    }
}
