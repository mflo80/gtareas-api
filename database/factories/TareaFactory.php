<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
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
        $fecha_hora_inicio = Carbon::instance($this->faker->dateTimeBetween('2023-01-01 00:00:00', now()->addMinutes(60)));
        $dias = $this->faker->numberBetween(1, 120);

        return [
            'titulo' => $this->faker->text(20),
            'texto' => $this->faker->text(120),
            'fecha_hora_creacion' => now(),
            'fecha_hora_inicio' => $fecha_hora_inicio->format('Y-m-d H:i:s'),
            'fecha_hora_fin' => $fecha_hora_inicio->addDays($dias)->format('Y-m-d H:i:s'),
            'categoria' => $this->faker->randomElement(['Análisis', 'Diseño', 'Implementación', 'Verificación', 'Mantenimiento']),
            'estado' => $this->faker->randomElement(['Activa', 'Atrasada', 'En espera', 'Cancelada', 'Finalizada']),
            'id_usuario_modificacion' => $idUsuario,
            'id_usuario' => $idUsuario,
        ];
    }
}
