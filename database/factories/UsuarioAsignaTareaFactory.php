<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UsuarioAsignaTareaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $id_usuario_creador = $this->faker->numberBetween(1, 21);
        $id_usuario_asignado = $this->faker->numberBetween(1, 21);
        $id_tarea = $this->faker->numberBetween(1, 250);

        while ($id_usuario_creador == $id_usuario_asignado) {
            $id_usuario_asignado = $this->faker->numberBetween(1, 21);
        }

        $asignacionExistente = \App\Models\UsuarioAsignaTarea::where('id_tarea', $id_tarea)
                                                        ->where('id_usuario_creador', $id_usuario_creador)
                                                        ->where('id_usuario_asignado', $id_usuario_asignado)
                                                        ->first();

        if ($asignacionExistente) {
            return [];
        }

        $creadorExistente = \App\Models\UsuarioAsignaTarea::where('id_tarea', $id_tarea)
                                                        ->where('id_usuario_creador', $id_usuario_creador)
                                                        ->first();

        if ($creadorExistente){
            return [
                'id_usuario_creador' => $id_usuario_creador,
                'id_usuario_asignado' => $id_usuario_asignado,
                'id_tarea' => $id_tarea,
                'fecha_hora_asignacion' => now(),
            ];
        }

        return [];
    }
}
