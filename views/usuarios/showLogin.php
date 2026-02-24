<?php
    use Mgj\ProyectoBlog2025\Config\Parameters;
    // Obtenemos la URL base (que ya detecta si es Azure o Local)
    $baseUrl = Parameters::getBaseUrl();
?>

<main class="main-content">
    <section class="container py-5">        
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="form-container p-4 shadow-lg rounded bg-white border">
                    <h2 class="text-center mb-4 fw-bold text-primary">Iniciar Sesión</h2>
                    
                    <form action="<?= $baseUrl ?>index.php?controller=Usuario&action=login" method="POST" class="mt-2">
                        
                        <div class="form-group mb-3">
                            <label for="email" class="form-label fw-bold">Correo Electrónico</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope text-muted"></i></span>
                                <input type="email" id="email" name="email" class="form-control" placeholder="ejemplo@ucav.es" required>
                            </div>
                        </div>
                        
                        <div class="form-group mb-4">
                            <label for="password" class="form-label fw-bold">Contraseña</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock text-muted"></i></span>
                                <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required>
                            </div>
                        </div>

                        <?php
                            // Manejo de mensajes de error de sesión
                            if (isset($_SESSION['statusLastAction'])) {
                                $status = $_SESSION['statusLastAction'];
                                if ($status['tipo'] == 'error') {
                                    echo "<div class='alert alert-danger py-2 px-3 text-center mb-3' style='font-size: 0.85rem;'>";
                                    echo "<i class='fas fa-exclamation-triangle me-2'></i>" . htmlspecialchars($status['mensaje']);
                                    echo "</div>";
                                }
                                unset($_SESSION['statusLastAction']);
                            }
                        ?>

                        <div class="d-grid gap-2">
                            <button type="submit" name="btnLogin" class="btn btn-primary btn-lg shadow-sm">
                                <i class="fas fa-sign-in-alt me-2"></i>Entrar al Sistema
                            </button>
                        </div>
                    </form>

                    <hr class="my-4 opacity-25">

                    <p class="text-center mb-0" style="font-size: 0.9rem;">
                        ¿No tienes cuenta? 
                        <a href="<?= $baseUrl ?>index.php?controller=Usuario&action=showRegister" class="text-decoration-none fw-bold">
                            Regístrate aquí
                        </a>
                    </p>
                </div>
                
                <div class="text-center mt-4">
                    <small class="text-muted">© 2026 Universidad Católica de Ávila</small>
                </div>
            </div>
        </div>
    </section>
</main>