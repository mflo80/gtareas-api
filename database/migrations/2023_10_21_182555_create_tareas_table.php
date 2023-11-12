<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tareas', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('texto');
            $table->dateTime('fecha_hora_creacion');
            $table->dateTime('fecha_hora_inicio');
            $table->dateTime('fecha_hora_fin');
            $table->enum('categoria', ['Análisis', 'Diseño', 'Implementación', 'Verificación', 'Mantenimiento'])->default('Análisis');
            $table->enum('estado', ['Activa', 'Atrasada', 'En espera', 'Cancelada', 'Finalizada'])->default('Activa');
            $table->foreignId('id_usuario')->constrained('users');
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tareas');
    }
};
