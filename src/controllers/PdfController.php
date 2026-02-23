<?php
namespace Mgj\ProyectoBlog2025\Controllers;
use Spipu\Html2Pdf\Html2Pdf;

class PDFController{

/**
 * Summary of print
 * @param array $datos      Colección de datos que se utilizarán en la vista
 * @param string $view      Dirección de la vista que se utilizará para generar el PDF. Deberá trabajar con la información recogida en $datos
 * @return void
 */
public function print(array $datos, string $view){
    
            $html2pdf = new Html2Pdf('L', 'A4', 'es');
            ob_start();
                require_once $view;
                $info = ob_get_clean();
            ob_end_clean();
            
            $html2pdf->writeHTML($info);
            $html2pdf->output();

    }
}