<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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

        Schema::create('comentarios_historial', function (Blueprint $table) {
            $table->id();
            $table->string('evento');
            $table->bigInteger('id_comentario');
            $table->bigInteger('id_usuario')->nullable();
            $table->bigInteger('id_tarea')->nullable();
            $table->dateTime('fecha_hora_creacion')->nullable();
            $table->string('old_comentario')->nullable();
            $table->string('new_comentario')->nullable();
            $table->dateTime('fecha_hora_modificacion')->nullable();
            $table->softDeletes();
        });

        DB::unprepared("
            CREATE TRIGGER after_comentarios_insert
            AFTER INSERT
            ON usuario_comenta_tarea
            FOR EACH ROW
            BEGIN
                INSERT INTO comentarios_historial(evento, id_comentario, id_usuario, id_tarea, fecha_hora_creacion, old_comentario, new_comentario, fecha_hora_modificacion)
                VALUES('Creado', NEW.id, NEW.id_usuario, NEW.id_tarea, NEW.fecha_hora_creacion, NULL, NEW.comentario, NOW());
            END"
        );

        DB::unprepared("
            CREATE TRIGGER after_comentarios_update
            AFTER UPDATE
            ON usuario_comenta_tarea
            FOR EACH ROW
            BEGIN
                IF OLD.deleted_at IS NULL AND NEW.deleted_at IS NULL THEN
                    INSERT INTO comentarios_historial(evento, id_comentario, id_usuario, id_tarea, fecha_hora_creacion, old_comentario, new_comentario, fecha_hora_modificacion)
                    VALUES('Modificado', NEW.id, NEW.id_usuario, NEW.id_tarea, NEW.fecha_hora_creacion, OLD.comentario, NEW.comentario, NOW());
                END IF;
            END"
        );

        DB::unprepared("
            CREATE TRIGGER after_comentarios_delete
            AFTER UPDATE
            ON usuario_comenta_tarea
            FOR EACH ROW
            BEGIN
                IF OLD.deleted_at IS NULL AND NEW.deleted_at IS NOT NULL THEN
                    INSERT INTO comentarios_historial(evento, id_comentario, id_usuario, id_tarea, fecha_hora_creacion, old_comentario, new_comentario, fecha_hora_modificacion)
                    VALUES('Eliminado', NEW.id, NEW.id_usuario, NEW.id_tarea, NEW.fecha_hora_creacion, OLD.comentario, NULL, NOW());
                END IF;
            END"
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('usuario_comenta_tarea');
        DB::unprepared("DROP TRIGGER IF EXISTS after_comentarios_insert");
        DB::unprepared("DROP TRIGGER IF EXISTS after_comentarios_update");
        DB::unprepared("DROP TRIGGER IF EXISTS after_comentarios_delete");
    }
};
