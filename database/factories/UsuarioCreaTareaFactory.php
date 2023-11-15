<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UsuarioCreaTareaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $id_tarea = 1;

        $id_usuario_creador = $this->faker->numberBetween(1, 21);

        return [
            'id_usuario_creador' => $id_usuario_creador,
            'id_usuario_asignado' => $id_usuario_creador,
            'id_tarea' => $id_tarea++,
            'fecha_hora_asignacion' => now(),
        ];
    }
}
