<?php
    namespace Mgj\ProyectoBlog2025\Helpers;
    use Monolog\Handler\StreamHandler;
    use Monolog\Logger;
    use Psr\Log\LoggerInterface;
    // La línea de "use Monolog\Level" se ha eliminado porque no existe en v2
    class LogFactory {
        public static function getLogger(string $canal = "Blog") : LoggerInterface {
            $log = new Logger($canal);
            // En Monolog 2.x se usan las constantes de la clase Logger
            $log->pushHandler(new StreamHandler("logs/Debug.log", Logger::DEBUG));
            $log->pushHandler(new StreamHandler("logs/Errores.log", Logger::ERROR, false));
            return $log;
        }
    }