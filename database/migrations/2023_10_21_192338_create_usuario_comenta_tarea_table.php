<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usuario_comenta_tarea', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_usuario')->constrained('users');
            $table->foreignId('id_tarea')->constrained('tareas');
            $table->text('comentario');
            $table->dateTime('fecha_hora_creacion');
            $table->dateTime('fecha_hora_modificacion')->nullable();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuario_comenta_tarea');
    }
};
