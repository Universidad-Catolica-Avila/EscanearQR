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

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="text-primary fw-bold mb-0">Listado de Asistentes</h2>
            <p class="text-muted small">Registros de la Charla #<?= htmlspecialchars($id_charla) ?></p>
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
                            <th class="ps-4">ID Alumno</th> <th>Nombre Completo</th>
                            <th>Email</th>
                            <th>Hora de Registro</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if (!empty($asistentes)): 
                            foreach($asistentes as $asistente): 
                                $item = (array) $asistente;

                                // --- SOLUCIÓN ID ALUMNO ---
                                // Buscamos 'ID_Alumno' que es la FK en tu tabla de asistencia
                                // O 'ID' si el controlador lo trae de la tabla de usuarios
                                $idAlumno  = $item['ID_Alumno'] ?? $item['id_alumno'] ?? $item['ID'] ?? $item['id'] ?? '---';
                                
                                // El ID de la fila de asistencia (necesario para eliminar)
                                $idAsis    = $item['ID_Asistencia'] ?? $item['id_asistencia'] ?? 0;

                                $nombre    = $item['Nombre'] ?? $item['nombre'] ?? 'N/A';
                                $apellidos = $item['Apellidos'] ?? $item['apellidos'] ?? '';
                                $email     = !empty($item['Email']) ? $item['Email'] : 'Sin email';
                                $fecha     = $item['Fecha_Registro'] ?? $item['fecha_registro'] ?? null;
                        ?>
                            <tr>
                                <td class="ps-4">
                                    <span class="badge bg-primary rounded-pill px-3">
                                        <?= $idAlumno ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark"><?= htmlspecialchars(trim($nombre . " " . $apellidos)) ?></div>
                                </td>
                                <td>
                                    <span class="text-muted small"><?= htmlspecialchars($email) ?></span>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border font-monospace">
                                        <?= $fecha ? date('d/m/Y H:i', strtotime($fecha)) : '---' ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="<?= $baseUrl ?>index.php?controller=Asistencia&action=eliminar&id=<?= $idAsis ?>&id_charla=<?= $id_charla ?>" 
                                       class="btn btn-outline-danger btn-sm border-0" 
                                       onclick="return confirm('¿Quitar a este alumno de la lista?')">
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
                                    <h5 class="text-muted">No hay alumnos con datos asociados en Azure.</h5>
                                    <p class="small text-muted">Asegúrese de que el ID del alumno existe en la tabla de Usuarios.</p>
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