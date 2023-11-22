<?php
class Autoload
    {
        public static function autoload()
        {
            spl_autoload_register(function($clase) {
                $baseDir = $_SERVER['DOCUMENT_ROOT'] . '/proyectonoticia/';
                $directorios = [
                    'apis',
                    'cargadores',
                    'css',
                    'Entidades',
                    'Formulario',
                    'helper',
                    'Repositorio',
                    'Vistas',
                    'recursos'
                ];
    
                foreach ($directorios as $directorio) {
                    $archivo = $baseDir . $directorio . '/' . $clase . '.php';
                    if (file_exists($archivo)) {
                        require_once $archivo;
                        return;
                    }
                }
            });
        }
    }