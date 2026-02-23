<?php
namespace Mgj\ProyectoBlog2025\Models;
use Psr\Log\LoggerInterface;
use Mgj\ProyectoBlog2025\Helpers\LogFactory;
use Mgj\ProyectoBlog2025\Database\Conexion;

class Model{
    protected LoggerInterface $log;
    protected $conn;
    protected $tabla;

    public function __construct(){
        $this->log = LogFactory::getLogger("Model");
        $this->conn = Conexion::conectar();        
    }

    public function getOne($id){
        try {

            $consulta = "select * from {$this->tabla} where id = :id";

            $sentencia = $this->conn->prepare($consulta);
            $sentencia->bindParam(':id', $id);
            $sentencia->setFetchMode(\PDO::FETCH_OBJ);
            $sentencia->execute();
            
            $resultado = $sentencia->fetch();
            return $resultado;

        } catch (\PDOException $e) {
            echo '<p>Fallo en la conexion:' . $e->getMessage() . '</p>';
            // Registrar en un sistema de Log
            return NULL;
        }
    }
    public function getAll(){
        try {

            $consulta = "select * from {$this->tabla}";

            $sentencia = $this->conn->prepare($consulta);
            $sentencia->setFetchMode(\PDO::FETCH_OBJ);
            $sentencia->execute();
            
            /*$resultado = [];
            while ($fila = $sentencia->fetch()) {
                $resultado[] = $fila;
            }*/
            $resultado = $sentencia->fetchAll();
            return $resultado;

        } catch (\PDOException $e) {
            // Registrar en un sistema de Log
            $this->log->error("Model. Método getAll: " . $e->getMessage());
            return NULL;
        }        
    }

    public function count():int{
         try {

            $consulta = "select count(*) as cuenta from {$this->tabla}";


            $sentencia = $this->conn->prepare($consulta);
            $sentencia->setFetchMode(\PDO::FETCH_OBJ);
            $sentencia->execute();
            
            $resultado = $sentencia->fetch();
            return $resultado->cuenta;

        } catch (\PDOException $e) {
            echo '<p>Fallo en la conexion:' . $e->getMessage() . '</p>';
            // Registrar en un sistema de Log
            return -1;
        }       
    }
}