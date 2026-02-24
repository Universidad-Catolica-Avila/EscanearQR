<?php
namespace Mgj\ProyectoBlog2025\Config;

class Parameters{
    public static $CONTROLLER_DEFAULT = "Usuario"; 
    public static $ACTION_DEFAULT = "showLogin";
    public static $LAST_ENTRADAS = 2; 
    public static $PAGINATION_NUM_RECORDS = 4;

    public static function getBaseUrl() {
        if ($_SERVER['HTTP_HOST'] == 'localhost') {
            return "http://localhost/Proyecto2.3/";
        } else {
            return "https://escanearqr-ajd9fzguedapgnhx.canadacentral-01.azurewebsites.net/";
        }
    }

    public static function getBasePath() {
        if ($_SERVER['HTTP_HOST'] == 'localhost') {
            return $_SERVER['DOCUMENT_ROOT'] . "/Proyecto2.3/";
        }
        return $_SERVER['DOCUMENT_ROOT'] . "/";
    }
}