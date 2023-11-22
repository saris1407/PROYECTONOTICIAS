<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/proyectonoticia/cargadores/Autoload.php';
Autoload::autoload();


// Recibir datos POST en formato JSON
$data = json_decode(file_get_contents('php://input'), true);


// Select
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    
    if (isset($_GET["id"])) {
        $id = $_GET["id"];
        $noticia = Db_noticia::FindById($id);

        $noticiaApi = new stdClass();

        if ($noticia) {
            $noticiaApi->id = $id;
            $noticiaApi->fechaInicio = $noticia->getFechaInicio();
            $noticiaApi->fechaFin = $noticia->getFechaFin();
            $noticiaApi->duracion = $noticia->getDuracion();
            $noticiaApi->prioridad = $noticia->getPrioridad();
            $noticiaApi->titulo = $noticia->getTitulo();
            $noticiaApi->perfil = $noticia->getIdPerfil();
            $noticiaApi->tipo = $noticia->getTipo();
            $noticiaApi->contenido = $noticia->getContenido();
            $noticiaApi->url = $noticia->getUrl();
            $noticiaApi->formato = $noticia->getFormato();
        } else {
            echo json_encode(["error" => "Noticia no encontrada"]);
        }

        echo json_encode($noticiaApi);
    } else {
        echo json_encode(["error" => "ID no proporcionado"]);
    }
}

// Actualiza
if ($_SERVER["REQUEST_METHOD"] == "PUT") {
    $id = isset($_GET["id"]) ? $_GET["id"] : null;

    if (!$id) {
        echo "Error: No se proporcionó un ID para la actualización.";
        exit;
    }

    $putData = json_decode(file_get_contents("php://input"));

    if (isset($putData->tipo)) {
        $valor = $putData->tipo;
        $noticiaActual = Db_noticia::FindById($id);

        if ($noticiaActual) {
            $noticiaActual->setTipo($valor);

            Db_noticia::UpdateById($id, $noticiaActual);
            echo "Noticia actualizada";
        } else {
            echo "Error: No se encontró la noticia con el ID proporcionado.";
        }
    } else {
        echo "Error: La propiedad 'tipo' no está presente en el objeto JSON.";
    }
}

// Borra
if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    
    if (isset($_GET["id"])) {
        $id = $_GET["id"];
        Db_noticia::DeleteById($id);
        echo "Noticia borrada";
    } else {
        echo json_encode(["error" => "ID no proporcionado"]);
    }
}


// Añade
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $objeto = file_get_contents("php://input");
    $noticia = json_decode($objeto);

    if ($noticia) {
        $nuevaNoticia = new Noticia(
            null,
            $noticia->tipo ?? '',
            $noticia->URL ?? '',
            $noticia->formato ?? '',
            $noticia->contenido ?? '',
            $noticia->duracion ?? '',
            $noticia->perfil ?? '',
            $noticia->prioridad ?? '',
            $noticia->titulo ?? ''
        );

        Db_noticia::Insert($nuevaNoticia);

        echo "Noticia añadida";
    } else {
        echo "Error al decodificar la solicitud JSON";
    }
}
?>