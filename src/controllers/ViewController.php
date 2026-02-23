<?php
namespace Mgj\ProyectoBlog2025\Controllers;
use Mgj\ProyectoBlog2025\Models\CategoriaModel;
use Mgj\ProyectoBlog2025\Helpers\GoRoute;
class ViewController{

    public static function show($viewName = null, $data = null){
        if (isset($data)) {
        extract($data);
    }

        self::showHeader();
        self::showStatusLastAction();
        require_once $viewName;
        self::showFooter();
    }

    private static function showHeader(){
        include 'views/layout/header.php';
    }
    private static function showFooter(){
        include 'views/layout/footer.php';            
    }

    private static function showStatusLastAction(){
        if (isset($_SESSION["statusLastAction"])){
            
            $tipo = $_SESSION['statusLastAction']['tipo']; // 'exito' o 'error'
            $mensaje = $_SESSION['statusLastAction']['mensaje'];
            $icono = $tipo == 'exito' ? '✅' : '❌';
            $titulo = $tipo == 'exito' ? 'Completado' : 'Atención';
            
            include 'views/layout/showToastStatus.php';

            unset($_SESSION["statusLastAction"]);
        }
    }


    public static function showError($error){
        self::showHeader();
        $metodoError = "mostrar".$error;
        (new ErrorController())->$metodoError();
        self::showFooter();
    }

    public function goBack(){
        GoRoute::go();                 
    }
}
