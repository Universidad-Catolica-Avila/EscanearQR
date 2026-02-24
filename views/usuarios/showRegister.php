<?php
    use Mgj\ProyectoBlog2025\Config\Parameters;
    $baseUrl = Parameters::getBaseUrl();
    
    // El header ya abre el contenedor principal <div class="container mt-4">
    require_once 'Views/layout/header.php';
?>

<main class="main-content">
    <section class="row justify-content-center">        
        <div class="col-md-8 col-lg-6 col-xl-5">
            
            <?php
                $estadoRegistro = $data["estadoRegistro"] ?? NULL;
                
                if (!is_null($estadoRegistro)): ?>
                    <div class="mb-4">
                        <?php if ($estadoRegistro): ?>
                            <div class='alert alert-success shadow-sm border-0 d-flex align-items-center' role="alert">
                                <i class="fas fa-check-circle me-3 fa-2x"></i>
                                <div>
                                    <strong>✅ ¡Registro completado!</strong> Tu cuenta ha sido creada correctamente. Ya puedes <a href="<?= $baseUrl ?>index.php?controller=Usuario&action=showLogin" class="alert-link">iniciar sesión</a>.
                                </div>
                            </div>
                        <?php else: ?>
                            <div class='alert alert-danger shadow-sm border-0 d-flex align-items-center' role="alert">
                                <i class="fas fa-exclamation-triangle me-3 fa-2x"></i>
                                <div>
                                    <strong>⚠️ Error en el registro:</strong> No se ha podido crear la cuenta. Es muy probable que este correo electrónico ya esté registrado en el sistema.
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

            <div class="card shadow-lg border-0 mb-5" style="border-radius: 15px; overflow: hidden;">
                <div class="card-header text-center py-4" style="background-color: #003366; color: white;">
                    <h2 class="h4 mb-0 fw-bold">Únete a la comunidad</h2>
                    <small style="color: #ffcc00;">Gestión Académica de Asistencias</small>
                </div>
                
                <div class="card-body p-4 p-md-5">
                    <form action="<?= $baseUrl ?>index.php?controller=Usuario&action=register" method="POST">
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nombre" class="form-label fw-bold small text-muted">Nombre</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-user text-muted"></i></span>
                                    <input type="text" id="nombre" name="nombre" class="form-control border-start-0" placeholder="Tu nombre" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="apellidos" class="form-label fw-bold small text-muted">Apellidos</label>
                                <input type="text" id="apellidos" name="apellidos" class="form-control" placeholder="Tus apellidos" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold small text-muted">Correo Electrónico</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-envelope text-muted"></i></span>
                                <input type="email" id="email" name="email" class="form-control border-start-0" placeholder="ejemplo@correo.com" required>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="password" class="form-label fw-bold small text-muted">Contraseña</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-lock text-muted"></i></span>
                                <input type="password" id="password" name="password" class="form-control border-start-0" placeholder="Mínimo 4 caracteres" minlength="4" required>
                            </div>
                            <div class="form-text mt-1" style="font-size: 0.75rem;">Usa una contraseña segura que no utilices en otros sitios.</div>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" name='btnRegister' class="btn btn-lg fw-bold text-white shadow-sm" style="background-color: #003366;">
                                <i class="fas fa-user-plus me-2"></i>Crear Cuenta
                            </button>
                        </div>
                    </form>

                    <hr class="my-4 opacity-25">

                    <div class="text-center">
                        <p class="mb-0 small text-muted">
                            ¿Ya tienes una cuenta registrada? <br>
                            <a href="<?= $baseUrl ?>index.php?controller=Usuario&action=showLogin" class="text-decoration-none fw-bold" style="color: #003366;">
                                Inicia sesión aquí
                            </a>
                        </p>
                    </div>
                </div>
            </div>

            <div class="text-center mb-5">
                <p class="text-muted" style="font-size: 0.8rem;">© <?= date('Y') ?> Universidad Católica de Ávila</p>
            </div>
        </div>
    </section>
</main>

<?php 
    require_once 'Views/layout/footer.php'; 
?>