<?php
namespace Mgj\ProyectoBlog2025\Config;

class Parameters{
    public static $CONTROLLER_DEFAULT = "Usuario"; 
    public static $ACTION_DEFAULT = "showLogin";
    
    public static $LAST_ENTRADAS = 2; 

    public static $PAGINATION_NUM_RECORDS = 4;

    public static $BASE_URL = "http://localhost/Proyecto2.3/";

    public static function getBasePath() {
        return $_SERVER['DOCUMENT_ROOT'] . "/Proyecto2.3/";
    }
}