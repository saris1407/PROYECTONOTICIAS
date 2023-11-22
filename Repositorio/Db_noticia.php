<?php

require_once "Db.php";

class Db_noticia {

    public static function FindById($id) {
        $conexion = Db::AbreConexion();
        $query = "SELECT * FROM noticia WHERE id = :id";
        $statement = $conexion->prepare($query);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        $resultado = $statement->fetch(PDO::FETCH_OBJ);

        if ($resultado) {
            $noticia = new Noticia(
                $resultado->tipo,
                $resultado->URL,
                $resultado->formato,
                $resultado->contenido,
                $resultado->duracion,
                $resultado->perfil,
                $resultado->prioridad,
                $resultado->titulo
            );
            $noticia->setId($resultado->id);
            return $noticia;
        } else {
            return null;
        }
    }

    public static function FindAll() {
        $conexion = Db::AbreConexion();
        $query = "SELECT * FROM noticia";
        $statement = $conexion->prepare($query);
        $statement->execute();

        $noticias = array();
        $resultados = $statement->fetchAll(PDO::FETCH_OBJ);

        foreach ($resultados as $resultado) {
            $noticia = new Noticia(
                $resultado->tipo,
                $resultado->URL,
                $resultado->formato,
                $resultado->contenido,
                $resultado->duracion,
                $resultado->perfil,
                $resultado->prioridad,
                $resultado->titulo
            );
            $noticia->setId($resultado->id);
            $noticias[] = $noticia;
        }

        return $noticias;
    }

    public static function DeleteById($id) {
        $conexion = Db::AbreConexion();
        $query = "DELETE FROM noticia WHERE id = :id";
        $statement = $conexion->prepare($query);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
    }

    public static function UpdateById($id, $noticiaActualizada) {
        $conexion = Db::AbreConexion();
        $query = "UPDATE noticia SET 
                  tipo = :tipo,
                  URL = :URL,
                  formato = :formato,
                  contenido = :contenido,
                  duracion = :duracion,
                  perfil = :perfil,
                  prioridad = :prioridad,
                  titulo = :titulo
                  WHERE id = :id";

        $statement = $conexion->prepare($query);
        $statement->bindParam(':tipo', $noticiaActualizada->getTipo(), PDO::PARAM_STR);
        $statement->bindParam(':URL', $noticiaActualizada->getURL(), PDO::PARAM_STR);
        $statement->bindParam(':formato', $noticiaActualizada->getFormato(), PDO::PARAM_STR);
        $statement->bindParam(':contenido', $noticiaActualizada->getContenido(), PDO::PARAM_STR);
        $statement->bindParam(':duracion', $noticiaActualizada->getDuracion(), PDO::PARAM_STR);
        $statement->bindParam(':perfil', $noticiaActualizada->getPerfil(), PDO::PARAM_STR);
        $statement->bindParam(':prioridad', $noticiaActualizada->getPrioridad(), PDO::PARAM_INT);
        $statement->bindParam(':titulo', $noticiaActualizada->getTitulo(), PDO::PARAM_STR);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
    }

    public static function Insert($noticia) {
        $conexion = Db::AbreConexion();
    
        
        if (empty($noticia->getTipo())) {
            echo json_encode(["error" => "El campo 'tipo' no puede ser nulo o vacío"]);
            return;
        }
    
        $query = "INSERT INTO noticia (tipo, URL, formato, contenido, duracion, perfil, prioridad, titulo)
                  VALUES (:tipo, :URL, :formato, :contenido, :duracion, :perfil, :prioridad, :titulo)";
    
        $statement = $conexion->prepare($query);
    
        $tipo = $noticia->getTipo();
        $URL = $noticia->getURL();
        $formato = $noticia->getFormato();
        $contenido = $noticia->getContenido();
        $duracion = $noticia->getDuracion();
        $perfil = $noticia->getPerfil();
        $prioridad = $noticia->getPrioridad();
        $titulo = $noticia->getTitulo();
    
        $statement->bindParam(':tipo', $tipo, PDO::PARAM_STR);
        $statement->bindParam(':URL', $URL, PDO::PARAM_STR);
        $statement->bindParam(':formato', $formato, PDO::PARAM_STR);
        $statement->bindParam(':contenido', $contenido, PDO::PARAM_STR);
        $statement->bindParam(':duracion', $duracion, PDO::PARAM_STR);
        $statement->bindParam(':perfil', $perfil, PDO::PARAM_STR);
        $statement->bindParam(':prioridad', $prioridad, PDO::PARAM_INT);
        $statement->bindParam(':titulo', $titulo, PDO::PARAM_STR);
    
        $statement->execute();
    
        echo json_encode(["success" => "Noticia añadida"]);
    
        return; 
    }
}
?>
