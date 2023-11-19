<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Gestor de Tareas</title>
</head>
<style>
    body {
        font-family: Arial, sans-serif;
        font-size: 1rem;
        line-height: 1.5;
    }

    .titulo{
        margin-bottom: 1rem;
    }

    .titulo p {
        font-size: 1.4rem;
        font-weight: bold;
    }

    p{
        margin: 0;
    }

    .body{
        margin-bottom: 1rem;
    }

    .texto{
        margin-bottom: 1rem;
    }

    .logo {
        display: block;
        margin: 1rem 0;
        max-width: 100%;
        width: 16rem;
        text-align: left;
    }
</style>

<body>
    <div class="titulo">
        <p>{{ $mailData['subject'] }}</p>
    </div>
    <div class="body">
        <p><b>Titulo:</b> {{ $mailData['titulo'] }}</p>
        <p><b>Usuario:</b>  {{ $mailData['solicitante'] }}</p>
        <p><b>Fecha Creación:</b>  {{ $mailData['fecha_creacion'] }}</p>
        <p><b>Fecha Inicio:</b>  {{ $mailData['fecha_hora_inicio'] }}</p>
        <p><b>Fecha Fin:</b>  {{ $mailData['fecha_hora_fin'] }}</p>
        <p><b>Categoría:</b>  {{ $mailData['categoria'] }}</p>
        <p><b>Estado:</b>  {{ $mailData['estado'] }}</p>
    </div>
    <div class="texto">
        <p><b>Texto:</b> </p>
        <p>{{ $mailData['texto'] }}</p>
    </div>
    <div class="usuarios-asignados">
        <p><b>Usuarios Asignados:</b> {{ implode(', ', $mailData['usuarios_asignados']) }}.</p>
    </div>
    <br>
    <div class="saludo">
        <p>Saluda atentamente</p>
        <p>El equipo de Gestor de Tareas</p>
        <img class="logo" src="https://raw.githubusercontent.com/mflo80/gtareas-login/main/public/img/logo.png"
            width="200px" alt="LOGO" />
    </div>
</body>

</html>
