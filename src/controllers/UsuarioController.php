<?php
namespace Mgj\ProyectoBlog2025\Controllers;
use Mgj\ProyectoBlog2025\Models\UsuarioModel;
use Mgj\ProyectoBlog2025\Entities\UserEntity;
use Mgj\ProyectoBlog2025\Helpers\Authentication;
use Mgj\ProyectoBlog2025\Config\Parameters;
use Mgj\ProyectoBlog2025\Helpers\GoRoute;
use Mgj\ProyectoBlog2025\Helpers\Validations;

class UsuarioController{
    public function index(){
    }

    public function showRegister(){
        ViewController::show('views/usuarios/showRegister.php');
    }

    public function register(){
        if (isset($_POST['btnRegister'])){
            
            $errores = array();

            if (empty($errores)){
                $usuarioModel = new UsuarioModel();

                $user = new UserEntity();
                $user->setId(uniqid('USR-')) 
                    ->setNombre($_POST['nombre'])
                    ->setApellidos($_POST['apellidos'])
                    ->setEmail($_POST['email'])
                    ->setPasswordSecure(password_hash($_POST['password'], PASSWORD_DEFAULT))
                    ->setRol('user'); 


                $resultado = $usuarioModel->register($user);

                if ($resultado){
                            $_SESSION["statusLastAction"] = [
                                "tipo" => "exito",
                                "mensaje" => "El usuario se ha registrado correctamente. Ya puedes iniciar sesión."
                            ];                
                }else{
                            $_SESSION["statusLastAction"] = [
                                "tipo" => "error",
                                "mensaje" => "Error al registrar al usuario."
                            ];                
                }   

                ViewController::show('views/usuarios/showLogin.php');

            }else{
            }
        }else{
            ViewController::showError(404);
        }

    }

    public function showLogin(){
        ViewController::show('views/usuarios/showLogin.php');
    }

    public function login(){
    $estadoLogin = false;
    if (isset($_POST["btnLogin"])) {
        $email = trim($_POST["email"]) ?? "";
        $password = $_POST["password"] ?? "";
        
        $usuarioModel = new UsuarioModel();
        $usuario = $usuarioModel->login($email);
        
        if ($usuario) {
            $dbPassword = $usuario->Password; 

            $verify = password_verify($password, $dbPassword);

            if ($verify || $password === $dbPassword){
                $usuario->rolCompleto = (($usuario->Rol ?? "") == "ADMIN" ? "ADMINISTRADOR" : "USUARIO");
                $_SESSION['user'] = $usuario;
                $estadoLogin = true;
            }
        }
    }

    if ($estadoLogin) {
        header("Location: " . Parameters::$BASE_URL);
        exit(); 
    } else {
        $_SESSION["statusLastAction"] = [
            "tipo" => "error",
            "mensaje" => "Credenciales incorrectas"
        ];
        ViewController::show('views/usuarios/showLogin.php', ["estadoLogin" => $estadoLogin]);
    }
}

    public function closeSession(){
        if (Authentication::isUserLogged()) unset($_SESSION['user']);
        
        header("Location: " . PARAMETERS::$BASE_URL);
        exit();
    }

    public function getAllUsers(){
        $usuarioModel = new UsuarioModel();
        $users = $usuarioModel->getAllUsers();
        // Vista:  
        ViewController::show('views/usuarios/showUser.php', ["users" => $users]);
    }

