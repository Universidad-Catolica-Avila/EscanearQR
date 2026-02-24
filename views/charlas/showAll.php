<?php
    use Mgj\ProyectoBlog2025\Config\Parameters;
    $tituloPagina = "Listado de Charlas y Asistencia";
    $baseUrl = Parameters::getBaseUrl();
?>
<?php require_once 'Views/layout/header.php'; ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-microphone me-2"></i><?= $tituloPagina ?></h2>
        <a href="<?= $baseUrl ?>index.php?controller=Charla&action=crear" class="btn btn-primary shadow-sm">
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
                                    // Soportamos tanto el método getter como la propiedad directa por si acaso
                                    $idActual = (method_exists($charla, 'getIDCharla')) ? $charla->getIDCharla() : ($charla->ID_Charla ?? $charla->id_charla); 
                                ?>
                                <tr>
                                    <td><?= $idActual ?></td>
                                    <td><strong><?= htmlspecialchars((method_exists($charla, 'getTitulo')) ? $charla->getTitulo() : ($charla->Titulo ?? 'Sin Título')) ?></strong></td>
                                    <td><?= htmlspecialchars((method_exists($charla, 'getLugar')) ? $charla->getLugar() : ($charla->Lugar ?? 'N/A')) ?></td>
                                    <td>
                                        <?php 
                                            $fecha = (method_exists($charla, 'getFechaCharla')) ? $charla->getFechaCharla() : ($charla->Fecha_Charla ?? 'now');
                                            echo date('d/m/Y H:i', strtotime($fecha)); 
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group mb-1">
                                            <a href="<?= $baseUrl ?>index.php?controller=Charla&action=editar&id=<?= $idActual ?>" 
                                               class="btn btn-warning btn-sm shadow-sm" style="color: black !important;">
                                                <i class="fas fa-edit"></i> Editar
                                            </a>
                                            <a href="<?= $baseUrl ?>index.php?controller=Charla&action=eliminar&id=<?= $idActual ?>" 
                                               class="btn btn-danger btn-sm shadow-sm" 
                                               onclick="return confirm('¿Estás seguro de que deseas eliminar esta charla?')">
                                                <i class="fas fa-trash"></i> Borrar
                                            </a>
                                        </div>
                                        
                                        <div class="d-block mb-1">
                                            <hr class="my-1 opacity-25">
                                        </div>

                                        <div class="btn-group">
                                            <a href="<?= $baseUrl ?>index.php?controller=Asistencia&action=lector&id=<?= $idActual ?>" class="btn btn-success btn-sm shadow-sm">
                                                <i class="fas fa-qrcode"></i> Lector
                                            </a>
                                            <a href="<?= $baseUrl ?>index.php?controller=Asistencia&action=ver&id=<?= $idActual ?>" class="btn btn-info btn-sm text-white shadow-sm">
                                                <i class="fas fa-users"></i> Lista
                                            </a>
                                            <a href="<?= $baseUrl ?>index.php?controller=Asistencia&action=exportarExcel&id=<?= $idActual ?>" class="btn btn-dark btn-sm shadow-sm">
                                                <i class="fas fa-file-excel"></i> Excel
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="5" class="text-center py-4">No hay charlas registradas.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once 'Views/layout/footer.php'; ?>