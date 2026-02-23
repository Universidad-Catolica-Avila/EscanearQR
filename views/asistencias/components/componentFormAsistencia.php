<?php
    use Mgj\ProyectoBlog2025\Config\Parameters;
   
    $c = $data["registro"] ?? $data["conv"] ?? null;
    $readonly = ($modo == 'eliminar') ? 'readonly' : '';
?>

<div class="form-container-wide">
    <form action="<?= $formAction ?>" method="POST" class="entry-form">
        <div class="form-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
            
            <div class="form-group">
                <label>Código de Ingreso (CodIng)</label>
                <input type="text" name="codIng" value="<?= $c->CodIng ?? '' ?>" 
                       required <?= ($modo != 'crear') ? 'readonly' : '' ?> 
                       placeholder="Ej: ING-001">
            </div>

            <div class="form-group">
                <label>Código de Materia (CodMat)</label>
                <input type="text" name="codMat" value="<?= $c->CodMat ?? '' ?>" 
                       <?= $readonly ?> required 
                       placeholder="Ej: MAT-2025">
            </div>

            <div class="form-group" style="grid-column: span 2;">
                <label>Información Adicional (Campo1)</label>
                <input type="text" name="campo1" value="<?= $c->Campo1 ?? '' ?>" 
                       <?= $readonly ?> 
                       placeholder="Observaciones de la convalidación...">
            </div>

        </div>

        <div class="form-actions" style="margin-top: 20px;">
            <?php if ($modo == 'eliminar'): ?>
                <input type="hidden" name="id" value="<?= $c->CodIng ?>">
                <button type="submit" name="btnEliminar" class="boton" style="background-color: #d9534f; color: white;">
                    Confirmar Eliminación
                </button>
            <?php else: ?>
                <button type="submit" name="btnCrear" class="boton boton-verde">
                    <?= ($modo == 'crear') ? 'Registrar Convalidación' : 'Guardar Cambios' ?>
                </button>
            <?php endif; ?>
            
            <a href="<?= Parameters::$BASE_URL ?>ConvTitu/getAll" class="boton">Volver al Listado</a>
        </div>
    </form>
</div>