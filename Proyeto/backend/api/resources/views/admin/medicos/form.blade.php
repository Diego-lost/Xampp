@extends('admin.layout')

@section('title', $medico->exists ? 'Editar médico' : 'Nuevo médico')

@section('content')
  <div class="row" style="justify-content: space-between; margin-bottom: 12px;">
    <div>
      <h1 style="margin:0;">{{ $medico->exists ? 'Editar médico' : 'Nuevo médico' }}</h1>
      <div class="muted">Completa los datos del médico.</div>
    </div>
    <a class="btn" href="{{ route('admin.medicos.index') }}">Volver</a>
  </div>

  <div class="card">
    <form method="POST"
      action="{{ $medico->exists ? route('admin.medicos.update', $medico) : route('admin.medicos.store') }}">
      @csrf
      @if ($medico->exists)
        @method('PUT')
      @endif

      <div class="grid grid-2">
        <div class="field">
          <label>Nombre</label>
          <input name="nombre" value="{{ old('nombre', $medico->nombre) }}" required />
          @error('nombre')<div class="muted">{{ $message }}</div>@enderror
        </div>

        <div class="field">
          <label>Especialidad</label>
          <select name="especialidad_id" required>
            <option value="" disabled @selected(!old('especialidad_id', $medico->especialidad_id))>Selecciona</option>
            @foreach ($especialidades as $e)
              <option value="{{ $e->id }}" @selected(old('especialidad_id', $medico->especialidad_id) == $e->id)>
                {{ $e->nombre }}
              </option>
            @endforeach
          </select>
          @error('especialidad_id')<div class="muted">{{ $message }}</div>@enderror
        </div>

        <div class="field" style="grid-column: 1 / -1;">
          <label>Foto (ruta o nombre archivo)</label>
          <input name="foto" value="{{ old('foto', $medico->foto) }}" />
          @error('foto')<div class="muted">{{ $message }}</div>@enderror
        </div>
      </div>

      <div class="row" style="margin-top: 12px;">
        <button class="btn btn-primary" type="submit">Guardar</button>
      </div>
    </form>
  </div>
@endsection

