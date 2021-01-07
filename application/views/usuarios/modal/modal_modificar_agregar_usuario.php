<?php
//echo"<pre>";
//print_r($datos_usuarios);
//echo"</pre>";
?>

<div class="modal-header">
    <h4 class="modal-title"><?php echo (is_array($datos_usuarios)) ? "Modificar Usuario" : "Agregar Usuario"; ?></h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">
    <form action="usuarios/guardar_usuario" id="frm_modficar_agregar_usuario" class="form-horizontal" data-parsley-validate="true">
        <input type="hidden" id="id" name="id" value='<?php echo $datos_usuarios[0]["id"] ?>' />

        <div class="form-group row m-b-15">
            <label class="col-md-2 col-sm-4 col-form-label" for="fullname">Nombre <stron style="color:red"> *</stron></label>
            <div class="col-md-10 col-sm-10">
                <input class="form-control" type="text" id="nombre" name="nombre" required="true" value="<?php echo $datos_usuarios[0]["nombre_completo"] ?>" />
            </div>
        </div>
        <div class="form-group row m-b-15">
            <label class="col-md-2 col-sm-4 col-form-label" for="fullname">Apellido <stron style="color:red"> *</stron></label>
            <div class="col-md-10 col-sm-8">
                <input class="form-control" type="text" id="apellido" name="apellido" required="true" value="<?php echo $datos_usuarios[0]["apellido"] ?>" />
            </div>
        </div>

        <div class="form-group row m-b-15">
            <label class="col-md-2 col-sm-4 col-form-label">Genero <stron style="color:red"> *</stron></label>
            <div class="col-md-10 col-sm-8">
                <div class="radio radio-css radio-inline">
                    <input type="radio" name="genero" id="masculino" value="M" checked="" class="genero" <?php echo ($datos_usuarios[0]["genero"] == 'M') ? "checked" : "" ?>>
                    <label for="masculino">Masculino</label>
                </div>
                <div class="radio radio-css radio-inline">
                    <input type="radio" name="genero" id="femenino" value="F" class="genero" <?php echo ($datos_usuarios[0]["genero"] == 'F') ? "checked" : ""; ?>>
                    <label for="femenino">Femenino</label>
                </div>
            </div>
        </div>






        <div class="form-group row m-b-15">
            <label class="col-md-2 col-sm-4 col-form-label" for="fullname">Telefono <stron style="color:red"> *</stron></label>
            <div class="col-md-10 col-sm-8">

                <input class="form-control" type="text" id="telefono" name="telefono" required="true" value="<?php echo $datos_usuarios[0]["telefono"] ?>" />
            </div>
        </div>


        <div class="form-group row m-b-15">
            <label class="col-md-2 col-sm-4 col-form-label" for="fullname">cedula <stron style="color:red"> *</stron></label>
            <div class="col-md-10 col-sm-8">
                <input class="form-control" type="text" id="cedula" name="cedula" required="true" value="<?php echo $datos_usuarios[0]["cedula"] ?>" />
            </div>
        </div>


        <div class="form-group row m-b-15">
            <label class="col-md-2 col-sm-4 col-form-label" for="email">Correo <stron style="color:red"> *</stron></label>
            <div class="col-md-10 col-sm-8">
                <input class="form-control" type="text" id="email" name="email" data-parsley-type="email" required="true" value="<?php echo $datos_usuarios[0]["correo"] ?>" />
            </div>
        </div>
        <?php if ($datos_usuarios[0]["id"] == 0) { ?>
            <div class="form-group row m-b-15">
                <label class="col-md-2 col-sm-4 col-form-label" for="email">Contraseña <stron style="color:red"> *</stron></label>
                <div class="col-md-10 col-sm-8">
                    <input class="form-control" type="password" id="pass" name="pass" required="true" />
                </div>
            </div>
            <div class="form-group row m-b-15">
                <label class="col-md-2 col-sm-4 col-form-label" for="email"> Confirmacion Contraseña * <stron style="color:red"> *</stron></label>
                <div class="col-md-10 col-sm-8">
                    <input class="form-control" type="password" id="pass_confirmacion" name="pass_confirmacion" required="true" data-parsley-equalto="#pass" />
                </div>
            </div>
        <?php } ?>
        <div class="form-group row m-b-15">
            <label class="col-md-2 col-sm-4 col-form-label" for="email">Titulo <stron style="color:red"> *</stron></label>
            <div class="col-md-10 col-sm-8">
                <input class="form-control" type="text" id="titulo" name="titulo" required="true" value="<?php echo $datos_usuarios[0]["titulo"] ?>" />
            </div>
        </div>
        <div class="form-group row m-b-15">
            <label class="col-md-2 col-sm-4 col-form-label" for="website">Cargo <stron style="color:red"> *</stron></label>
            <div class="col-md-10 col-sm-8">
                <select class="form-control" id="estado" name="cargo" data-parsley-required="true">
                    <?php foreach ($cargos as $value) { ?>
                        <option value="<?php echo $value["id_cargo"]; ?>" <?php echo ($datos_usuarios[0]["cargo"] == $value["id_cargo"]) ? "selected" : ""; ?>><?php echo $value["nombre_cargo"] ?></option>
                    <?php } ?>
                </select>

            </div>
        </div>
        <div class="form-group row m-b-15">
            <label class="col-md-2 col-sm-4 col-form-label" for="message">Ocupacion <stron style="color:red"> *</stron></label>
            <div class="col-md-10 col-sm-8">
                <input class="form-control" type="text" id="ocupacion" name="ocupacion" required="true" value="<?php echo $datos_usuarios[0]["ocupacion"] ?>" />

            </div>
        </div>
        <div class="form-group row m-b-15">
            <label class="col-md-2 col-sm-4 col-form-label" for="message">Estado <stron style="color:red"> *</stron></label>
            <div class="col-md-10 col-sm-8">
                <select class="form-control" id="estado" name="estado" data-parsley-required="true">
                    <option value="S" <?php echo ($datos_usuarios[0]["estado"] == 'S') ? "selected" : ""; ?>>Actvio</option>
                    <option value="N" <?php echo ($datos_usuarios[0]["estado"] == 'N') ? "selected" : ""; ?>>Inactivo</option>
                </select>
            </div>
        </div>

        <!--        <div class="form-group row m-b-15">
                    <label class="col-md-4 col-sm-4 col-form-label" for="message">Ocupacion :</label>-->
        <!--            <div class="col-md-10 col-sm-8">
                        <input style="width: 100%" type="button" class=" btn btn-primary" value="subir foto" id="btn_subir_foto" />
                        <input style="display:none" type="file" class="btn btn-primary" value="" id="file_foto" name="file_foto" />
        
                    </div>-->
    </form>
</div>


<div class="modal-footer">
    <a href="javascript:;" class="btn btn-success" id="btn_guardar_cambios_agregar_usuario">Guardar Cambios <i class="fa fa-save"></i></a>
    <a href="javascript:;" class="btn btn-danger" data-dismiss="modal">Cancelar <i class="fa fa-times"></i></a>
</div>

<script>
    $.mask.definitions['h']="[8]";
    $.mask.definitions['i']="[042]";
    $.mask.definitions['j']="[9]";
    
    jQuery(function($) {
        $("#telefono").mask("(hij)999-9999");
        $("#cedula").mask("99999999999");
    });

    var $frm_modficar_agregar_usuario = $("#frm_modficar_agregar_usuario");
</script>