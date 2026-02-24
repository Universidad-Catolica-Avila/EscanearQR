<?php
    use Mgj\ProyectoBlog2025\Config\Parameters;
    
    $baseUrl = Parameters::getBaseUrl();
    // Obtenemos el ID de la charla de la URL para pasárselo al JS
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
    /* Estilos para los botones generados por la librería QR */
    #reader__dashboard_section_csr button {
        background-color: #212529 !important;
        color: white !important;
        border: none !important;
        padding: 8px 15px !important;
        border-radius: 5px !important;
        margin-top: 10px !important;
        cursor: pointer;
    }
    #reader__dashboard_section_csr button:hover {
        background-color: #444 !important;
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
                            <span class="h5 text-primary">
                                <?= htmlspecialchars($charla->Titulo ?? $charla->titulo ?? 'Cargando charla...') ?>
                            </span>
                        </div>

                        <div id="camera-wrapper" class="mx-auto shadow-sm" style="max-width: 500px; border-radius: 10px; overflow: hidden; background: #000;">
                            <div id="reader"></div>
                        </div>
                        
                        <div id="status-msg" class="mt-3 alert" style="display: none;"></div>
                    </div>

                    <div class="card-footer bg-white border-0 pb-4 text-center">
                        <a href="<?= $baseUrl ?>index.php?controller=Charla&action=getAll" class="btn btn-outline-danger px-4 shadow-sm">
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
        // Estas variables las usa tu script lectorQR.js
        const baseUrl = "<?= $baseUrl ?>";
        const idCharla = "<?= $id_charla ?>";

        function startScanner() {
            // Verificamos si la función está disponible (evita errores si el JS externo tarda en cargar)
            if (typeof inicializarLector === 'function') {
                console.log("Iniciando escáner para charla ID: " + idCharla);
                inicializarLector(baseUrl, idCharla);
            } else {
                setTimeout(startScanner, 300);
            }
        }

        startScanner();
    });
</script>

<?php require_once 'Views/layout/footer.php'; ?>