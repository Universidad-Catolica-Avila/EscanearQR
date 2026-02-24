<?php
namespace Mgj\ProyectoBlog2025\Controllers;

use Mgj\ProyectoBlog2025\Models\UsuarioModel;
use Mgj\ProyectoBlog2025\Entities\UserEntity;
use Mgj\ProyectoBlog2025\Helpers\Authentication;
use Mgj\ProyectoBlog2025\Config\Parameters;
use Mgj\ProyectoBlog2025\Helpers\GoRoute;
use Mgj\ProyectoBlog2025\Helpers\Validations;

class UsuarioController {

    public function index() {
        // Redirige al login por defecto
        $this->showLogin();
    }

    public function showRegister() {
        ViewController::show('views/usuarios/showRegister.php');
    }

    public function register() {
        if (isset($_POST['btnRegister'])) {
            $errores = array();
            // Implementar validaciones aquí si es necesario

            if (empty($errores)) {
                $usuarioModel = new UsuarioModel();
                $user = new UserEntity();
                
                $user->setId(uniqid('USR-')) 
                    ->setNombre($_POST['nombre'])
                    ->setApellidos($_POST['apellidos'])
                    ->setEmail($_POST['email'])
                    ->setPasswordSecure(password_hash($_POST['password'], PASSWORD_DEFAULT))
                    ->setRol('user'); 

                $resultado = $usuarioModel->register($user);

                if ($resultado) {
                    $_SESSION["statusLastAction"] = [
                        "tipo" => "exito",
                        "mensaje" => "Registro completado. Ya puedes iniciar sesión."
                    ];
                } else {
                    $_SESSION["statusLastAction"] = [
                        "tipo" => "error",
                        "mensaje" => "Error al registrar al usuario."
                    ];
                }   
                
                // Redirigimos al login usando el formato index.php para Azure
                header("Location: " . Parameters::getBaseUrl() . "index.php?controller=Usuario&action=showLogin");
                exit();
            }
        } else {
            ViewController::showError(404);
        }
    }

    public function showLogin() {
        $baseUrl = Parameters::getBaseUrl();
        require_once 'views/layout/header.php'; 
        require_once 'views/usuarios/showLogin.php';
        require_once 'views/layout/footer.php';
    }

    public function login() {
        $estadoLogin = false;
        if (isset($_POST["btnLogin"])) {
            $email = trim($_POST["email"]) ?? "";
            $password = $_POST["password"] ?? "";
            
            $usuarioModel = new UsuarioModel();
            $usuario = $usuarioModel->login($email);
            
            if ($usuario) {
                // Importante: SQL Server suele devolver Password con P mayúscula
                $dbPassword = $usuario->Password ?? $usuario->password; 
                $verify = password_verify($password, $dbPassword);

                if ($verify || $password === $dbPassword) {
                    // Normalizamos el rol para el header
                    $usuario->rolCompleto = (($usuario->Rol ?? $usuario->rol) == "ADMIN" ? "ADMINISTRADOR" : "USUARIO");
                    // Guardamos el objeto en sesión
                    $_SESSION['user'] = $usuario;
                    $estadoLogin = true;
                }
            }
        }

        if ($estadoLogin) {
            // Redirección exitosa: Formato compatible con Azure Nginx
            header("Location: " . Parameters::getBaseUrl() . "index.php?controller=Charla&action=getAll");
            exit(); 
        } else {
            $_SESSION["statusLastAction"] = [
                "tipo" => "error",
                "mensaje" => "Credenciales incorrectas"
            ];
            header("Location: " . Parameters::getBaseUrl() . "index.php?controller=Usuario&action=showLogin");
            exit();
        }
    }

    public function closeSession() {
        if (Authentication::isUserLogged()) {
            unset($_SESSION['user']);
        }
        header("Location: " . Parameters::getBaseUrl() . "index.php?controller=Usuario&action=showLogin");
        exit();
    }

