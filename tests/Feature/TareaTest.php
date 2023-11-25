<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class TareaTest extends TestCase
{
    use WithoutMiddleware;

    public function test_guardar()
    {
        $datos = [
            'titulo' => 'Título de prueba',
            'texto' => 'Texto de prueba',
            'fecha_hora_creacion' => now()->format('Y-m-d H:i:s'),
            'fecha_hora_inicio' => now()->format('Y-m-d H:i:s'),
            'fecha_hora_fin' => now()->addDay()->format('Y-m-d H:i:s'),
            'categoria' => 'Diseño',
            'estado' => 'Activa',
            'id_usuario_modificacion' => 21,
            'id_usuario' => 21,
        ];

        $response = $this->postJson('api/tareas', $datos);
        $datos = $response->json();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(true, $response->getData()->status);
        $this->assertDatabaseHas('tareas', ['titulo' => 'Título de prueba']);
    }

    public function test_buscar()
    {
        $response = $this->getJson('api/tareas');

        $this->assertEquals(200, $response->getStatusCode());

        $response->assertJsonFragment([
            'status' => true,
            'message' => 'Tareas encontradas.'
        ]);
    }

    public function test_buscar_por_id()
    {
        $response = $this->getJson('api/tareas/2');

        $this->assertEquals(200, $response->getStatusCode());

        $response->assertJsonFragment([
            'status' => true,
            'message' => 'Tarea encontrada.'
        ]);
    }

    public function test_buscar_por_id_inexistente()
    {
        $response = $this->getJson('api/tareas/1000');

        $this->assertEquals(404, $response->getStatusCode());

        $response->assertJsonFragment([
            'status' => false,
            'message' => 'Tarea no encontrada.'
        ]);
    }

    public function test_modificar()
    {
        $datos = [
            'titulo' => 'Título de prueba actualizado',
            'texto' => 'Texto de prueba actualizado',
            'fecha_hora_creacion' => now()->format('Y-m-d H:i:s'),
            'fecha_hora_inicio' => now()->format('Y-m-d H:i:s'),
            'fecha_hora_fin' => now()->addDay()->format('Y-m-d H:i:s'),
            'categoria' => 'Diseño',
            'estado' => 'En espera',
            'id_usuario_modificacion' => 21,
            'id_usuario' => 21,
        ];

        $response = $this->putJson('api/tareas/251', $datos);

        $this->assertEquals(200, $response->getStatusCode());

        $response->assertJsonFragment([
            'status' => true,
            'message' => 'Tarea modificada correctamente.'
        ]);
    }

    public function test_modificar_categoria()
    {
        $datos = [
            'titulo' => 'Título de prueba actualizado',
            'texto' => 'Texto de prueba actualizado',
            'fecha_hora_creacion' => now()->format('Y-m-d H:i:s'),
            'fecha_hora_inicio' => now()->format('Y-m-d H:i:s'),
            'fecha_hora_fin' => now()->addDay()->format('Y-m-d H:i:s'),
            'categoria' => 'Análisis',
            'estado' => 'En espera',
            'id_usuario_modificacion' => 21,
            'id_usuario' => 21,
        ];

        $response = $this->putJson('api/tareas/categoria/251', $datos);

        $this->assertEquals(200, $response->getStatusCode());

        $response->assertJsonFragment([
            'status' => true,
            'message' => 'Categoría modificada correctamente.'
        ]);
    }


    public function test_modificar_incorrecto()
    {
        $datos = [
            'titulo' => 'Título de prueba actualizado',
            'texto' => 'Texto de prueba actualizado',
            'fecha_hora_creacion' => now()->format('Y-m-d H:i:s'),
            'fecha_hora_inicio' => now()->format('Y-m-d H:i:s'),
            'fecha_hora_fin' => now()->addDay()->format('Y-m-d H:i:s'),
            'categoria' => 'Diseño',
            'estado' => 'Otros',
            'id_usuario_modificacion' => 21,
            'id_usuario' => 21,
        ];

        $response = $this->putJson('api/tareas/251', $datos);

        $this->assertEquals(500, $response->getStatusCode());

        $response->assertJsonFragment([
            'status' => false,
        ]);
    }

    public function test_modificar_tarea_inexistente()
    {
        $datos = [
            'titulo' => 'Título de prueba actualizado',
            'texto' => 'Texto de prueba actualizado',
            'fecha_hora_creacion' => now()->format('Y-m-d H:i:s'),
            'fecha_hora_inicio' => now()->format('Y-m-d H:i:s'),
            'fecha_hora_fin' => now()->addDay()->format('Y-m-d H:i:s'),
            'categoria' => 'Diseño',
            'estado' => 'En espera',
            'id_usuario_modificacion' => 21,
            'id_usuario' => 21,
        ];

        $response = $this->putJson('api/tareas/1000', $datos);

        $this->assertEquals(404, $response->getStatusCode());

        $response->assertJsonFragment([
            'status' => false,
            'message' => 'Tarea no encontrada.'
        ]);
    }


    public function test_eliminar()
    {
        $response = $this->deleteJson('api/tareas/2');

        $this->assertEquals(200, $response->getStatusCode());

        $response->assertJsonFragment([
            'status' => true,
            'message' => 'Tarea eliminada con éxito.'
        ]);
    }

    public function test_eliminar_tarea_inexistente()
    {
        $response = $this->deleteJson('api/tareas/1000');

        $this->assertEquals(404, $response->getStatusCode());

        $response->assertJsonFragment([
            'status' => false,
            'message' => 'Tarea no encontrada.'
        ]);
    }
}
