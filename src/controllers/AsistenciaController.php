<?php
namespace Mgj\ProyectoBlog2025\Controllers;

use Mgj\ProyectoBlog2025\Models\AsistenciaModel;
use Mgj\ProyectoBlog2025\Entities\ConvtituEntity; 
use Mgj\ProyectoBlog2025\Helpers\Authentication;
use Mgj\ProyectoBlog2025\Config\Parameters;
use Mgj\ProyectoBlog2025\Models\CharlaModel;

class AsistenciaController {

    private $model;
    private $charlaModel;

    public function __construct() {
        $this->model = new AsistenciaModel();
        $this->charlaModel = new CharlaModel(); 
    }

    public function lector() {
    $id_charla = $_GET['id'] ?? null;

    if (!$id_charla) {
        header("Location: " . Parameters::$BASE_URL . "Charla/index");
        exit;
    }

    $charla = $this->charlaModel->getOne($id_charla);

    if (!$charla) {
        die("Error: La charla con ID $id_charla no existe.");
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
                $nombreCompleto = $alumno ? $alumno['Nombre'] . " " . $alumno['Apellidos'] : "Alumno";
                
                echo json_encode([
                    'status' => 'success', 
                    'message' => "¡Bienvenido, $nombreCompleto! Asistencia registrada."
                ]);
            } else {
                echo json_encode([
                    'status' => 'error', 
                    'message' => 'Error: El alumno ya está registrado en esta charla'
                ]);
            }
        } else {
            echo json_encode([
                'status' => 'error', 
                'message' => 'Datos incompletos (Falta Charla o Alumno)'
            ]);
        }
    } else {
        echo json_encode([
            'status' => 'error', 
            'message' => 'Método de petición no válido'
        ]);
    }
    exit;
}

public function getAll() {
    $registros = $this->model->obtenerListadoCompleto();
    
    require_once 'Views/asistencias/showAll.php';
}

public function exportarExcel() {
    if (ob_get_length()) ob_end_clean();

    $id_charla = $_GET['id'] ?? null;
    if (!$id_charla) die("ID de charla no proporcionado.");

    $filename = "Asistencia_Charla_" . $id_charla . "_" . date('Ymd') . ".csv";
    
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Pragma: no-cache');
    header('Expires: 0');

    $output = fopen('php://output', 'w');
    
    fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

    fputcsv($output, ['ID Alumno', 'Nombre', 'Apellidos', 'Email', 'Fecha/Hora Registro']);

    $sql = "SELECT u.ID, u.Nombre, u.Apellidos, u.Email, a.Fecha_Registro 
            FROM dbo.Tabla_Asistencia a
            INNER JOIN dbo.Tabla_Usuarios_20260217095138 u ON a.ID_Alumno = u.ID
            WHERE a.ID_Charla = :id_charla
            ORDER BY a.Fecha_Registro DESC";

    try {
        $stmt = $this->model->getConn()->prepare($sql);
        $stmt->execute([':id_charla' => $id_charla]);

        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            fputcsv($output, $row);
        }
    } catch (\Exception $e) {
        fputcsv($output, ['Error en la consulta', $e->getMessage()]);
    }

    fclose($output);
    exit;
}

public function ver() {
    $id_charla = $_GET['id'] ?? null;
    if (!$id_charla) header("Location: " . Parameters::$BASE_URL . "Charla/showAll");

    $sql = "SELECT a.ID_Asistencia, u.ID, u.Nombre, u.Apellidos, u.Email, a.Fecha_Registro 
            FROM dbo.Tabla_Asistencia a
            INNER JOIN dbo.Tabla_Usuarios_20260217095138 u ON a.ID_Alumno = u.ID
            WHERE a.ID_Charla = :id_charla
            ORDER BY a.Fecha_Registro DESC";

    $stmt = $this->model->getConn()->prepare($sql);
    $stmt->execute([':id_charla' => $id_charla]);
    $asistentes = $stmt->fetchAll(\PDO::FETCH_OBJ);

    require_once 'Views/asistencias/ver.php';
}

public function eliminarRegistro() {
    $id_asistencia = $_GET['id_asistencia'] ?? null;
    $id_charla = $_GET['id_charla'] ?? null;

    if ($id_asistencia) {
        $sql = "DELETE FROM dbo.Tabla_Asistencia WHERE ID_Asistencia = :id";
        $stmt = $this->model->getConn()->prepare($sql);
        $stmt->execute([':id' => $id_asistencia]);
        $_SESSION['completado'] = "Asistente eliminado correctamente.";
    }

    header("Location: " . Parameters::$BASE_URL . "Asistencia/ver&id=" . $id_charla);
}
}