<?php
use Mgj\ProyectoBlog2025\Config\Parameters;

$readonly = ($modo == 'eliminar') ? 'disabled' : '';

$u = $data["usuario"] ?? null;

$rolActual = $u->Rol ?? $u->rol ?? '';
?>

<main class="main-content">
<div class="form-container-wide <?= ($modo == 'eliminar') ? 'border-rojo' : '' ?>">
    <header class="form-header">
        <h2 class="title-primary"><?= $tituloPagina ?></h2>
        <p class="subtitle">Gestión de información de usuario para la Universidad Católica de Ávila.</p>
    </header>

    <form id="mainEntryForm" action="<?= $formAction ?? '#' ?>" method="POST" class="entry-form">
        
        <input type="hidden" name="id" value="<?= $u->ID ?? $u->id ?? '' ?>">

        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" 
                   value="<?= $u->Nombre ?? $u->nombre ?? '' ?>" <?= $readonly ?>
                    required 
                    maxlength="50"
                    pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+"
                    title="El nombre debe contener solo letras">
        </div>

        <div class="form-group">
            <label for="apellidos">Apellidos</label>
            <input type="text" id="apellidos" name="apellidos" 
                   value="<?= $u->Apellidos ?? $u->apellidos ?? '' ?>" <?= $readonly ?>
                    required
                    maxlength="50"
                    pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+"
                    title="Los apellidos deben contener solo letras">
        </div>

        <div class="form-group">
            <label for="email">Email [*]</label>
            <input type="email" id="email" name="email"     
                   value="<?= $u->Email ?? $u->email ?? '' ?>"
                   readonly required 
                   style="background-color: #f4f4f4; cursor: not-allowed;">
            <p class="subtitle">[*] El email se utiliza como identificador y no se permite cambiar.</p>                   
        </div>
        
        <div class="form-group">
            <label for="password">Contraseña [**]</label>
            <input type="password" id="password" name="password" value="" <?= $readonly ?>
            minlength="8"
            maxlength="16"
            pattern="[a-zA-Z0-9]{8,16}"
            title="Entre 8 y 16 caracteres alfanuméricos"> 
            <p class="subtitle">[**] Dejar vacío si no desea modificar la contraseña actual.</p>
        </div>
        
        <div class="form-group">
            <label>Rol de Sistema:</label>
            <div class="radio-group">
                <input type="radio" id="admin" name="rol" value="admin" 
                    <?= ($rolActual == 'admin') ? 'checked' : '' ?> <?= $readonly ?>>
                <label for="admin">Administrador</label>
                
                <input type="radio" id="user" name="rol" value="user" 
                    <?= ($rolActual == 'user') ? 'checked' : '' ?> <?= $readonly ?>>
                <label for="user">Usuario Estándar</label>
            </div>
        </div>

        <div class="form-actions-row">
            <?php
                if ($modo == 'crear') {
                    echo "<button type='submit' name='btnCrear' class='boton boton-verde'>Alta Usuario</button>";
                } elseif ($modo == 'editar') {
                    echo "<button type='submit' name='btnEditar' class='boton boton-verde'>Guardar Cambios</button>";
                } elseif ($modo == 'eliminar') {
                    echo "<button type='submit' name='btnEliminar' class='boton boton-rojo'>Confirmar Eliminación</button>";
                }
            ?>            
            <a href="<?= Parameters::$BASE_URL ?>Matricula/getAll" class="boton boton-azul">Cancelar y Volver</a>
        </div>
    </form>
</div>
</main>