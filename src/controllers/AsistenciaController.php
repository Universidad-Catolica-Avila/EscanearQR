<?php
namespace Mgj\ProyectoBlog2025\Controllers;

use Mgj\ProyectoBlog2025\Models\AsistenciaModel;
use Mgj\ProyectoBlog2025\Config\Parameters;
use Mgj\ProyectoBlog2025\Models\CharlaModel;
use Mgj\ProyectoBlog2025\Helpers\Authentication;

class AsistenciaController {

    private $model;
    private $charlaModel;

    public function __construct() {
        if (!Authentication::isUserLogged()) {
            header("Location: " . Parameters::getBaseUrl() . "index.php?controller=Usuario&action=showLogin");
            exit;
        }
        $this->model = new AsistenciaModel();
        $this->charlaModel = new CharlaModel(); 
    }

    public function getAll() {
        $asistentes = $this->model->getAll(); 
        
        require_once 'Views/asistencias/ver.php';
    }

    public function ver() {
        $id_charla = $_GET['id'] ?? null;
        
        if (!$id_charla) {
            header("Location: " . \Mgj\ProyectoBlog2025\Config\Parameters::getBaseUrl() . "index.php?controller=Charla&action=getAll");
            exit; 
        }

        $sql = "SELECT 
                    a.ID_Asistencia, 
                    u.ID AS ID_Alumno, 
                    u.Nombre, 
                    u.Apellidos, 
                    u.Email, 
                    a.Fecha_Registro 
                FROM dbo.Tabla_Asistencia a
                INNER JOIN dbo.Tabla_Usuarios_20260217095138 u ON a.ID_Alumno = u.ID
                WHERE a.ID_Charla = :id_charla
                ORDER BY a.Fecha_Registro DESC";

        try {
            $stmt = $this->model->getConn()->prepare($sql);
            $stmt->execute([':id_charla' => $id_charla]);
            
            $asistentes = $stmt->fetchAll(\PDO::FETCH_OBJ);

            require_once 'Views/asistencias/ver.php';
            
        } catch (\Exception $e) {
            die("Error en Azure SQL: " . $e->getMessage());
        }
    }

    public function lector() {
        $id_charla = $_GET['id'] ?? null;

        if (!$id_charla) {
            header("Location: " . Parameters::getBaseUrl() . "index.php?controller=Charla&action=getAll");
            exit;
        }

        $charla = $this->charlaModel->getOne($id_charla);
        if (!$charla) {
            die("Error: La charla seleccionada no existe.");
        }

        require_once 'Views/asistencias/showLector.php'; 
    }

    public function registrar() {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_charla = $_POST['id_charla'] ?? null;
            $id_alumno = $_POST['id_alumno'] ?? null;

            if ($id_charla && $id_alumno) {
                $resultado = $this->model->save($id_charla, $id_alumno);
                
                if ($resultado) {
                    $alumno = $this->model->obtenerNombreAlumno($id_alumno);
                    $nom = $alumno['Nombre'] ?? $alumno['nombre'] ?? "Alumno";
                    $ape = $alumno['Apellidos'] ?? $alumno['apellidos'] ?? "";
                    
                    echo json_encode([
                        'status' => 'success', 
                        'message' => "¡Éxito! Asistencia grabada para $nom $ape."
                    ]);
                } else {
                    echo json_encode([
                        'status' => 'error', 
                        'message' => 'El alumno ya consta como asistente a esta charla.'
                    ]);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Faltan parámetros obligatorios.']);
            }
        }
        exit;
    }

    public function exportarExcel() {
        if (ob_get_length()) ob_end_clean();

        $id_charla = $_GET['id'] ?? null;
        if (!$id_charla) die("ID de charla no válido para exportación.");

        $filename = "Asistentes_Charla_" . $id_charla . ".csv";
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF)); // Soporte para tildes en Excel

        fputcsv($output, ['ID Alumno', 'Nombre', 'Apellidos', 'Email', 'Fecha Registro']);

        $sql = "SELECT u.ID, u.Nombre, u.Apellidos, u.Email, a.Fecha_Registro 
                FROM dbo.Tabla_Asistencia a
                INNER JOIN dbo.Tabla_Usuarios_20260217095138 u ON a.ID_Alumno = u.ID
                WHERE a.ID_Charla = :id_charla";

        $stmt = $this->model->getConn()->prepare($sql);
        $stmt->execute([':id_charla' => $id_charla]);

        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            fputcsv($output, $row);
        }

        fclose($output);
        exit;
    }

    public function eliminar() {
        $id_asistencia = $_GET['id'] ?? null;
        $id_charla = $_GET['id_charla'] ?? null;

        if ($id_asistencia) {
            $sql = "DELETE FROM dbo.Tabla_Asistencia WHERE ID_Asistencia = :id";
            $stmt = $this->model->getConn()->prepare($sql);
            $stmt->execute([':id' => $id_asistencia]);
        }

        header("Location: " . Parameters::getBaseUrl() . "index.php?controller=Asistencia&action=ver&id=" . $id_charla);
        exit;
    }
}