<?php

class App{

    function __construct(){
        
        $url = isset($_GET['url']) ? $_GET['url']: null;
        $url = rtrim($url, '/');
        $url = explode('/', $url);

        if(empty($url[0])){
            $archivoController = 'controllers/asistencia.php';
            require_once $archivoController;
            $controller = new Asistencia();
            $controller->loadModel('asistencia');
            $controller->render();
            return false;
        }

        $archivoController = 'controllers/' . $url[0] . '.php';

        if(file_exists($archivoController)){
            require_once $archivoController;

            // inicializar controlador
            $controller = new $url[0];
            $controller->loadModel($url[0]);

            // si hay un método que se requiere cargar
            if(isset($url[1])){
                $controller->{$url[1]}();
            }else{
                $controller->render();
            }

        } else {
            $archivoController = 'controllers/asistencia.php';
            require_once $archivoController;
            $controller = new Asistencia();
            $controller->loadModel('asistencia');
            $controller->render();
            return false;
        }
        
    }
}

?>