<?php
echo "<pre>";
print_r($grupos);
echo "</pre>";




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


   
    <form action="usuarios/guardarUsuarios" id="frm_modficar_agregar_analisis" class="form-horizontal" data-parsley-validate="true" name="frm_modficar_agregar_analisis">
        <input type="hidden" name="id_usuario" id="id_usuario" class="form-control" value="<?php echo $info[0]["ID"] ?>" />
        <div>
            
            <h5>Datos del Usuario</h5>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Nombre <strong style="color: red;">*</strong></label>
                    <input type="text" name="nombre" id="nombre" class="form-control" required value="<?php echo $info[0]["NOMBRE"] ?>" />
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>Apellido <strong style="color: red;">*</strong></label>
                    <input type="text" name="apellido" id="apellido" class="form-control" required value="<?php echo $info[0]["APELLIDOS"] ?>" />
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>Correo <strong style="color: red;">*</strong></label>
                    <input type="email" name="email" id="email" class="form-control" required value="<?php echo $info[0]["ID_PACIENTE_FACTURACION"] ?>"  />
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>Confirmar Correo <strong style="color: red;">*</strong></label>
                    <input type="email" name="conf_email" id="conf_email" class="form-control" required value="<?php echo $info[0]["ID_PACIENTE_FACTURACION"] ?>" data-parsley-equalto="#email" />
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>Contraseña <strong style="color: red;">*</strong></label>
                    <input type="password" name="pass" id="pass" class="form-control" required value="<?php echo $info[0]["ID_PACIENTE_FACTURACION"] ?>"  />
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>Confirmar contraseña <strong style="color: red;">*</strong></label>
                    <input type="password" name="conf_pass" id="conf_pass" class="form-control" required value="<?php echo $info[0]["ID_PACIENTE_FACTURACION"] ?>" data-parsley-equalto="#pass" />
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>Cedula <strong style="color: red;">*</strong></label>
                    <input type="text" name="cedula" id="cedula" class="form-control" required value="<?php echo $info[0]["ID_PACIENTE_FACTURACION"] ?>" />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Rol <strong style="color: red;">*</strong></label>
                    <select name="grupo" id="grupo" data-parsley-noselectseleccion class="form-control">
                        <option value="0">Genero</option>
                        <?php foreach($grupos as $value){ ?>
                            <option value="<?php echo $value["id"] ?>"><?php echo $value["name"] ?></option>
                        <?php } ?>
                    </select>
                </div>

            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Genero <strong style="color: red;">*</strong></label>
                    <select name="genero" id="genero" data-parsley-noselectseleccion class="form-control">
                        <option value="0">Genero</option>
                        <option value="M" <?php echo ($info[0]["GENERO"] == "M") ? "selected" : ""; ?>>Masculino</option>
                        <option value="F" <?php echo ($info[0]["GENERO"] == "F") ? "selected" : ""; ?>>Femenino</option>
                    </select>
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

    $("#cedula").change(function(){
        $(this).val($(this).val());
    })
</script>