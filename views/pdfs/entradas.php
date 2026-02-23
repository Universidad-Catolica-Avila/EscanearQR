<?php
	use Mgj\ProyectoBlog2025\Config\Parameters;
    use Mgj\ProyectoBlog2025\Helpers\DateConversions;

?>
<!DOCTYPE HTML>
<html lang="es">
	<head>
		<meta charset="utf-8" />
		<title>Blog Alonso de Madrigal</title>
        <link rel="stylesheet" type="text/css" href="<?=Parameters::getBasePath()?>assets/css/stylePdf.css" />
	</head>
	<body>

<?php
        // Necesita dentro de la colección $datos que recibirá del método print del PdfController:
        //      $datos["titulo]     Título se mostrará en la cabecera del PDF
        //      $datos["entradas"]  Colección de entradas que se mostrarán en este PDF

        echo "<h1> Listado de Entradas </h1>";
        echo "<h2>".$datos["titulo"]."</h2>";
        echo "<table>
                <tr>
                    <th>Título</th>
                    <th> Descripción </th>
                    <th> Categoría </th>
                    <th> Fecha </th>
                </tr>";

        foreach($datos["entradas"] as $entrada){
            echo "<tr>
                     <td> {$entrada->titulo} </td>
                     <td> {$entrada->nombreCategoria} </td>
                     <td> ".$entrada->nombreUsuario . " " . $entrada->apellidos . "</td>
                     <td> ".DateConversions::formatearCastellano($entrada->fechaEntrada)."</td>
                  </tr>";
        }    

        echo "</table>";
    
?>

</body>
</html>