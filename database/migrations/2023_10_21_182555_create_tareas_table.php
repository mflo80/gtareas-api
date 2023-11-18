<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
            $table->bigInteger('id_usuario_modificacion');
            $table->foreignId('id_usuario')->constrained('users');
            $table->softDeletes();
        });

        Schema::create('tareas_registro', function (Blueprint $table) {
            $table->id();
            $table->string('evento');
            $table->bigInteger('id_tarea');
            $table->string('old_titulo')->nullable();
            $table->string('old_texto')->nullable();
            $table->dateTime('old_fecha_hora_creacion')->nullable();
            $table->dateTime('old_fecha_hora_inicio')->nullable();
            $table->dateTime('old_fecha_hora_fin')->nullable();
            $table->string('old_categoria')->nullable();
            $table->string('old_estado')->nullable();
            $table->bigInteger('old_id_usuario')->nullable();
            $table->string('new_titulo')->nullable();
            $table->string('new_texto')->nullable();
            $table->dateTime('new_fecha_hora_creacion')->nullable();
            $table->dateTime('new_fecha_hora_inicio')->nullable();
            $table->dateTime('new_fecha_hora_fin')->nullable();
            $table->string('new_categoria')->nullable();
            $table->string('new_estado')->nullable();
            $table->bigInteger('new_id_usuario')->nullable();
            $table->dateTime('fecha_hora_modificacion');
            $table->bigInteger('id_usuario_modificacion');
            $table->softDeletes();
        });

        DB::unprepared("
            CREATE TRIGGER after_tareas_insert
            AFTER INSERT
            ON tareas
            FOR EACH ROW
            BEGIN
                INSERT INTO tareas_registro(evento, id_tarea, old_titulo, old_texto, old_fecha_hora_creacion, old_fecha_hora_inicio, old_fecha_hora_fin, old_categoria, old_estado, old_id_usuario, new_titulo, new_texto, new_fecha_hora_creacion, new_fecha_hora_inicio, new_fecha_hora_fin, new_categoria, new_estado, new_id_usuario, fecha_hora_modificacion, id_usuario_modificacion)
                VALUES('Creada', NEW.id, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NEW.titulo, NEW.texto, NEW.fecha_hora_creacion, NEW.fecha_hora_inicio, NEW.fecha_hora_fin, NEW.categoria, NEW.estado, NEW.id_usuario, NOW(), NEW.id_usuario_modificacion);
            END"
        );

        DB::unprepared("
            CREATE TRIGGER after_tareas_update
            AFTER UPDATE
            ON tareas
            FOR EACH ROW
            BEGIN
                IF OLD.deleted_at IS NULL AND NEW.deleted_at IS NULL THEN
                    INSERT INTO tareas_registro(evento, id_tarea, old_titulo, old_texto, old_fecha_hora_creacion, old_fecha_hora_inicio, old_fecha_hora_fin, old_categoria, old_estado, old_id_usuario, new_titulo, new_texto, new_fecha_hora_creacion, new_fecha_hora_inicio, new_fecha_hora_fin, new_categoria, new_estado, new_id_usuario, fecha_hora_modificacion, id_usuario_modificacion)
                    VALUES('Modificada', OLD.id, OLD.titulo, OLD.texto, OLD.fecha_hora_creacion, OLD.fecha_hora_inicio, OLD.fecha_hora_fin, OLD.categoria, OLD.estado, OLD.id_usuario, NEW.titulo, NEW.texto, NEW.fecha_hora_creacion, NEW.fecha_hora_inicio, NEW.fecha_hora_fin, NEW.categoria, NEW.estado, NEW.id_usuario, NOW(), NEW.id_usuario_modificacion);
                END IF;
            END"
        );

        DB::unprepared("
            CREATE TRIGGER after_tareas_delete
            AFTER UPDATE
            ON tareas
            FOR EACH ROW
            BEGIN
                IF OLD.deleted_at IS NULL AND NEW.deleted_at IS NOT NULL THEN
                    INSERT INTO tareas_registro(evento, id_tarea, old_titulo, old_texto, old_fecha_hora_creacion, old_fecha_hora_inicio, old_fecha_hora_fin, old_categoria, old_estado, old_id_usuario, new_titulo, new_texto, new_fecha_hora_creacion, new_fecha_hora_inicio, new_fecha_hora_fin, new_categoria, new_estado, new_id_usuario, fecha_hora_modificacion, id_usuario_modificacion)
                    VALUES('Eliminada', OLD.id, OLD.titulo, OLD.texto, OLD.fecha_hora_creacion, OLD.fecha_hora_inicio, OLD.fecha_hora_fin, OLD.categoria, OLD.estado, OLD.id_usuario, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NOW(), OLD.id_usuario_modificacion);
                END IF;
            END"
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('tareas');
        Schema::dropIfExists('tareas_registro');
        DB::unprepared("DROP TRIGGER IF EXISTS after_tareas_insert");
        DB::unprepared("DROP TRIGGER IF EXISTS after_tareas_update");
        DB::unprepared("DROP TRIGGER IF EXISTS after_tareas_delete");
    }
};
