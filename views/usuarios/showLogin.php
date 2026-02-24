<?php
    use Mgj\ProyectoBlog2025\Config\Parameters;
?>

<main class="main-content">
    <section>        
        <div class="form-container">
            <h2 class="text-center">Iniciar Sesión</h2>
            
            <form action="<?= Parameters::getBaseUrl() . "Usuario/login" ?>" method="POST" class="mt-4">
                
                <div class="form-group mb-3">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="ejemplo@ucav.es" required>
                </div>
                
                <div class="form-group mb-4">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>

                <?php
                    if (isset($_SESSION['statusLastAction'])) {
                        $status = $_SESSION['statusLastAction'];
                        if ($status['tipo'] == 'error') {
                            echo "<div class='alert alert-danger p-2 text-center' style='font-size: 0.9rem;'>";
                            echo "<strong>⚠️ </strong> " . $status['mensaje'];
                            echo "</div>";
                        }
                        unset($_SESSION['statusLastAction']);
                    }
                ?>

                <div class="d-grid gap-2">
                    <button type="submit" name="btnLogin" class="btn btn-primary btn-block">
                        <i class="fas fa-sign-in-alt me-1"></i> Entrar
                    </button>
                </div>
            </form>

            <p class="text-center mt-4" style="font-size: 0.85rem;">
                ¿No tienes cuenta? 
                <a href="<?= Parameters::getBaseUrl() . "Usuario/showRegister" ?>" class="text-decoration-none">
                    Regístrate aquí
                </a>
            </p>
        </div>
    </section>
</main>