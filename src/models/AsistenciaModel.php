<?php
namespace Mgj\ProyectoBlog2025\Models;

class AsistenciaModel extends Model {

    public function __construct() {
        parent::__construct(); 
        $this->tabla = "dbo.Tabla_Asistencia";
    }

    public function obtenerListadoCompleto() {
        $sql = "SELECT a.ID_Asistencia, c.Titulo as Charla, a.ID_Alumno, a.Fecha_Registro 
                FROM dbo.Tabla_Asistencia a
                INNER JOIN dbo.Tabla_Charlas c ON a.ID_Charla = c.ID_Charla
                ORDER BY a.Fecha_Registro DESC";
        
        $stmt = $this->conn->prepare($sql); 
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function save($id_charla, $id_alumno) {
    try {
        $sql = "INSERT INTO dbo.Tabla_Asistencia (ID_Charla, ID_Alumno, Fecha_Registro) 
                VALUES (:id_charla, :id_alumno, GETDATE())";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_charla', $id_charla);
        $stmt->bindParam(':id_alumno', $id_alumno);
        
        return $stmt->execute();
    } catch (\PDOException $e) {
        return false;
    }
}

public function getConn() {
    return $this->conn;
}

public function obtenerNombreAlumno($id_alumno) {
    $sql = "SELECT Nombre, Apellidos FROM dbo.Tabla_Usuarios_20260217095138 WHERE ID = :id";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([':id' => $id_alumno]);
    return $stmt->fetch(\PDO::FETCH_ASSOC);
}
}