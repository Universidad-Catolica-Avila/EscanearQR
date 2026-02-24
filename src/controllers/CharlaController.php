<?php
namespace Mgj\ProyectoBlog2025\Controllers;

use Mgj\ProyectoBlog2025\Models\CharlaModel;
use Mgj\ProyectoBlog2025\Entities\CharlaEntity; 
use Mgj\ProyectoBlog2025\Helpers\Authentication;
use Mgj\ProyectoBlog2025\Config\Parameters;

class CharlaController {

    private $model;

    public function __construct() {
        Authentication::isUserLogged();
        $this->model = new CharlaModel();
    }

    public function index() {
        $charlas = $this->model->getAll();
        require_once 'Views/charlas/showAll.php';
    }

    public function getAll() {
        $charlaModel = new \Mgj\ProyectoBlog2025\Models\CharlaModel();
        $charlas = $charlaModel->getAll(); 
        
        $baseUrl = \Mgj\ProyectoBlog2025\Config\Parameters::getBaseUrl();
        
        require_once 'Views/layout/header.php'; 
        require_once 'Views/charlas/showAll.php'; 
        require_once 'Views/layout/footer.php';
    }

    public function crear() {
        $tituloPagina = "Nueva Charla";
        $formAction = Parameters::getBaseUrl() . "Charla/save";
        $modo = "crear";
        
        require_once 'Views/charlas/components/componentFormCharla.php';
    }

    public function editar() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location: " . Parameters::getBaseUrl() . "Charla/index");
            exit;
        }

        $charla = $this->model->getOne($id);

        if (!$charla) {
            $_SESSION['error'] = "La charla no existe.";
            header("Location: " . Parameters::getBaseUrl() . "Charla/index");
            exit;
        }

        $tituloPagina = "Editar Charla";
        $formAction = Parameters::getBaseUrl() . "Charla/save";
        $modo = "editar";

        require_once 'Views/charlas/components/componentFormCharla.php';
    }

    public function eliminar() {
        $id = $_GET['id'] ?? null;

        if ($id) {
            try {
                $db = $this->model->getConn();

                $sqlAsistencia = "DELETE FROM dbo.Tabla_Asistencia WHERE ID_Charla = :id";
                $stmtA = $db->prepare($sqlAsistencia);
                $stmtA->execute([':id' => $id]);

                $sqlCharla = "DELETE FROM dbo.Tabla_Charlas WHERE ID_Charla = :id"; 
                $stmtC = $db->prepare($sqlCharla);
                $result = $stmtC->execute([':id' => $id]);

                if ($result) {
                    $_SESSION['completado'] = "Charla eliminada correctamente.";
                }
            } catch (\Exception $e) {
                $_SESSION['error'] = "No se pudo eliminar: " . $e->getMessage();
            }
        }

        header("Location: " . Parameters::getBaseUrl() . "Charla/index");
        exit;
    }

    public function save() {
        $id_charla = $_POST['id_charla'] ?? null; 
        $titulo    = $_POST['titulo'] ?? null;
        $lugar     = $_POST['lugar'] ?? null;
        $fecha     = $_POST['fecha'] ?? null;

        if ($titulo && $lugar && $fecha) {
            $fechaSQL = str_replace('T', ' ', $fecha);

            try {
                $db = $this->model->getConn();

                if ($id_charla) {
                    $sql = "UPDATE dbo.Tabla_Charlas 
                            SET Titulo = :titulo, Lugar = :lugar, Fecha_Charla = :fecha 
                            WHERE ID_Charla = :id";
                    $stmt = $db->prepare($sql);
                    $stmt->bindValue(':id', $id_charla);
                } else {
                    $sql = "INSERT INTO dbo.Tabla_Charlas (Titulo, Fecha_Charla, Lugar) 
                            VALUES (:titulo, :fecha, :lugar)";
                    $stmt = $db->prepare($sql);
                }

                $stmt->bindValue(':titulo', $titulo);
                $stmt->bindValue(':fecha', $fechaSQL);
                $stmt->bindValue(':lugar', $lugar);

                if ($stmt->execute()) {
                    $_SESSION['completado'] = "Guardado con éxito.";
                } else {
                    $_SESSION['error'] = "Error al ejecutar en BD.";
                }
            } catch (\Exception $e) {
                $_SESSION['error'] = "Error: " . $e->getMessage();
            }
        }
        header("Location: " . Parameters::getBaseUrl() . "Charla/index");
        exit;
    }
}