    public function getAllUsers() {
        $usuarioModel = new UsuarioModel();
        $users = $usuarioModel->getAllUsers();
        ViewController::show('views/usuarios/showUser.php', ["users" => $users]);
    }

    public function showEditar() {
        // Soporte para ID en mayúscula o minúscula según el mapeo del Model
        $idSesion = $_SESSION['user']->ID ?? $_SESSION['user']->id ?? null;
        $idUsuario = $_GET["id"] ?? $idSesion;

        if ($idUsuario) {
            $usuarioModel = new UsuarioModel();
            $usuario = $usuarioModel->getOne($idUsuario);

            if ($usuario) {
                $rolSesion = $_SESSION['user']->Rol ?? $_SESSION['user']->rol ?? '';
                $esAdmin = (strtoupper($rolSesion) === 'ADMIN'); 
                $idObtenido = $usuario->ID ?? $usuario->id;
                $esSuPropioPerfil = ($idObtenido == $idSesion);

                if ($esAdmin || $esSuPropioPerfil) {
                    ViewController::show('views/usuarios/showEditar.php', ["usuario" => $usuario]);
                } else {
                    ViewController::showError(403);
                }
            } else {
                ViewController::showError(404); 
            }
        } else {
            ViewController::showError(404);
        }      
    }

    public function editar() {
        $idSesion = $_SESSION['user']->ID ?? $_SESSION['user']->id ?? null;
        $idPost = $_POST['id'] ?? null;

        if (Authentication::isUserAdminLogged() || (Authentication::isUserLogged() && $idSesion == $idPost)) {
            $usuarioModel = new UsuarioModel();
            $user = new UserEntity();
            
            $user->setId($idPost)
                 ->setNombre($_POST["nombre"])
                 ->setApellidos($_POST["apellidos"])
                 ->setRol($_POST["rol"] ?? 'user');

            if (!empty($_POST["password"])) {
                $user->setPasswordSecure(password_hash($_POST["password"], PASSWORD_DEFAULT));
            }
                
            $resultado = $usuarioModel->update($user);

            if ($resultado) {
                $_SESSION["statusLastAction"] = [
                    "tipo" => "exito",
                    "mensaje" => "Perfil actualizado correctamente."
                ];    
                
                // Actualizamos el objeto de sesión para que el Header cambie al instante
                if (isset($_SESSION['user']->ID)) {
                    $_SESSION['user']->Nombre = $user->getNombre();
                    $_SESSION['user']->Apellidos = $user->getApellidos();
                } else {
                    $_SESSION['user']->nombre = $user->getNombre();
                }

                header("Location: " . Parameters::getBaseUrl() . "index.php?controller=Usuario&action=showEditar&id=" . $idPost);
                exit();
            } else {
                $_SESSION["statusLastAction"] = [
                    "tipo" => "error",
                    "mensaje" => "No se pudo actualizar el perfil."
                ];    
                header("Location: " . Parameters::getBaseUrl() . "index.php?controller=Usuario&action=showEditar&id=" . $idPost);
                exit();
            }
        } else {
            ViewController::showError(403);
        }
    }

    public function eliminar() {
        if (isset($_POST['id'])) {
            $usuarioModel = new UsuarioModel();
            $user = $usuarioModel->getOne($_POST['id']);
            $idSesion = $_SESSION['user']->ID ?? $_SESSION['user']->id;
            
            $idABorrar = $user->ID ?? $user->id;

            if (Authentication::isUserAdminLogged() || (Authentication::isUserLogged() && $idABorrar == $idSesion)) {
                $resultado = $usuarioModel->delete($_POST['id']);                
                if ($resultado) {
                    $_SESSION["statusLastAction"] = ["tipo" => "exito", "mensaje" => "Usuario eliminado."];
                    if ($idABorrar == $idSesion) {
                        $this->closeSession();
                    }
                }
                header("Location: " . Parameters::getBaseUrl() . "index.php?controller=Usuario&action=getAllUsers");
                exit();
            }
        }
        ViewController::showError(404);
    }
}