<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Admin') | Hospital Online</title>
    <style>
      body { font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif; margin: 0; background: #f6f7fb; color: #111827; }
      a { color: inherit; text-decoration: none; }
      .container { width: min(1100px, calc(100% - 32px)); margin: 0 auto; }
      .top { background: #0b1320; color: #fff; padding: 14px 0; }
      .top .brand { font-weight: 800; letter-spacing: -0.3px; }
      .nav { display: flex; gap: 10px; flex-wrap: wrap; margin-top: 10px; }
      .nav a { background: rgba(255,255,255,0.08); padding: 8px 10px; border-radius: 10px; }
      .nav a:hover { background: rgba(255,255,255,0.14); }
      .card { background: #fff; border: 1px solid rgba(17,24,39,0.12); border-radius: 14px; padding: 14px; box-shadow: 0 10px 18px rgba(17,24,39,0.06); }
      .grid { display: grid; gap: 12px; }
      .grid-2 { grid-template-columns: repeat(2, minmax(0,1fr)); }
      .table { width: 100%; border-collapse: collapse; }
      .table th, .table td { border-bottom: 1px solid rgba(17,24,39,0.1); padding: 10px 8px; text-align: left; font-size: 14px; vertical-align: top; }
      .table th { font-size: 12px; text-transform: uppercase; letter-spacing: 0.06em; color: rgba(17,24,39,0.7); }
      .btn { display:inline-flex; align-items:center; justify-content:center; padding: 9px 12px; border-radius: 12px; border: 1px solid rgba(17,24,39,0.15); background: #fff; cursor: pointer; font-weight: 700; font-size: 13px; }
      .btn:hover { box-shadow: 0 10px 18px rgba(17,24,39,0.12); transform: translateY(-1px); }
      .btn-primary { background: #0f62fe; border-color: #0f62fe; color: #fff; }
      .btn-danger { background: #ef4444; border-color: #ef4444; color: #fff; }
      .btn-soft { background: rgba(15,98,254,0.08); border-color: rgba(15,98,254,0.22); color: #0b1320; }
      .row { display:flex; gap: 8px; flex-wrap: wrap; align-items:center; }
      .field { display:grid; gap: 6px; }
      .field label { font-size: 12px; color: rgba(17,24,39,0.7); font-weight: 700; }
      .field input, .field select, .field textarea { padding: 10px 10px; border-radius: 12px; border: 1px solid rgba(17,24,39,0.15); background: #fff; font: inherit; }
      .muted { color: rgba(17,24,39,0.65); }
      .badge { font-size: 12px; font-weight: 800; padding: 4px 8px; border-radius: 999px; background: rgba(17,24,39,0.06); display:inline-block; }
      @media (max-width: 820px) { .grid-2 { grid-template-columns: 1fr; } }
    </style>
  </head>
  <body>
    <header class="top">
      <div class="container">
        <div class="row" style="justify-content: space-between;">
          <div class="brand">Hospital Online — Admin</div>
          <a class="btn btn-soft" href="/">Ver sitio</a>
        </div>
        <nav class="nav" aria-label="Navegación admin">
          <a href="{{ route('admin.dashboard') }}">Dashboard</a>
          <a href="{{ route('admin.especialidades.index') }}">Especialidades</a>
          <a href="{{ route('admin.medicos.index') }}">Médicos</a>
          <a href="{{ route('admin.servicios.index') }}">Servicios</a>
          <a href="{{ route('admin.solicitudes-citas.index') }}">Solicitudes de citas</a>
        </nav>
      </div>
    </header>

    <main class="container" style="padding: 16px 0 40px;">
      @yield('content')
    </main>
  </body>
  </html>

