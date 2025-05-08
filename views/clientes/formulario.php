<div class="formulario-admin1">

    <div class="form-column1">
        <div class="form-section1">
            <div class="campo-admin">
                <label class="campo-admin__label" for="email">
                     Email
                </label>
                <input class="campo-admin__field" type="email" id="email" name="email" value="<?php echo s($usuario->email); ?>">
            </div>
            <div class="campo-admin">
            <label for="rol" class="campo-admin__label">Categoria</label>
            <select name="rolId" id="rol" class="campo_admin__select">
                <option selected value="">--Seleccione--</option>
                <?php foreach ($roles as $rol) { ?>
                    <option
                        <?php echo $usuario->rolId === $rol->id ? 'selected' : ''; ?>
                        value="<?php echo s($rol->id) ?>">
                        <?php echo s($rol->nombre) ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        </div>
    </div>


    
    </div>
</div>