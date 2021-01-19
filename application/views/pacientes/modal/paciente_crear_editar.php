<?php
/*=echo "<pre>";
print_r($coberturas);
echo "</pre>";
*/



?>
<style>
    .ui-autocomplete {
        z-index: 2147483647;
    }

    input[readonly] {
        background-color: #fff !important;
    }

    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }
</style>
<div class="modal-header">
    <h4 class="modal-title"><?php echo ($info[0]["ID"]) ? "Modificar paciente" : "Agregar paciente"; ?></h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">

<?php 
/*
[ID] => 2
[NOMBRE] => santiago
[APELLIDOS] => guzman
[ID_PACIENTE_FACTURACION] => 2525
[FECHA_NACIMIENTO] => 1958-05-25
[CEDULA] => 00103444345
[GENERO] => M
[REFERIDO_POR] => 1
[COBERTURA] => 1
[MEDICO] => eliza guzman
*/
?>
    <form action="pacientes/guardar_pacientes" id="frm_modficar_agregar_analisis" class="form-horizontal" data-parsley-validate="true" name="frm_modficar_agregar_analisis">
        <input type="hidden" name="id_paciente" id="id_paciente" class="form-control" value="<?php echo $info[0]["ID"]?>" />
        <h5>Datos del Paciente</h5>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Nombre <strong style="color: red;">*</strong></label>
                    <input type="text" name="nombre" id="nombre" class="form-control" required value="<?php echo $info[0]["NOMBRE"]?>" />
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <label>Apellido <strong style="color: red;">*</strong></label>
                    <input type="text" name="apellido" id="apellido" class="form-control" required value="<?php echo $info[0]["APELLIDOS"]?>"/>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Id facturacion <strong style="color: red;">*</strong></label>
                    <input type="number" name="id_facturacion" id="id_facturacion" class="form-control" required value="<?php echo $info[0]["ID_PACIENTE_FACTURACION"]?>" />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Fecha de nacimiento <strong style="color: red;">*</strong></label>
                    <input type="date" name="fecha" id="fecha" class="form-control" required value="<?php echo $info[0]["FECHA_NACIMIENTO"]?>" />
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <label>Cedula <strong style="color: red;">*</strong></label>
                    <input type="number" maxlength="11" minlength="11" name="cedula" id="cedula" class="form-control" required value="<?php echo $info[0]["CEDULA"]?>" />
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Genero <strong style="color: red;">*</strong></label>
                    <select name="genero" id="genero" data-parsley-noselectseleccion class="form-control">
                        <option value="0">Genero</option>
                        <option value="M" <?php echo ($info[0]["GENERO"]== "M")?"selected":"";?>>Masculino</option>
                        <option value="F" <?php echo ($info[0]["GENERO"]== "F")?"selected":"";?>>Femenino</option>
                    </select>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Referido por<strong style="color: red;">*</strong></label>
                    <select name="referencia" data-parsley-noselectseleccion id="referencia" class="form-control">
                        <option value="0">Referido por</option>
                        <?php foreach ($referencias as $value) { ?>
                            <option value="<?php echo $value["ID"] ?>" <?php echo ($info[0]["REFERIDO_POR"]== $value["ID"])?"selected":"";?> ><?php echo $value["NOMBRE"]?></option>

                        <?php } ?>

                        
                    </select>
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <label>Cobertura <strong style="color: red;">*</strong></label>
                    <select name="cobertura" data-parsley-noselectseleccion id="cobertura" class="form-control">
                        <option value="0">Elegir cobertura</option>
                        <?php foreach ($coberturas as $value) { ?>
                            <option value="<?php echo $value["ID"] ?>" <?php echo ($info[0]["COBERTURA"]== $value["ID"])?"selected":"";?> ><?php echo $value["NOMBRE"]?></option>

                        <?php } ?>

                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Medico <strong style="color: red;">*</strong></label>
                    <input type="text"  name="medico" id="medico" class="form-control" value="<?php echo $info[0]["MEDICO"]?>"  />
                </div>

            </div>
        </div>



    </form>
</div>


<div class="modal-footer">
    <a href="javascript:;" class="btn btn-success" id="btn_guardar_paciente">Guardar Cambios <i class="fa fa-save"></i></a>
    <a href="javascript:;" class="btn btn-danger" data-dismiss="modal">Cancelar <i class="fa fa-times"></i></a>
</div>

<script>
    var $frm_modficar_agregar_analisis = $("#frm_modficar_agregar_analisis");

    window.Parsley.addValidator('noselectseleccion',
            function(value) {
                return value != 0
            })
        .addMessage('es', 'noselectseleccion', 'Debe seleccionar una opcion');
</script>