<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/PROYECTONOTICIAS/cargadores/Autoload.php';
Autoload::autoload();

// Recibir datos POST en formato JSON
$data = json_decode(file_get_contents('php://input'), true);

// Select
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    
    if (isset($_GET["id"])) {
        $id = $_GET["id"];
        $perfil = Db_perfil::FindById($id);

        $perfilApi = new stdClass();

        if ($perfil) {
            $perfilApi->id = $id;
            $perfilApi->nombre = $perfil->getNombre();
        
        } else {
            echo json_encode(["error" => "Perfil no encontrado"]);
        }

        echo json_encode($perfilApi);
    } else {
        echo json_encode(["error" => "ID no proporcionado"]);
    }
}

// ACTUALIZAR
if ($_SERVER["REQUEST_METHOD"] == "PUT") {
    $id = isset($_GET["id"]) ? $_GET["id"] : null;

    if (!$id) {
        echo "Error: No se proporcionó un ID para la actualización.";
        exit;
    }

    $putData = json_decode(file_get_contents("php://input"));

    if (isset($putData->nombre)) {
        $valor = $putData->nombre;
        $perfilActualizado = Db_perfil::FindById($id);

        if ($perfilActualizado) {
            $perfilActualizado->setNombre($valor);

            Db_perfil::UpdateById($id, $perfilActualizado);
            echo "Perfil actualizado";
        } else {
            echo "Error: No se encontró el perfil con el ID proporcionado.";
        }
    } else {
        echo "Error: La propiedad 'nombre' no está presente en el objeto JSON.";
    }
}

// Borrar
if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    
    if (isset($_GET["id"])) {
        $id = $_GET["id"];
        Db_perfil::DeleteById($id);
        echo "Perfil borrado";
    } else {
        echo json_encode(["error" => "ID no proporcionado"]);
    }
}

// insertar
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $objeto = file_get_contents("php://input");
    $perfil = json_decode($objeto);

    if ($perfil) {
        $nuevoPerfil = new Perfil(
            null,
            $perfil->nombre ?? ''
            
        );

        Db_perfil::Insert($nuevoPerfil);

        echo "Perfil añadido";
    } else {
        echo "Error al decodificar la solicitud JSON";
    }
}
?>
