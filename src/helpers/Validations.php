<?php
    namespace Mgj\ProyectoBlog2025\Helpers;

	class Validations{

        public static function validarName($nombre):bool{
            // Patrón: Solo letras/espacios, máximo 10 caracteres
            $patron = "/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,10}$/u";
            return (bool) preg_match($patron, $nombre);
        }

        public static function validarEmail($email):bool{
            $patron = "/^[a-z0-0._%+-]+@[a-z0-0.-]+\.[a-z]{2,}$/i";

            if (preg_match($patron, $email)) {
                echo "El email es válido.";
            } else {
                echo "El formato del email no es correcto.";
            }
            return true;
        }

        public static function validarFormatPassword($password):bool{
            // Si el campo está vacío, devolvemos true porque es opcional en tu formulario
            if (empty($password)) {
                return true;
            }

            // Patrón: Letras y números, entre 8 y 16 caracteres
            $patron = "/^[a-zA-Z0-9]{8,16}$/";
            
            return (bool) preg_match($patron, $password);
        }

        public static function validarApellidos($apellidos):bool{
            // Permite letras, tildes, ñ y espacios. Máximo 20 caracteres.
            $patron = "/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,20}$/u";
            return (bool) preg_match($patron, $apellidos);
        }
    }