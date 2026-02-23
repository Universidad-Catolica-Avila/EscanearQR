<?php
namespace Mgj\ProyectoBlog2025\Models;
use Mgj\ProyectoBlog2025\Entities\UserEntity;

class UsuarioModel extends Model{

    public function __construct(){
        parent::__construct();
        $this->tabla = "dbo.Tabla_Usuarios";
    }

    public function register(UserEntity $user){
    $consulta = "INSERT INTO dbo.Tabla_Usuarios (ID, Nombre, Apellidos, Email, Password, Rol) 
                 VALUES (:id, :nombre, :apellidos, :email, :password, :rol)";
    try {
        $sentencia = $this->conn->prepare($consulta);
        $sentencia->bindValue(':id', $user->getId());
        $sentencia->bindValue(':nombre', $user->getNombre());
        $sentencia->bindValue(':apellidos', $user->getApellidos());
        $sentencia->bindValue(':email', $user->getEmail());
        $sentencia->bindValue(':password', $user->getPasswordSecure());
        $sentencia->bindValue(':rol', $user->getRol());

        return $sentencia->execute();
    } catch (\PDOException $e) {
        $this->log->error("Error en register: " . $e->getMessage());
        return false;
    }
}

    public function login($email){
        $consulta =" select * from dbo.Tabla_Usuarios where Email = :email";
        try{
            $sentencia = $this->conn->prepare($consulta);
            $sentencia->bindParam(':email', $email);
            $sentencia->execute();

            // Se retorna el objeto:
            return $sentencia->fetch(\PDO::FETCH_OBJ);
        }catch(\PDOException $e){
            $this->log->error("UsuarioModel. Método login: " . $e->getMessage(), ["email" => $email]);
            return NULL;
        }
    }

    public function getAllUsers(){
        $consulta =" select * from dbo.Tabla_Usuarios";
        try{
            $sentencia = $this->conn->prepare($consulta);
            $sentencia->execute();

            // Se retorna el objeto:
            return $sentencia->fetchAll(\PDO::FETCH_OBJ);
        }catch(\PDOException $e){
            $this->log->error("UsuarioModel. Método getAllUsers: " . $e->getMessage());
            return NULL;
        }
    }

    public function create(UserEntity $user){
        $consulta = "insert into dbo.Tabla_Usuarios(Nombre, Apellidos, Email, Password)
        values(:nombre, :apellidos, :email, :password)";

        try{
            $sentencia = $this->conn->prepare($consulta);
            $nombre = $user->getNombre();
            $apellidos = $user->getApellidos();
            $email = $user->getEmail();
            $password = $user->getPasswordSecure();


            $sentencia->bindParam(':nombre', $nombre);
            $sentencia->bindParam(':apellidos', $apellidos);
            $sentencia->bindParam(':email', $email);
            $sentencia->bindParam(':password', $password);

            return $sentencia->execute();                
        }catch(\PDOException $e){
            $this->log->error("UsuarioModel. Método create: " . $e->getMessage(), ["UsuarioEntity" => $user]);
            return NULL;
        }
        
    }

    public function update(UserEntity $user){
            $consulta = "update dbo.Tabla_Usuarios set Nombre=:nombre, Apellidos=:apellidos";
            if ($user->getPasswordSecure())  $consulta .= ", Password=:password";
            $consulta .= " where ID = :idUsuario";
            
            try{
                $idUsuario =  $user->getId();
                $nombre = $user->getNombre();
                $apellidos = $user->getApellidos();
                //$email = $user->getEmail();
                $passwordSecure = $user->getPasswordSecure();

                $sentencia = $this->conn->prepare($consulta);
                $sentencia->bindParam(':nombre', $nombre);
                $sentencia->bindParam(':apellidos', $apellidos);
                $sentencia->bindParam(':idUsuario', $idUsuario);
                if ($user->getPasswordSecure()) $sentencia->bindParam(':password', $passwordSecure);
                

                return $sentencia->execute();                
            }catch(\PDOException $e){
                $this->log->error("UsuarioModel. Método update: " . $e->getMessage(), ["UserEntity" => $user]);
                return NULL;
            }

    }

    public function delete($idUsuario){
        $consulta = "delete from dbo.Tabla_Usuarios where ID = :idUsuario";
        //$consulta = "update from entradas set borrada=1 where id = :idEntrada";

        try{
            $sentencia = $this->conn->prepare($consulta);
            $sentencia->bindParam(':idUsuario', $idUsuario);
            return $sentencia->execute();                
        }catch(\PDOException $e){
            $this->log->error("UsuarioModel. delete: " . $e->getMessage(), ["idUsuario" => $idUsuario]);
            return NULL;
        }
    }
}