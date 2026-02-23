<?php
    use Mgj\ProyectoBlog2025\Config\Parameters;
    require_once 'Views/layout/header.php';
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="fas fa-clipboard-list me-2"></i>Registro de Asistencias</h2>
                <div>
                    <a href="<?= Parameters::$BASE_URL ?>Charla/index" class="btn btn-outline-primary">
                        <i class="fas fa-calendar-alt"></i> Ver Charlas
                    </a>
                    <button onclick="window.print()" class="btn btn-secondary ms-2">
                        <i class="fas fa-print"></i> Imprimir
                    </button>
                </div>
            </div>

            <div class="card shadow border-0">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th class="ps-4">Fecha y Hora</th>
                                    <th>Charla / Evento</th>
                                    <th>ID Alumno (Código QR)</th>
                                    <th class="text-center">Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($registros)): ?>
                                    <?php foreach($registros as $reg): ?>
                                        <tr>
                                            <td class="ps-4">
                                                <?= date('d/m/Y', strtotime($reg->Fecha_Registro)) ?>
                                                <small class="text-muted d-block"><?= date('H:i:s', strtotime($reg->Fecha_Registro)) ?></small>
                                            </td>
                                            <td>
                                                <span class="fw-bold"><?= htmlspecialchars($reg->Charla) ?></span>
                                            </td>
                                            <td>
                                                <code class="bg-light p-1 px-2 rounded text-primary border">
                                                    <?= $reg->ID_Alumno ?>
                                                </code>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-success-soft text-success border border-success px-3">
                                                    Presente
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center py-5">
                                            <img src="<?= Parameters::$BASE_URL ?>assets/img/empty.svg" alt="No data" style="width: 100px; opacity: 0.5;">
                                            <p class="mt-3 text-muted">Aún no se han escaneado asistencias para ninguna charla.</p>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
require_once 'Views/layout/footer.php'; 
?>