    public function showEditar() {
    $idSesion = $_SESSION['user']->ID ?? $_SESSION['user']->id ?? null;
    
    $idUsuario = $_GET["id"] ?? $idSesion;

    if ($idUsuario) {
        $usuarioModel = new UsuarioModel();
        $usuario = $usuarioModel->getOne($idUsuario);

        if ($usuario) {
            $idObtenido = $usuario->ID ?? null;
            $rolSesion = $_SESSION['user']->Rol ?? $_SESSION['user']->rol ?? '';

            $esAdmin = ($rolSesion === 'admin'); 
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

        $errores = array();

        if (empty($errores)) {
            $usuarioModel = new UsuarioModel();
            $user = new UserEntity();
            
            $user->setId($idPost)
                 ->setNombre($_POST["nombre"])
                 ->setApellidos($_POST["apellidos"])
                 ->setRol($_POST["rol"]);

            if (isset($_POST["password"]) && trim($_POST["password"]) != "") {
                $user->setPasswordSecure(password_hash($_POST["password"], PASSWORD_DEFAULT));
            }
                
            $resultado = $usuarioModel->update($user);

            if ($resultado) {
                $_SESSION["statusLastAction"] = [
                    "tipo" => "exito",
                    "mensaje" => "El perfil del usuario se modificó correctamente."
                ];    
                
                if (isset($_SESSION['user']->ID)) {
                    $_SESSION['user']->Nombre = $user->getNombre();
                    $_SESSION['user']->Apellidos = $user->getApellidos();
                    $_SESSION['user']->Rol = $user->getRol();
                } else {
                    $_SESSION['user']->nombre = $user->getNombre();
                    $_SESSION['user']->apellidos = $user->getApellidos();
                    $_SESSION['user']->rol = $user->getRol();
                }

            } else {
                $_SESSION["statusLastAction"] = [
                    "tipo" => "error",
                    "mensaje" => "No se ha podido modificar el perfil en la base de datos."
                ];                
            }

            $usuario = $usuarioModel->getOne($idPost);
            ViewController::show('views/usuarios/showEditar.php', ['usuario' => $usuario]);

        } else {
            ViewController::show('views/usuarios/showEditar.php', ['dataPOST' => $_POST, 'validationsError' => $errores]);
        }
    
    } else {
        ViewController::showError(403);
    }
}

     public function showCrear(){

        if (Authentication::isUserLogged()){
        
            $usuarioModel = new UsuarioModel();
            $users = $usuarioModel->getAll();
            ViewController::show('views/usuarios/showCrear.php', ["usuarios" => $users]);

        }else{
            ViewController::showError(403);
        }
    }

    public function crear(){

        if (Authentication::isUserLogged() && isset($_POST['email'])){
            $usuarioModel = new UsuarioModel();
            $users = $usuarioModel->getAll();
                $errores = array();
                
                
                if (empty($errores)){
                    $user = new UserEntity();
                    $user->setId(uniqid('USR-')) 
                        ->setNombre($_POST['nombre'])
                        ->setApellidos($_POST['apellidos'])
                        ->setEmail($_POST['email'])
                        ->setPasswordSecure(password_hash($_POST['password'], PASSWORD_DEFAULT))
                        ->setRol('user'); 
                    
                    $resultado = $usuarioModel->create($user);

                    if ($resultado){
                            $_SESSION["statusLastAction"] = [
                                "tipo" => "exito",
                                "mensaje" => "El usuario se creó correctamente."
                            ];                
                    }else{
                            $_SESSION["statusLastAction"] = [
                                "tipo" => "error",
                                "mensaje" => "No se ha podido crear el usuario."
                            ];                
                    }   



                    ViewController::show('views/usuarios/showCrear.php', ['dataPOST' => $_POST, 'usuarios' => $user]);
                }else{
                     ViewController::show('views/usuarios/showCrear.php', ['dataPOST' => $_POST, 'validationsError' => $errores, 'usuarios' => $users]);
                }
                
            }else{
                ViewController::showError(403);
            }

    }

    public function showEliminar(){

        $idUsuario = $_GET["id"]??null;

        if ($idUsuario){
            $usuarioModel = new UsuarioModel();
            $user = $usuarioModel->getOne($idUsuario);

            if (Authentication::isUserAdminLogged() || 
                    (Authentication::isUserLogged() && $user->idUsuario == $_SESSION["user"]->id)){
        
                    $usuarioModel = new UsuarioModel();
                    $users = $usuarioModel->getAll();

                    ViewController::show('views/usuarios/showEliminar.php', ["usuario" => $user, 
                                                                                                "usuarios" => $users]);                                                                                             
                        
            }else{
                ViewController::showError(403);
            }

        }else{
            ViewController::showError(404);
        }      
    }

    public function eliminar(){
        if (isset($_POST['id'])){
                
            $usuarioModel = new UsuarioModel();
            $user = $usuarioModel->getOne($_POST['id']);
            
            if (Authentication::isUserAdminLogged() || 
                    (Authentication::isUserLogged() && $user->idUsuario == $_SESSION["user"]->id)){

                $resultado = $usuarioModel->delete($_POST['id']);                
                if ($resultado){
                    $_SESSION["statusLastAction"] = [
                        "tipo" => "exito",
                        "mensaje" => "El usuario se eliminó correctamente."
                    ];                
                }else{
                    $_SESSION["statusLastAction"] = [
                        "tipo" => "error",
                        "mensaje" => "No se ha podido eliminar el usuario."
                    ];                
                }                    

                GoRoute::go();        

                
            }else{
                ViewController::showError(403);    
            }                                            
            
        }else{
            ViewController::showError(404);
        }
    }

    

}