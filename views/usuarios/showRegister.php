<?php
    use Mgj\ProyectoBlog2025\Config\Parameters;

?>


<main class="main-content">
    <section>        
        <?php
            $estadoRegistro = $data["estadoRegistro"]??NULL;
            
            if (!is_null($estadoRegistro)){
                if ($estadoRegistro){
                    echo "<div class='alerta alerta-exito'>
                            <strong> ✅ </strong> Tu cuenta ha sido creada correctamente. Ya puedes iniciar sesión.
                        </div>";
                }else{
                    echo "<div class='alerta alerta-error'>
                        <strong>⚠️ </strong> Error, no se ha podido registrar la cuenta, seguramente el correo electrónico introducido ya está registrado en el sistema.
                    </div>";
                }
                
            }


            

    


        ?>
        <div class="form-container">
            <h2>Únete a la comunidad</h2>
            <form action="<?= Parameters::$BASE_URL . "Usuario/register" ?>" method="POST">
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" id="nombre" name="nombre" placeholder="Tu nombre" required>
                </div>
                
                <div class="form-group">
                    <label for="apellidos">Apellidos</label>
                    <input type="text" id="apellidos" name="apellidos" placeholder="Tus apellidos" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" id="email" name="email" placeholder="ejemplo@correo.com" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" placeholder="Mínimo 4 caracteres" required>
                </div>
                
                <button type="submit" name='btnRegister' class="boton boton-verde btn-block">Crear Cuenta</button>
            </form>
        </div>
</main>


    </section>
</main>
