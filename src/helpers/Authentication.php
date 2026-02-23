<?php
namespace Mgj\ProyectoBlog2025\Helpers;

class Authentication {
    public static function isUserAdminLogged(): bool {
    if (!isset($_SESSION['user'])) return false;

    $user = $_SESSION['user'];
    
    // Obtenemos el valor sin importar si es objeto o array
    $rol = '';
    if (is_object($user)) {
        $rol = $user->Rol ?? $user->rol ?? '';
    } elseif (is_array($user)) {
        $rol = $user['Rol'] ?? $user['rol'] ?? '';
    }

    // Limpieza total: quitamos espacios, pasamos a minúsculas
    $rolFinal = trim(strtolower((string)$rol));

    // Si el texto contiene 'admin', le dejamos pasar
    return (strpos($rolFinal, 'admin') !== false);
}

    public static function isUserLogged(): bool {
        return isset($_SESSION['user']);
    }
}