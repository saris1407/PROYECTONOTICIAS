<?php

require_once "Db.php";

class Db_perfil {

    public static function FindById($id) {
        $conexion = Db::AbreConexion();
        $query = "SELECT * FROM perfil WHERE id = :id";
        $statement = $conexion->prepare($query);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        $resultado = $statement->fetch(PDO::FETCH_OBJ);

        if ($resultado) {
            
            $perfil = new Perfil(
                $resultado->id,
                $resultado->nombre
            );
            $perfil->setId($resultado->id);
            return $perfil;
        } else {
            return null;
        }
    }

    public static function FindAll() {
        $conexion = Db::AbreConexion();
        $query = "SELECT * FROM perfil";
        $statement = $conexion->prepare($query);
        $statement->execute();

        $perfiles = array(); 
        $resultados = $statement->fetchAll(PDO::FETCH_OBJ);

        foreach ($resultados as $resultado) {
            $perfil = new Perfil(
                $resultado->id,
                $resultado->fecha
            );
            $perfil->setId($resultado->id);
            $perfiles[] = $perfil;
        }

        return $perfiles;
    }

    

    public static function UpdateById($id, $perfilActualizada) {
        $conexion = Db::AbreConexion();
        $query = "UPDATE perfil SET fecha = :fecha WHERE id = :id";
        $statement = $conexion->prepare($query);
        $statement->bindParam(':id', $id, PDO::PARAM_INT); 
        $statement->bindParam(':fecha', $perfilActualizada->getFecha(), PDO::PARAM_STR);

        $statement->execute();
    }

    public static function Insert($perfil) {
        $conexion = Db::AbreConexion();

        if (empty($perfil->getNombre())) {
        
            throw new Exception("El campo 'tipo' no puede ser nulo o vacío");
        }

        $query = "INSERT INTO perfil (id, fecha) VALUES (:id, :fecha)";

        $statement = $conexion->prepare($query);

        $id = $perfil->getId(); 
        $fecha = $perfil->getFecha(); 

        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->bindParam(':fecha', $fecha, PDO::PARAM_STR);

        $statement->execute();

        
        return ["success" => "Noticia añadida"];
    }
}
?>
