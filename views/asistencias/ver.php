<?php use Mgj\ProyectoBlog2025\Config\Parameters; ?>
<?php require_once 'Views/layout/header.php'; ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Listado de Asistentes</h2>
        <a href="<?= Parameters::$BASE_URL ?>Charla/index" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <table class="table table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID Alumno</th>
                        <th>Nombre Completo</th>
                        <th>Email</th>
                        <th>Hora de Registro</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($asistentes)): ?>
                        <?php foreach($asistentes as $asistente): ?>
                            <tr>
                                <td><?= $asistente->ID ?></td>
                                <td><?= $asistente->Nombre . " " . $asistente->Apellidos ?></td>
                                <td><?= $asistente->Email ?></td>
                                <td><?= date('d/m/Y H:i:s', strtotime($asistente->Fecha_Registro)) ?></td>
                                <td class="text-center">
                                    <a href="<?= Parameters::$BASE_URL ?>Asistencia/eliminarRegistro&id_asistencia=<?= $asistente->ID_Asistencia ?>&id_charla=<?= $id_charla ?>" 
                                       class="btn btn-danger btn-sm" 
                                       onclick="return confirm('¿Eliminar este registro de asistencia?')">
                                        <i class="fas fa-user-minus"></i> Quitar
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted p-4">Aún no hay alumnos registrados en esta charla.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once 'Views/layout/footer.php'; ?>