<?php
    use Mgj\ProyectoBlog2025\Config\Parameters;
    
    $modo = "crear";
    $formAction = Parameters::$BASE_URL . "Charla/crear"; 
    $tituloPagina = "Registrar Nueva Charla";


    include 'components/componentFormCharla.php'; 
?>