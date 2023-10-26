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
            $table->enum('estado', ['activa', 'cancelada', 'en espera', 'finalizada', 'incompleta'])->default('en espera');
            $table->foreignId('id_usuario')->constrained('users');
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tareas');
    }
};
