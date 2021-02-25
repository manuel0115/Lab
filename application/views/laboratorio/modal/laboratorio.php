<?php
echo "<pre>";
print_r($info);
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
    <h4 class="modal-title"><?php echo ($info[0]["ID"]) ? "Modificar Laboratorio" : "Agregar Laboratorio"; ?></h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">


    <form action="laboratorio/guardar_laboratorio" id="frm_modficar_agregar_analisis" class="form-horizontal" data-parsley-validate="true" name="frm_modficar_agregar_analisis">
        <input type="hidden" name="id_laboratorio" id="id_laboratorio" class="form-control" value="<?php echo $info[0]["ID"] ?>" />
        <div>

            <h5>Datos del laboratorio</h5>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Nombre <strong style="color: red;">*</strong></label>
                    <input type="text" name="nombre" id="nombre" class="form-control" required value="<?php echo $info[0]["NOMBRE"] ?>" />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>RNC <strong style="color: red;">*</strong></label>
                    <input type="number" minlength="9" maxlength="9" name="rnc" id="rnc" class="form-control"  required value="<?php echo $info[0]["RNC"] ?>" />
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-9">
                <div class="form-group">
                    <label>Correo <strong style="color: red;">*</strong></label>
                    <input type="email" name="correo" id="correo" class="form-control" required value="<?php echo $info[0]["CORREO"] ?>" />
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="col-md-3 col-form-label pt-1">&nbsp;</label>
                    <div class="col-md-9">
                        <div class="custom-control custom-switch pt-1 mb-1">
                            <input type="checkbox" name="activo" class="custom-control-input" id="customSwitch1" <?php echo ($info[0]["ACTIVO"]=="1")?"checked":""; ?> value="on">
                            <label class="custom-control-label" for="customSwitch1">Activo</label>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="form-group row mb-0">

        </div>










    </form>
</div>


<div class="modal-footer">
    <a href="javascript:;" class="btn btn-success" id="btn_guardar_laboratorio">Guardar Cambios <i class="fa fa-save"></i></a>
    <a href="javascript:;" class="btn btn-danger" data-dismiss="modal">Cancelar <i class="fa fa-times"></i></a>
</div>

<script>
    var $frm_modficar_agregar_analisis = $("#frm_modficar_agregar_analisis");

    window.Parsley.addValidator('noselectseleccion',
            function(value) {
                return value != 0
            })
        .addMessage('es', 'noselectseleccion', 'Debe seleccionar una opcion');




    $('#fecha').datetimepicker({
        format: "DD/MM/YYYY"
    }).on('dp.change', function(e) {
        let edad = calculateAge($(this).find("input").val());

        if (isNaN(edad)) {
            edad = "Edad";
        }

        if (edad < 18) {
            $("#cedula").val("Menor de edad o sin cedula")
        }

        $("#edad").html(`&nbsp;${edad}`);



    });

    $("#cedula").change(function() {
        $(this).val($(this).val());
    })
</script>