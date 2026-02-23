<?php
    use Mgj\ProyectoBlog2025\Config\Parameters;

?>


<main class="main-content">
    <section>        


        
        <div class="form-container">
            <h2>Iniciar Sesión</h2>
            
            <form action="<?= Parameters::$BASE_URL ."Usuario/login" ?>" method="POST">
                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" required>
                </div>
            

            <?php
        
                $estadoLogin = $data["estadoLogin"]??NULL;
            
                if (!is_null($estadoLogin)){
                    if (!$estadoLogin){
                        echo "<div class='centrar'><strong>⚠️ </strong> Error, credenciales incorrectas.</div>";
                    }                
                }
        
                ?>


                <button type="submit" name="btnLogin" class="boton boton-azul btn-block">Entrar</button>
            </form>

            <p style="text-align: center; margin-top: 20px; font-size: 0.85rem;">
                ¿No tienes cuenta? <a href="<?= Parameters::$BASE_URL ."Usuario/showRegister" ?>">Regístrate aquí</a>
            </p>
        </div>

</main>


    </section>
</main>
