<?php
use Mgj\ProyectoBlog2025\Config\Parameters;
$baseUrl = Parameters::getBaseUrl();

require_once 'Views/layout/header.php';
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <?php if (isset($_SESSION['completado'])): ?>
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fas fa-check-circle me-2"></i> <?= $_SESSION['completado']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['completado']); ?>
            <?php endif; ?>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="text-primary mb-0">
                        <i class="fas fa-users me-2"></i>Asistentes Registrados
                    </h2>
                    <p class="text-muted small mb-0">Listado detallado de participación para esta charla</p>
                </div>
                <div class="btn-group shadow-sm">
                    <a href="<?= $baseUrl ?>index.php?controller=Asistencia&action=exportarExcel&id=<?= $id_charla ?>" class="btn btn-success text-white">
                        <i class="fas fa-file-excel me-1"></i> Exportar CSV
                    </a>
                    <a href="<?= $baseUrl ?>index.php?controller=Charla&action=getAll" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Volver
                    </a>
                </div>
            </div>

            <div class="card shadow border-0 overflow-hidden">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">ALUMNO</th>
                                    <th>EMAIL</th>
                                    <th>REGISTRO</th>
                                    <th class="text-center">ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($asistentes)): ?>
                                    <?php foreach ($asistentes as $asistente): ?>
                                        <tr>
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm me-3 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px; font-weight: bold;">
                                                        <?= substr($asistente->Nombre, 0, 1) ?>
                                                    </div>
                                                    <div>
                                                        <span class="d-block fw-bold text-dark"><?= htmlspecialchars($asistente->Nombre . " " . $asistente->Apellidos) ?></span>
                                                        <small class="text-muted">ID: <?= htmlspecialchars($asistente->ID) ?></small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="mailto:<?= $asistente->Email ?>" class="text-decoration-none"><?= htmlspecialchars($asistente->Email) ?></a>
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark border">
                                                    <i class="far fa-clock me-1 text-primary"></i>
                                                    <?= date('d/m/Y H:i', strtotime($asistente->Fecha_Registro)) ?>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <a href="<?= $baseUrl ?>index.php?controller=Asistencia&action=eliminarRegistro&id_asistencia=<?= $asistente->ID_Asistencia ?>&id_charla=<?= $id_charla ?>" 
                                                   class="btn btn-sm btn-outline-danger border-0" 
                                                   onclick="return confirm('¿Estás seguro de que deseas eliminar esta asistencia?')">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="fas fa-user-slash fa-3x mb-3 opacity-25"></i>
                                                <p>Todavía no hay alumnos registrados en esta charla.</p>
                                                <a href="<?= $baseUrl ?>index.php?controller=Asistencia&action=lector&id=<?= $id_charla ?>" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-qrcode me-1"></i> Abrir Lector
                                                </a>
                                            </div>
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