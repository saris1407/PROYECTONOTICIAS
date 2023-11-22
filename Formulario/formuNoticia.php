<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/PROYECTONOTICIAS/cargadores/Autoload.php';
Autoload::autoload();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./css/style.css">
    <title>Noticia</title>
</head>
<body>

<h1>Noticia</h1>

<form id="noticia">
    <label for="fechaInicio">Fecha de Inicio:</label>
    <input type="text" id="fechaInicio" name="fechaInicio" required>
    <br>

    <label for="fechaFin">Fecha de Fin:</label>
    <input type="datetime-local"  name="fechaFin" required>
    <br>

    <label for="duracion">Duración:</label>
    <input type="text" name="duracion" required>
    <br>

    <label for="prioridad">Prioridad:</label>
    <input type="text" id="prioridad" name="prioridad" required>
    <br>

    <label for="titulo">Título:</label>
    <input type="text" id="titulo" name="titulo" required>
    <br>

    <label for="idPerfil">ID de Perfil:</label>
    <input type="text" id="idPerfil" name="idPerfil" required>
    <br>

    <label for="tipo">Tipo:</label>
    <input type="text" id="tipo" name="tipo" required>
    <br>

    <label for="contenido">Contenido:</label>
    <textarea id="contenido" name="contenido" rows="4" required></textarea>
    <br>

    <label for="url">URL:</label>
    <input type="text" id="url" name="url" required>
    <br>

    <label for="formato">Formato:</label>
    <input type="text" id="formato" name="formato" required>
    <br>

    <input type="button" value="Crear Noticia" onclick="crearNoticia()">
    <input type="button" value="Editar Noticia" onclick="editarNoticia()">
    <input type="button" value="Borrar Noticia" onclick="borrarNoticia()">
    
</form>

</body>
</html>
