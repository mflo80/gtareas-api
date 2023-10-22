<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('historial', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_usuario')->constrained('users');
            $table->foreignId('id_tarea')->constrained('tareas');
            $table->dateTime('fecha_hora_modificacion');
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('historial');
    }
};
