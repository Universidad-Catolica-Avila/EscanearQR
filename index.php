<?php
session_name("ProyectoBlog2025");
session_start();
//var_dump($_SESSION);
require_once 'vendor/autoload.php';

use Mgj\ProyectoBlog2025\Config\Parameters;
use Mgj\ProyectoBlog2025\Controllers\ErrorController;

/*
    CAMBIOS EN ESTA VERSION:

        Integrar funcionalidades Composer:
            Generar paginación (stefangabos/zebra_pagination) + búsqueda
            Sistema de Logs (monolog/monolog)
            Generar PDFs (spipu/html2pdf)

        composer update
*/


// CONTROLADOR FRONTAL:
    $nameController = "Mgj\ProyectoBlog2025\Controllers\\";
    $nameController = $nameController . (($_GET['controller'])??Parameters::$CONTROLLER_DEFAULT) . "Controller";
    $action = $_GET['action']??Parameters::$ACTION_DEFAULT;
    
    // Método class_exists
    if (class_exists($nameController)){
        $controller = new $nameController();
        if (method_exists($controller, $action)){
            $controller->$action();            
        }else (new ErrorController())->mostrar404();   
    }else (new ErrorController())->mostrar404();
    

    