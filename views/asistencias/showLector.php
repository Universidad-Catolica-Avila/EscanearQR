<?php
    use Mgj\ProyectoBlog2025\Config\Parameters;
    $id_charla = $_GET['id'] ?? 0;
?>

<?php require_once 'Views/layout/header.php'; ?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="main-container"> <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                
                <div class="card shadow border-0" style="border-radius: 15px; overflow: hidden;">
                    <div class="card-header bg-dark text-white text-center py-3">
                        <h5 class="mb-0">LECTOR QR DE ASISTENCIA</h5>
                    </div>
                    
                    <div class="card-body p-4 text-center">
                        <div class="mb-4 p-3 bg-light rounded border shadow-sm">
                            <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.7rem;">Charla Seleccionada:</small>
                            <span class="h5 text-primary"><?= htmlspecialchars($charla->Titulo ?? $charla->titulo) ?></span>
                        </div>

                        <div id="reader" style="width: 100%; min-height: 350px; border-radius: 10px; background: #ebebeb; border: 2px dashed #ccc;">
                            <div class="pt-5 text-muted">
                                <i class="fas fa-camera fa-3x mb-3"></i><br>
                                Cargando cámara...
                            </div>
                        </div>
                        
                        <div id="status-msg" class="mt-3" style="display: none;"></div>
                    </div>

                    <div class="card-footer bg-white border-0 pb-4 text-center">
                        <a href="<?= Parameters::$BASE_URL ?>Charla/getAll" class="btn btn-outline-danger px-4">
                            <i class="fas fa-times-circle"></i> Salir del Escáner
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/html5-qrcode"></script>
<script src="<?= Parameters::$BASE_URL ?>assets/js/lectorQR.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const baseUrl = "<?= Parameters::$BASE_URL ?>";
        const idCharla = "<?= $id_charla ?>";

        if (typeof inicializarLector === 'function') {
            setTimeout(() => {
                inicializarLector(baseUrl, idCharla);
            }, 500);
        }
    });
</script>

<?php require_once 'Views/layout/footer.php'; ?>