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
        static $index = 0;

        $tareas = \App\Models\Tarea::all();

        if ($index >= count($tareas)) {
            $index = 1;
        }

        $tarea = $tareas[$index];
        $id_usuario = $tarea['id_usuario'];

        $result = [
            'id_usuario_creador' => $id_usuario,
            'id_usuario_asignado' => $id_usuario,
            'id_tarea' => $tarea['id'],
            'fecha_hora_asignacion' => now(),
        ];

        $index++;

        return $result;
    }
}
