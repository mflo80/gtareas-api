<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('usuario_asigna_tarea', function (Blueprint $table) {
            $table->foreignId('id_usuario_creador')->constrained('users');
            $table->foreignId('id_usuario_asignado')->constrained('users');
            $table->foreignId('id_tarea')->constrained('tareas');
            $table->dateTime('fecha_hora_asignacion');
            $table->dateTime('fecha_hora_expiracion');
            $table->enum('permiso', ['0', '1', '2'])->default('2');
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuario_asigna_tarea');
    }
};
