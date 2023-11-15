<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $cantidadTareas = 250;

        \App\Models\Tarea::factory($cantidadTareas)->create();
        \App\Models\UsuarioCreaTarea::factory($cantidadTareas)->create();
        \App\Models\UsuarioAsignaTarea::factory(400)->create();
    }
}
