<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CatalogoCrudApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_crud_especialidades(): void
    {
        $create = $this->postJson('/api/especialidades', [
            'nombre' => 'Cardiología',
            'imagen' => 'cardio.jpg',
        ])->assertCreated();

        $id = $create->json('id');

        $this->getJson('/api/especialidades')
            ->assertOk()
            ->assertJsonIsArray()
            ->assertJsonCount(1);

        $this->getJson("/api/especialidades/{$id}")
            ->assertOk()
            ->assertJsonPath('nombre', 'Cardiología');

        $this->putJson("/api/especialidades/{$id}", [
            'nombre' => 'Cardiología (Edit)',
        ])->assertOk()
            ->assertJsonPath('nombre', 'Cardiología (Edit)');

        $this->deleteJson("/api/especialidades/{$id}")
            ->assertNoContent();
    }

    public function test_crud_medicos(): void
    {
        $esp = $this->postJson('/api/especialidades', ['nombre' => 'Pediatría'])->assertCreated();
        $especialidadId = $esp->json('id');

        $create = $this->postJson('/api/medicos', [
            'nombre' => 'Dra. Maria',
            'especialidad_id' => $especialidadId,
            'foto' => 'maria.jpg',
        ])->assertCreated();

        $id = $create->json('id');

        $this->getJson('/api/medicos?especialidad_id='.$especialidadId)
            ->assertOk()
            ->assertJsonIsArray()
            ->assertJsonCount(1);

        $this->getJson("/api/medicos/{$id}")
            ->assertOk()
            ->assertJsonPath('nombre', 'Dra. Maria')
            ->assertJsonPath('especialidad.id', $especialidadId);

        $this->patchJson("/api/medicos/{$id}", [
            'nombre' => 'Dra. Maria (Edit)',
        ])->assertOk()
            ->assertJsonPath('nombre', 'Dra. Maria (Edit)');

        $this->deleteJson("/api/medicos/{$id}")
            ->assertNoContent();
    }

    public function test_crud_servicios(): void
    {
        $esp = $this->postJson('/api/especialidades', ['nombre' => 'Dermatología'])->assertCreated();
        $especialidadId = $esp->json('id');

        $med = $this->postJson('/api/medicos', [
            'nombre' => 'Dr. Diego',
            'especialidad_id' => $especialidadId,
        ])->assertCreated();
        $medicoId = $med->json('id');

        $create = $this->postJson('/api/servicios', [
            'nombre' => 'Consulta dermatológica',
            'descripcion' => 'Evaluación de piel',
            'precio' => 100,
            'medico_id' => $medicoId,
        ])->assertCreated();

        $id = $create->json('id');

        $this->getJson('/api/servicios?medico_id='.$medicoId)
            ->assertOk()
            ->assertJsonIsArray()
            ->assertJsonCount(1);

        $this->getJson("/api/servicios/{$id}")
            ->assertOk()
            ->assertJsonPath('nombre', 'Consulta dermatológica')
            ->assertJsonPath('medico.id', $medicoId);

        $this->putJson("/api/servicios/{$id}", [
            'precio' => 120,
        ])->assertOk()
            ->assertJsonPath('precio', 120);

        $this->deleteJson("/api/servicios/{$id}")
            ->assertNoContent();
    }
}

