<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SolicitudCitaApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_crea_una_solicitud_de_cita(): void
    {
        $res = $this->postJson('/api/solicitudes-citas', [
            'nombre' => 'Juan Perez',
            'telefono' => '999999999',
            'email' => 'juan@example.com',
            'especialidad' => 'Cardiología',
            'fecha' => '2026-04-27',
            'hora' => '10:30',
            'motivo' => 'Dolor de pecho',
            'origen' => 'web',
        ]);

        $res->assertCreated()
            ->assertJsonPath('ok', true)
            ->assertJsonPath('solicitud.nombre', 'Juan Perez')
            ->assertJsonPath('solicitud.estado', 'nueva');

        $this->assertDatabaseHas('solicitudes_citas', [
            'nombre' => 'Juan Perez',
            'telefono' => '999999999',
            'estado' => 'nueva',
        ]);
    }

    public function test_lista_solicitudes_de_cita(): void
    {
        $this->postJson('/api/solicitudes-citas', [
            'nombre' => 'A',
            'telefono' => '1',
        ])->assertCreated();

        $this->postJson('/api/solicitudes-citas', [
            'nombre' => 'B',
            'telefono' => '2',
        ])->assertCreated();

        $res = $this->getJson('/api/solicitudes-citas');

        $res->assertOk()
            ->assertJsonIsArray()
            ->assertJsonCount(2);
    }

    public function test_cancela_una_solicitud_de_cita(): void
    {
        $create = $this->postJson('/api/solicitudes-citas', [
            'nombre' => 'A',
            'telefono' => '1',
        ])->assertCreated();

        $id = $create->json('solicitud.id');

        $cancel = $this->patchJson("/api/solicitudes-citas/{$id}/cancelar", [
            'motivo_cancelacion' => 'No podré asistir',
        ]);

        $cancel->assertOk()
            ->assertJsonPath('ok', true)
            ->assertJsonPath('solicitud.estado', 'cancelada');

        $this->assertDatabaseHas('solicitudes_citas', [
            'id' => $id,
            'estado' => 'cancelada',
        ]);
    }

    public function test_no_permite_cancelar_dos_veces(): void
    {
        $create = $this->postJson('/api/solicitudes-citas', [
            'nombre' => 'A',
            'telefono' => '1',
        ])->assertCreated();

        $id = $create->json('solicitud.id');

        $this->patchJson("/api/solicitudes-citas/{$id}/cancelar")->assertOk();

        $this->patchJson("/api/solicitudes-citas/{$id}/cancelar")
            ->assertStatus(409);
    }

    public function test_reprograma_una_solicitud_de_cita(): void
    {
        $create = $this->postJson('/api/solicitudes-citas', [
            'nombre' => 'A',
            'telefono' => '1',
        ])->assertCreated();

        $id = $create->json('solicitud.id');

        $res = $this->patchJson("/api/solicitudes-citas/{$id}/reprogramar", [
            'fecha' => '2026-05-01',
            'hora' => '15:00',
        ]);

        $res->assertOk()
            ->assertJsonPath('ok', true)
            ->assertJsonPath('solicitud.estado', 'reprogramada')
            ->assertJsonPath('solicitud.fecha', '2026-05-01')
            ->assertJsonPath('solicitud.hora', '15:00');
    }
}

