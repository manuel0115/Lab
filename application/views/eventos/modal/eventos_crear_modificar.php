<?php
/*echo "<pre>";
print_r($datos_evento);
echo "</pre>";*/
?>                                          
<style>
    .ui-autocomplete {
        z-index: 2147483647;
    }

    input[readonly] {
        background-color: #fff !important;
    }
</style>
<div class="modal-header">
    <h4 class="modal-title"><?php echo (is_array($datos_evento)) ? "Modificar evento" : "Agregar evento"; ?></h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">
    <form action="eventos/guardar_evento" id="frm_modficar_agregar_evento" class="form-horizontal" data-parsley-validate="true">
        <input type="hidden" id="id" name="id" value='<?php echo $datos_evento[0]["ID"] ?>' />

        <div class="form-group row m-b-15">
            <label class="col-md-2 col-sm-4 col-form-label" for="fullname">Titulo <stron style="color:red"> *</stron></label>
            <div class="col-md-10 col-sm-10">
                <input class="form-control" type="text" id="titulo" name="titulo" required value="<?php echo $datos_evento[0]["TITULO"] ?>" />
            </div>
        </div>
        <div class="form-group row m-b-15">
            <label class="col-md-2 col-sm-4 col-form-label" for="fullname">Subtitulo <stron style="color:red"> *</stron></label>
            <div class="col-md-10 col-sm-8">
                <input class="form-control" type="text" id="subtitulo" name="subtitulo" required value="<?php echo $datos_evento[0]["SUBTITULO"] ?>" />
            </div>
        </div>

        <div class="form-group row m-b-15">
            <label class="col-md-2 col-sm-4 col-form-label" for="website">Categoria <stron style="color:red"> *</stron></label>
            <div class="col-md-10 col-sm-8">
                <select style="text-transform:capitalize;" class="form-control" id="categoria" name="categoria" data-parsley-required="true">
                    <?php foreach ($categorias_eventos as $value) { ?>
                        <option style="text-transform:capitalize;" value="<?php echo $value["ID"]; ?>" <?php echo ($datos_evento[0]["CATEGORIA"] == $value["ID"]) ? "selected" : ""; ?>><?php echo $value["NOMBRE"] ?></option>
                    <?php } ?>
                </select>

            </div>
        </div>

        <div class="form-group row m-b-15">
            <label class="col-md-2 col-sm-4 col-form-label" for="fullname">Encargado <stron style="color:red"> *</stron></label>
            <div class="col-md-10 col-sm-8">
                <input class="form-control" type="text" id="encargado" name="encargado" required="true" value="<?php echo $datos_evento[0]["NOMBRE_ENCARGADO"] ?>" />
                <input class="form-control" type="hidden" id="id_encargado" name="id_encargado" required="true" value="<?php echo $datos_evento[0]["ENCARGADO"] ?>" />
            </div>
        </div>
        <div class="form-group row m-b-15">
            <label class="col-md-2 col-sm-4 col-form-label" for="fullname">Fecha del evento <stron style="color:red"> *</stron></label>
            <div class="col-md-10 col-sm-8">
                <input class="form-control" type="text" id="fecha_evento" data-date-start-date="Date.default" name="fecha_evento" readonly required="true" value="<?php echo $datos_evento[0]["FECHA_EVENTO"] ?>" />

            </div>
        </div>
        <div class="form-group row m-b-15">
            <label class="col-md-2 col-sm-4 col-form-label" for="fullname">Cierre de inscripcion <stron style="color:red"> *</stron></label>
            <div class="col-md-10 col-sm-8">
                <input class="form-control" type="text" id="fecha_limite" data-date-start-date="Date.default" data-parsley-cierre-Evento name="fecha_limite" readonly required="true" value="<?php echo $datos_evento[0]["FECHA_LIMITE"] ?>" />

            </div>
        </div>
        <div class="form-group row m-b-15">
            <label class="col-md-2 col-sm-4 col-form-label" for="fullname">Hora del evento <stron style="color:red"> *</stron></label>
            <div class="col-md-10 col-sm-8">
                <input class="form-control" type="text" id="hora" name="hora" required="true" readonly="" value="<?php echo $datos_evento[0]["HORA_INICIO"] ?>" />

            </div>
        </div>
        <div class="form-group row m-b-15">
            <label class="col-md-2 col-sm-4 col-form-label" for="fullname">Cantidad de personas<stron style="color:red"> *</stron></label>
            <div class="col-md-6 col-sm-3">
                <input class="form-control" type="number" max="1000" min="1" id="cantidad_personas" name="cantidad_personas" required="true" value="<?php echo $datos_evento[0]["CANTIDAD_PERSONAS"] ?>" />

            </div>
            <label class="col-md-2 col-sm-3 col-form-label" for="fullname">Activo<stron style="color:red"> *</stron></label>
            <div class="col-md-2 ">
                <div class="switcher switcher-success">
                    <input type="checkbox" name="activo" id="activo" <?php echo ($datos_evento[0]["ACTIVO"] == 1) ? "checked" : "" ?> value="on">
                    <label for="activo"></label>
                </div>
            </div>


            </>
        </div>

        <div class="form-group row m-b-15">
            <label class="col-md-2 col-sm-4 col-form-label" for="fullname">Descripcion<stron style="color:red"> *</stron></label>
            <div class="col-md-10 col-sm-8">
                <textarea class="form-control" name="descripcion" id="descripcion" style="max-width: 100%; min-width:100%;max-height:100px;min-height:100px;" cols="30" rows="10" data-parsley-required><?php echo $datos_evento[0]["DESCRIPCION"]; ?></textarea>

            </div>
        </div>


    </form>
</div>


<div class="modal-footer">
    <a href="javascript:;" class="btn btn-success" id="btn_guardar_cambios_agregar_eventos">Guardar Cambios <i class="fa fa-save"></i></a>
    <a href="javascript:;" class="btn btn-danger" data-dismiss="modal">Cancelar <i class="fa fa-times"></i></a>
</div>

<script>
    $('#encargado').autocomplete({
        minLength: 3,
        source: "eventos/autocompletadoUsuario",
        select: function(event, ui) {
            event.preventDefault();
            $(this).val(ui.item.label);
            $("#id_encargado").val(ui.item.value);
        }

    });

    $('#fecha_evento').datepicker({
        todayHighlight: true,
        format: 'dd/mm/yyyy'
    });

    $('#fecha_limite').datepicker({
        todayHighlight: true,
        format: 'dd/mm/yyyy'
    });

    $('#hora').timepicker();

    $.mask.definitions['h'] = "^[1-9]{1,4}$";

    /*$("#cantidad_personas").mask("h999", {
        placeholder: ""
    });*/

    var $frm_modficar_agregar_evento = $("#frm_modficar_agregar_evento");


    window.Parsley.addValidator("cierre-Evento", {
        validate: function(value) {

            var fecha_cierre = moment(value, "DD-MM-YYYY").format("YYYY-MM-DD");
            var fecha_evento = moment($("#fecha_evento").val(), "DD-MM-YYYY").format("YYYY-MM-DD");


            if (moment(fecha_cierre).isAfter(fecha_evento)) {
                return false;
            }

            return true;
        },
        messages: {
            es: 'la fecha no se puede cerrar despues del evento'

        }
    });








    //console.log(moment().format('MMMM Do YYYY, h:mm:ss a'));
</script>