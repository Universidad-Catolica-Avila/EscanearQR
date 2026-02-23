<?php
    namespace Mgj\ProyectoBlog2025\Database;
    use Mgj\ProyectoBlog2025\Config\ConfigBD;

    class Conexion{
        public static function conectar(){
             try {
                // MODIFICACIÓN: Añadimos TrustServerCertificate=true al final del DSN
                $dsn = "sqlsrv:Server=" . ConfigBD::$SERVER_NAME_BD . ";Database=" . ConfigBD::$DB_NAME . ";Encrypt=yes;TrustServerCertificate=true";
    
                // Crea una nueva instancia de PDO
                $conexion = new \PDO($dsn, ConfigBD::$USER_BD, ConfigBD::$PASSWORD_BD);
    
                // Configura el modo de error para excepciones
                $conexion->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                
                return $conexion;
            }catch (\PDOException $e){
                echo "Error de conexión: " . $e->getMessage();
                return NULL;
            }
        }
    }   
?>