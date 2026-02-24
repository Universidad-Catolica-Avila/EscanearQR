<?php
    use Mgj\ProyectoBlog2025\Config\Parameters;
    $baseUrl = Parameters::getBaseUrl();
    
    require_once 'Views/layout/header.php';
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-primary"><i class="fas fa-clipboard-list me-2"></i>Registro de Asistencias</h2>
                <div>
                    <a href="<?= $baseUrl ?>Charla/getAll" class="btn btn-sm btn-outline-primary shadow-sm">
                        <i class="fas fa-calendar-alt me-1"></i> Ver Charlas
                    </a>
                    <button onclick="window.print()" class="btn btn-sm btn-secondary ms-2 shadow-sm">
                        <i class="fas fa-print me-1"></i> Imprimir
                    </button>
                </div>
            </div>

            <div class="card shadow border-0">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th class="ps-4">FECHA Y HORA</th>
                                    <th>CHARLA / EVENTO</th>
                                    <th>ID ALUMNO (CÓDIGO QR)</th>
                                    <th class="text-center">ESTADO</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($registros) && !empty($registros)): ?>
                                    <?php foreach($registros as $reg): ?>
                                        <tr>
                                            <td class="ps-4">
                                                <span class="d-block fw-bold"><?= date('d/m/Y', strtotime($reg->Fecha_Registro)) ?></span>
                                                <small class="text-muted"><?= date('H:i:s', strtotime($reg->Fecha_Registro)) ?></small>
                                            </td>
                                            <td>
                                                <span class="fw-bold text-dark"><?= htmlspecialchars($reg->Titulo ?? 'Sin Título') ?></span>
                                            </td>
                                            <td>
                                                <code class="bg-light p-1 px-2 rounded text-primary border">
                                                    <?= htmlspecialchars($reg->ID_Alumno) ?>
                                                </code>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge rounded-pill bg-success px-3">Presente</span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center py-5">
                                            <p class="mb-0 text-muted">No se encontraron registros de asistencia.</p>
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