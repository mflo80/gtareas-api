<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class TareaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $idUsuario = $this->faker->numberBetween(1, 20);

        return [
            'titulo' => $this->faker->text(20),
            'texto' => $this->faker->text(120),
            'fecha_hora_creacion' => now(),
            'fecha_hora_inicio' => now(),
            'fecha_hora_fin' => now()->addDays(7),
            'categoria' => $this->faker->randomElement(['Análisis', 'Diseño', 'Implementación', 'Verificación', 'Mantenimiento']),
            'estado' => $this->faker->randomElement(['Activa', 'Atrasada', 'En espera', 'Cancelada', 'Finalizada']),
            'id_usuario_modificacion' => $idUsuario,
            'id_usuario' => $idUsuario,
        ];
    }
}
