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
    <h4 class="modal-title"><?php echo ($info[0]["ID_USUARIO"]) ? "Modificar Usuario" : "Agregar Usuario"; ?></h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">

    <!--

    Array
(
    [0] => Array
        (
            [ID_USUARIO] => 6
            [NOMBRE_USUARIO] => eliza guzman
            [CORREO_USUARIO] => eliza@gmail.com
            [CELULAR] => 8094186426
            [CEDULA] => 00119194306
            [GENERO] => M
            [group_id] => 3
            [ID_ORGANIZACION] => 2
            [ACTIVO] => 0
            [ROL] => CEO
            [LABORATORIO] => Array
                (
                    [ID_ORGANIZACION] => 2
                    [NOMBRE_ORGANIZACION] => preuba
                )

        )

 -->
    <form action="usuarios/guardarUsuarios" id="frm_modficar_agregar_analisis" class="form-horizontal" data-parsley-validate="true" name="frm_modficar_agregar_analisis">
        <input type="hidden" name="id_usuario" id="id_usuario" class="form-control" value="<?php echo $info[0]["ID_USUARIO"] ?>" />
        <div>

            <h5>Datos del Usuario</h5>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Nombre <strong style="color: red;">*</strong></label>
                    <input type="text" name="nombre" id="nombre" class="form-control" required value="<?php echo $info[0]["NOMBRE_USUARIO"] ?>" />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Apellido <strong style="color: red;">*</strong></label>
                    <input type="text" name="apellido" id="apellido" class="form-control" required value="<?php echo $info[0]["APELLIDOS_USUARIO"] ?>" />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Correo <strong style="color: red;">*</strong></label>
                    <input type="email" name="email" id="email" class="form-control" required value="<?php echo $info[0]["CORREO_USUARIO"] ?>" />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Cedula <strong style="color: red;">*</strong></label>
                    <input type="text" name="cedula" id="cedula" class="form-control" required value="<?php echo $info[0]["CEDULA"] ?>" />
                </div>
            </div>
            <?php if (!$info[0]["ID_USUARIO"]) {  ?>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Contraseña <strong style="color: red;">*</strong></label>
                        <input type="password" name="pass" id="pass" class="form-control" required value="" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Confirmar contraseña <strong style="color: red;">*</strong></label>
                        <input type="password" name="conf_pass" id="conf_pass" class="form-control" required value="" data-parsley-equalto="#pass" />
                    </div>
                </div>

            <?php } ?>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Genero <strong style="color: red;">*</strong></label>
                    <select name="genero" id="genero" data-parsley-noselectseleccion class="form-control">
                        <option value="0">selecionar Genero</option>
                        <option value="M" <?php echo ($info[0]["GENERO"] == "M") ? "selected" : ""; ?>>Masculino</option>
                        <option value="F" <?php echo ($info[0]["GENERO"] == "F") ? "selected" : ""; ?>>Femenino</option>
                    </select>
                </div>

            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>telefono <strong style="color: red;">*</strong></label>
                    <input type="telefono" name="telefono" id="telefono" class="form-control" required value="<?php echo $info[0]["CELULAR"] ?>" />
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>Rol <strong style="color: red;">*</strong></label>
                    <select name="grupo" id="grupo" data-parsley-noselectseleccion class="form-control">
                        <option value="0">Selecionar rol</option>
                        <?php foreach ($grupos as $value) { ?>
                            <option value="<?php echo $value["id"] ?>" <?php echo ($value["id"] == $info[0]['group_id']) ? "selected" : "" ?>><?php echo $value["name"] ?></option>
                        <?php } ?>
                    </select>
                </div>

            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label>Organizacion <strong style="color: red;">*</strong></label>
                    <input type="text" name="sucursal" id="sucursal" class="form-control sucursal" required value="<?php echo $info[0][0]["NOMBRE_ORGANIZACION"] ?>" readonly />
                    <input type="hidden" name="id_sucursal" id="id_sucursal" class="form-control sucursal" required value="<?php echo $info[0][0]["ID_ORGANIZACION"] ?>" />
                    <input type="hidden" name="idlaboratorio" id="idlaboratorio" class="form-control sucursal" required value="<?php echo $info[0][0]["ID_ORGANIZACION"] ?>" />
                </div>
            </div>


            <div class="col-md-2 ">
                <label class="col-md-3 col-sm-4 col-form-label" for="website">&nbsp;</label>
                <div class="custom-control custom-switch  mb-1">
                    <input type="checkbox" name="activo" class="custom-control-input" id="customSwitch1" <?php echo ($info[0]["ACTIVO"] == "1") ? "checked" : ""; ?> value="on">
                    <label class="custom-control-label" for="customSwitch1">Activo</label>
                </div>

            </div>
        </div>

</div>




</form>
</div>


<div class="modal-footer">
    <a href="javascript:;" class="btn btn-success" id="btn_guardar_usuario">Guardar Cambios <i class="fa fa-save"></i></a>
    <a href="javascript:;" class="btn btn-danger" data-dismiss="modal">Cancelar <i class="fa fa-times"></i></a>
</div>

<script>
    var $frm_modficar_agregar_analisis = $("#frm_modficar_agregar_analisis");

    window.Parsley.addValidator('noselectseleccion',
            function(value) {
                return value != 0
            })
        .addMessage('es', 'noselectseleccion', 'Debe seleccionar una opcion');

    //emailCheck


    /*$('#fecha').datetimepicker({
        format: "DD/MM/YYYY"
    }).on('dp.change', function(e){ 
        let edad=calculateAge($(this).find("input").val());

        if(isNaN(edad)){
            edad="Edad";
        }

        if(edad < 18){
          $("#cedula").val("Menor de edad o sin cedula")
        }

        $("#edad").html(`&nbsp;${edad}`);

        
        
    });*/

    $("#cedula").change(function() {
        $(this).val($(this).val());
    })


    $("#sucursal").dblclick(function() {
        let grupo = $("#grupo").val();



        if (grupo == 3 || grupo == 4 || grupo == 5 || grupo == 6) {
            $(".modal_tabla_sucursales .modal-content").load(
                "sucursales/getModaTablaSucursales",
                function() {
                    $(".modal_tabla_sucursales").modal({

                        show: true,
                    });
                }
            );
        }



    })

    $("#grupo").change(function() {
        $(".sucursal").val("");


        let rol = $(this).val();



        if (rol == 1 || rol == 2 || rol == 0) {
            if (rol == 1 || rol == 2) {
                $("#sucursal").val("sistema");
            }
            $(".sucursal").prop("required", false);

        } else {
            $(".sucursal").prop("required", true)
        }

    });
</script>