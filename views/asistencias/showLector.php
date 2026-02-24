<?php
    use Mgj\ProyectoBlog2025\Config\Parameters;
    
    $baseUrl = Parameters::getBaseUrl();
    $id_charla = $_GET['id'] ?? 0;
?>

<?php require_once 'Views/layout/header.php'; ?>

<style>
    #reader {
        width: 100% !important;
        border: none !important;
    }
    #reader video {
        width: 100% !important;
        height: auto !important;
        border-radius: 10px;
        object-fit: cover;
    }
    .main-container {
        background-color: #f8f9fa;
        min-height: 80vh;
    }
    #reader__dashboard_section_csr button {
        background-color: #212529 !important;
        color: white !important;
        border: none !important;
        padding: 8px 15px !important;
        border-radius: 5px !important;
        margin-top: 10px !important;
    }
</style>

<div class="main-container"> 
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                
                <div class="card shadow-lg border-0" style="border-radius: 15px; overflow: hidden;">
                    <div class="card-header bg-dark text-white text-center py-3">
                        <h5 class="mb-0 text-uppercase tracking-wider">Lector QR Asistencia</h5>
                    </div>
                    
                    <div class="card-body p-4 text-center">
                        <div class="mb-4 p-3 bg-light rounded border shadow-sm">
                            <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.7rem;">Charla Seleccionada:</small>
                            <span class="h5 text-primary"><?= htmlspecialchars($charla->Titulo ?? $charla->titulo ?? 'Cargando charla...') ?></span>
                        </div>

                        <div id="camera-wrapper" class="mx-auto shadow-sm" style="max-width: 500px; border-radius: 10px; overflow: hidden; background: #000;">
                            <div id="reader">
                                </div>
                        </div>
                        
                        <div id="status-msg" class="mt-3 alert" style="display: none;"></div>
                    </div>

                    <div class="card-footer bg-white border-0 pb-4 text-center">
                        <a href="<?= $baseUrl ?>Charla/getAll" class="btn btn-outline-danger px-4 shadow-sm">
                            <i class="fas fa-times-circle me-2"></i>Finalizar y Salir
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/html5-qrcode"></script>
<script src="<?= $baseUrl ?>assets/js/lectorQR.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const baseUrl = "<?= $baseUrl ?>";
        const idCharla = "<?= $id_charla ?>";

        function startScanner() {
            if (typeof inicializarLector === 'function') {
                console.log("Iniciando escáner en: " + baseUrl);
                inicializarLector(baseUrl, idCharla);
            } else {
                console.log("Reintentando carga de lectorQR.js...");
                setTimeout(startScanner, 300);
            }
        }

        startScanner();
    });
</script>

<?php require_once 'Views/layout/footer.php'; ?>