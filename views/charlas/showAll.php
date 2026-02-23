<?php
    use Mgj\ProyectoBlog2025\Config\Parameters;
    $tituloPagina = "Listado de Charlas y Asistencia";
?>
<?php require_once 'Views/layout/header.php'; ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><?= $tituloPagina ?></h2>
        <a href="<?= Parameters::$BASE_URL ?>Charla/crear" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus"></i> Nueva Charla
        </a>
    </div>

    <div class="card shadow border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 5%">ID</th>
                            <th style="width: 25%">Título</th>
                            <th style="width: 15%">Lugar</th>
                            <th style="width: 15%">Fecha</th>
                            <th style="width: 40%" class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($charlas)): ?>
        <?php foreach($charlas as $charla): ?>
            <?php 
                $idActual = $charla->getIDCharla(); 
            ?>
            <tr>
                <td><?= $idActual ?></td>
                <td><strong><?= $charla->getTitulo() ?></strong></td>
                <td><?= $charla->getLugar() ?></td>
                <td><?= date('d/m/Y H:i', strtotime($charla->getFechaCharla())) ?></td>
                <td class="text-center">
                    <a href="<?= Parameters::$BASE_URL ?>Charla/editar&id=<?= $idActual ?>" 
                       class="btn btn-warning btn-sm" style="color: black !important;">
                       <i class="fas fa-edit"></i> Editar
                    </a>
                    <br>
                    <a href="<?= Parameters::$BASE_URL ?>Charla/eliminar&id=<?= $idActual ?>" 
                       class="btn btn-danger btn-sm" 
                       onclick="return confirm('¿Estás seguro de que deseas eliminar esta charla?')">
                       <i class="fas fa-trash"></i> Borrar
                    </a>
                    <br>
                    <span style="color: #ccc; margin: 0 5px;">------</span>
                    <br>
                    <a href="<?= Parameters::$BASE_URL ?>Asistencia/lector&id=<?= $idActual ?>" class="btn btn-success btn-sm">
                       <i class="fas fa-qrcode"></i> Lector
                    </a>
                    <br>
                    <a href="<?= Parameters::$BASE_URL ?>Asistencia/ver&id=<?= $idActual ?>" class="btn btn-info btn-sm text-white">
                       <i class="fas fa-users"></i> Lista
                    </a>
                    <br>
                    <a href="<?= Parameters::$BASE_URL ?>Asistencia/exportarExcel&id=<?= $idActual ?>" class="btn btn-dark btn-sm">
                       <i class="fas fa-file-excel"></i> Excel
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr><td colspan="5" class="text-center">No hay charlas registradas.</td></tr>
    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once 'Views/layout/footer.php'; ?>