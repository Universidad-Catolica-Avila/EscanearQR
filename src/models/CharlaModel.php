<?php
namespace Mgj\ProyectoBlog2025\Models;

use Mgj\ProyectoBlog2025\Entities\CharlaEntity;

class CharlaModel extends Model {
    public function __construct(){
        parent::__construct();
        $this->tabla = "dbo.Tabla_Charlas"; 
    }

    public function getOne($id) {
        try {
            $sql = "SELECT * FROM {$this->tabla} WHERE ID_Charla = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->setFetchMode(\PDO::FETCH_OBJ);
            $stmt->execute();
            
            return $stmt->fetch();
        } catch (\PDOException $e) {
            return null;
        }
    }

    public function getAll() {
        $sql = "SELECT * FROM {$this->tabla} ORDER BY Fecha_Charla DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_CLASS, CharlaEntity::class);
    }

    public function save($charla) {
    $sql = "INSERT INTO dbo.Tabla_Charlas (Titulo, Lugar, Fecha_Charla) 
            VALUES (:titulo, :lugar, :fecha)";
    
    $stmt = $this->conn->prepare($sql);
    
    return $stmt->execute([
        ':titulo' => $charla->getTitulo(),
        ':lugar'  => $charla->getLugar(),
        ':fecha'  => $charla->getFechaCharla()
    ]);
}

public function getConn() {
        return $this->conn;
    }
    
}