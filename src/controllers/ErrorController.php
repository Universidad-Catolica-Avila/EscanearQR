<?php
namespace Mgj\ProyectoBlog2025\Controllers;
use Mgj\ProyectoBlog2025\Helpers\LogFactory;
use Psr\Log\LoggerInterface;

class ErrorController{

    private LoggerInterface $log;

    public function __construct(){
        $this->log = LogFactory::getLogger("ErrorController");
    }
    public function mostrar404(){
        echo "<p class='error'>Error 404, el recurso solicitado no existe </p>";
        $this->log->error("ErrorController. Método mostrar404.", ["Controller" => $_GET["controller"], "Action" => $_GET["action"]]);
    }

        public function mostrar403(){
        echo "<p class='error'>Error 403, no tiene privilegios para el recursos solicitado </p>";
        $this->log->error("ErrorController. Método mostrar403.", ["Controller" => $_GET["controller"], "Action" => $_GET["action"], "Session" => $_SESSION]);
    }
}