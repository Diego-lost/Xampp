@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
  <div class="grid grid-2">
    <section class="card">
      <h2 style="margin:0 0 8px;">Catálogo</h2>
      <p class="muted" style="margin:0 0 12px;">
        Administra la información base: especialidades, médicos y servicios.
      </p>
      <div class="row">
        <a class="btn btn-primary" href="{{ route('admin.especialidades.index') }}">Especialidades</a>
        <a class="btn btn-primary" href="{{ route('admin.medicos.index') }}">Médicos</a>
        <a class="btn btn-primary" href="{{ route('admin.servicios.index') }}">Servicios</a>
      </div>
    </section>

    <section class="card">
      <h2 style="margin:0 0 8px;">Atención</h2>
      <p class="muted" style="margin:0 0 12px;">
        Revisa solicitudes recibidas desde la web y gestiona cancelaciones / reprogramaciones.
      </p>
      <div class="row">
        <a class="btn btn-primary" href="{{ route('admin.solicitudes-citas.index') }}">Solicitudes de citas</a>
      </div>
    </section>
  </div>
@endsection

