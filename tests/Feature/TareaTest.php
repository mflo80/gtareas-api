<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
use App\Http\Controllers\TareaController;
use Illuminate\Http\Request;

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
        $datos = $response->json();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(true, $response->getData()->status);
    }

    public function test_buscar_por_id()
    {
        $response = $this->getJson('api/tareas/2');
        $datos = $response->json();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(true, $response->getData()->status);
    }

    public function test_buscar_por_id_inexistente()
    {
        $response = $this->getJson('api/tareas/1000');
        $datos = $response->json();

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals(true, $response->getData()->status);
    }

    public function test_actualizar()
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
        ];

        $response = $this->putJson('api/tareas/2', $datos);
        $datos = $response->json();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(true, $response->getData()->status);
        $this->assertDatabaseHas('tareas', ['titulo' => 'Título de prueba actualizado']);
    }
/*
    public function test_eliminar()
    {
        $response = $this->deleteJson('api/tareas/2');
        $datos = $response->json();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(true, $response->getData()->status);
        $this->assertDatabaseMissing('tareas', ['id' => 2]);
    }*/
}
