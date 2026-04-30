<!DOCTYPE html>
<html>
<head>
    <title>Hospital Online</title>
</head>
<body>

<h1>Especialidades</h1>

@foreach ($especialidades as $e)
    <div style="border:1px solid #ccc; padding:10px; margin:10px;">
        <h3>{{ $e->nombre }}</h3>
    </div>
@endforeach

</body>
</html>