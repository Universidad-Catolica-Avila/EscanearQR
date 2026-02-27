<?php 
    use Mgj\ProyectoBlog2025\Config\Parameters;
    $baseUrl = Parameters::getBaseUrl();
    require_once 'Views/layout/header.php'; 
?>

<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-md-8 offset-md-2 text-center text-md-start">
            <h2 class="fw-bold"><i class="fas fa-chalkboard-teacher text-primary me-2"></i><?= $tituloPagina ?></h2>
            <p class="text-muted">Complete los campos para gestionar la información del evento.</p>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="card-title mb-0">
                        <i class="fas <?= (isset($modo) && $modo === 'crear') ? 'fa-calendar-plus' : 'fa-edit' ?> me-2"></i>
                        Detalles de la Charla
                    </h5>
                </div>
                <div class="card-body p-4">
                    
                    <form action="<?= $formAction ?>" method="POST">
                        
                        <?php if(isset($charla) && is_object($charla)): ?>
                            <input type="hidden" name="id_charla" value="<?= $charla->ID_Charla ?? $charla->getIDCharla() ?>">
                        <?php endif; ?>

                        <div class="mb-4">
                            <label for="titulo" class="form-label fw-bold">Título de la Charla / Evento</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-heading"></i></span>
                                <input type="text" 
                                       name="titulo" 
                                       id="titulo" 
                                       class="form-control" 
                                       placeholder="Ej: Taller de PHP MVC" 
                                       value="<?= isset($charla) ? ($charla->Titulo ?? $charla->getTitulo()) : '' ?>"
                                       required>
                            </div>
                            <div class="form-text">Este nombre se mostrará en los listados de asistencia y Excel.</div>
                        </div>

                        <div class="mb-4">
                            <label for="lugar" class="form-label fw-bold">Lugar o Ubicación</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-map-marker-alt"></i></span>
                                <input type="text" 
                                       name="lugar" 
                                       id="lugar" 
                                       class="form-control" 
                                       placeholder="Ej: Aula Magna, Salón de Grados o Virtual"
                                       value="<?= isset($charla) ? ($charla->Lugar ?? $charla->getLugar()) : '' ?>"
                                       required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="fecha" class="form-label fw-bold">Fecha y Hora del Evento</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-clock"></i></span>
                                <input type="datetime-local" 
                                       name="fecha" 
                                       id="fecha" 
                                       class="form-control" 
                                       value="<?= isset($charla) ? date('Y-m-d\TH:i', strtotime($charla->Fecha_Charla ?? $charla->getFechaCharla())) : '' ?>"
                                       required>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-center gap-3 mb-3">
                            <a href="<?= $baseUrl ?>index.php?controller=Charla&action=getAll" class="btn btn-outline-secondary px-4">
                                <i class="fas fa-times me-1"></i> Cancelar
                            </a>

                            <button type="submit" class="btn btn-primary px-5 shadow">
                                <i class="fas fa-save me-1"></i> 
                                <?= (isset($modo) && $modo === 'crear') ? "Registrar Charla" : "Guardar Cambios" ?>
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'Views/layout/footer.php'; ?>