<?php 
    use Mgj\ProyectoBlog2025\Config\Parameters; 
    $baseUrl = Parameters::getBaseUrl();
    
    $id_charla = $_GET['id'] ?? 0;

    require_once 'Views/layout/header.php'; 
?>

<div class="container mt-4">
    <?php if(isset($_SESSION['completado'])): ?>
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert" style="border-left: 5px solid #198754 !important;">
            <i class="fas fa-check-circle me-2"></i><strong>¡Hecho!</strong> <?= $_SESSION['completado']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['completado']); ?>
    <?php endif; ?>

    <?php if(isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 mb-4" role="alert" style="border-left: 5px solid #dc3545 !important;">
            <i class="fas fa-exclamation-triangle me-2"></i><strong>Error:</strong> <?= $_SESSION['error']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="text-primary fw-bold mb-0">Listado de Asistentes</h2>
            <p class="text-muted small">Visualización de alumnos registrados mediante código QR</p>
        </div>
        <div class="d-flex gap-2">
            <?php if (!empty($asistentes)): ?>
                <a href="<?= $baseUrl ?>index.php?controller=Asistencia&action=exportarExcel&id=<?= $id_charla ?>" class="btn btn-success shadow-sm">
                    <i class="fas fa-file-excel me-1"></i> Exportar CSV
                </a>
            <?php endif; ?>

            <a href="<?= $baseUrl ?>index.php?controller=Charla&action=getAll" class="btn btn-outline-secondary shadow-sm">
                <i class="fas fa-arrow-left me-1"></i> Volver a Charlas
            </a>
        </div>
    </div>

    <div class="card shadow-lg border-0" style="border-radius: 12px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="ps-4">ID</th>
                            <th>Nombre Completo</th>
                            <th>Email</th>
                            <th>Hora de Registro</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if (!empty($asistentes)): 
                            foreach($asistentes as $asistente): 
                                $idAsis    = $asistente->ID_Asistencia ?? $asistente->id_asistencia ?? $asistente->ID ?? $asistente->id;
                                $nombre    = $asistente->Nombre ?? $asistente->nombre ?? 'N/A';
                                $apellidos = $asistente->Apellidos ?? $asistente->apellidos ?? '';
                                $email     = $asistente->Email ?? $asistente->email ?? 'Sin correo';
                                $fecha     = $asistente->Fecha_Registro ?? $asistente->fecha_registro ?? null;
                        ?>
                            <tr>
                                <td class="ps-4 text-muted small">#<?= $idAsis ?></td>
                                <td>
                                    <div class="fw-bold text-dark"><?= htmlspecialchars($nombre . " " . $apellidos) ?></div>
                                </td>
                                <td><?= htmlspecialchars($email) ?></td>
                                <td>
                                    <span class="badge bg-light text-dark border">
                                        <i class="far fa-clock me-1 text-primary"></i>
                                        <?= $fecha ? date('d/m/Y H:i:s', strtotime($fecha)) : '---' ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="<?= $baseUrl ?>index.php?controller=Asistencia&action=eliminar&id=<?= $idAsis ?>&id_charla=<?= $id_charla ?>" 
                                       class="btn btn-outline-danger btn-sm border-0" 
                                       onclick="return confirm('¿Estás seguro de que deseas eliminar este registro de asistencia?')">
                                         <i class="fas fa-trash-alt me-1"></i> Quitar
                                    </a>
                                </td>
                            </tr>
                        <?php 
                            endforeach; 
                        else: 
                        ?>
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="mb-3">
                                        <i class="fas fa-user-slash fa-3x text-light"></i>
                                    </div>
                                    <h5 class="text-muted">Aún no hay alumnos registrados en esta charla.</h5>
                                    <p class="small text-muted">Asegúrate de que los alumnos escaneen el código QR correctamente.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once 'Views/layout/footer.php'; ?>