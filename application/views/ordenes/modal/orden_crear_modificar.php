<?php
/*
echo "<pre>";
print_r($lista_analisis);
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
</style>
<div class="modal-header">
    <h4 class="modal-title"><?php echo (is_array($datos_evento)) ? "Generar Resultado" : "Modificar Resultado"; ?></h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">


    <form action="ordenes/guardar_orden" id="frm_modficar_agregar_orden" name="frm_modficar_agregar_orden" class="form-horizontal " data-parsley-validate="true">

        <input type="hidden" name="id_orden" id="id_orden" class="form-control" placeholder="" value=" <?php echo  $datos_orden[0]['ID'] ?> ">

        <legend>Informacion de usuario</legend>
        <div class="row pl-2 pt-4">

            <div class="form-group col-sm-6 pl-0 d-inline-block">
                <label>Cedula</label>
                <input type="text" name="cedula" id="cedula" class="form-control " placeholder="Nombre el analisis" maxlength="11" minlength="11" required data-parsley-cedula="" value="<?php echo $datos_orden[0]['CEDULA'] ?>" />


            </div>

            <div class="form-group col-sm-6 pl-0 d-inline-block">
                <label>Nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-control " placeholder="Nombre el analisis" required value="<?php echo $datos_orden[0]['NOMBRE'] ?>" />

                <input type="hidden" name="id_paciente" id="id_paciente" class="form-control" placeholder="" value="<?php echo $datos_orden[0]['ID_PACIENTE']; ?>">
            </div>

        </div>
        <div class="row pl-2 pb-4 mb-1">

            <div class="form-group col-sm-12 pl-0 d-inline-block">
                <label>Referencia</label>
                <select type="text" name="referencia" id="referencia" class="form-control">

                    <?php foreach ($referencias as $key => $value) : ?>
                        <option value="<?php echo $value["ID"] ?>" <?php echo ($value["ID"] == $datos_orden[0]['REFERENCIA']) ? "selected" : ""; ?>><?php echo $value["NOMBRE"] ?></option>
                    <?php endforeach; ?>
                </select>


            </div>


        </div>
        <span><strong> Lista de analisis</strong></span>
        

        <select class="multiple-select2 form-control" id="listado_analisis" name="listado_analisis[]" multiple="multiple" required>
            <div class="form-group">


                <?php 
                 $lista_analisis_guardados=explode("|",$datos_orden[0]["LISTA_ANALISIS"]);
                foreach ($lista_analisis as $key => $value) : 
                ?>

                    <option value="<?php echo $value["ID"] ?>" <?php echo(in_array($value["ID"],$lista_analisis_guardados))?"selected":""?> ><?php echo $value["NOMBRE"] ?></option>
                <?php endforeach; ?>


        </select>
</div>
<!--<div class="form-group">
            <label>Analsis</label>
            <input type="text" name="analisis" id="analisis" class="form-control" placeholder="Nombre el analisis" />
            <input type="hidden" name="id_orden" id="id_orden" class="form-control" placeholder="" value=" <?php echo  $pacientes[0]['NUMERO_ORDEN'] ?> ">
        </div>
        <fieldset class="articulos">
            <?php foreach ($datos_orden as $key => $value) : ?>
                <div data-id="<?php echo $value['ID_ANALISIS'] ?>" class="alert alert-primary fade show item">
                    <span class="close salir">×</span>
                    <strong><?php echo $value['NOMBRE_ANALISIS'] ?></strong>
                </div>
            <?php endforeach ?>
        </fieldset>-->

</form>
</div>


<div class="modal-footer">
    <a href="javascript:;" class="btn btn-success" id="btn_guardar_orden">Guardar Cambios <i class="fa fa-save"></i></a>
    <a href="javascript:;" class="btn btn-danger" data-dismiss="modal">Cancelar <i class="fa fa-times"></i></a>
</div>

<script>
    /*$('#analisis').autocomplete({
        minLength: 1,
        source: "analisis/autocompletadoAnalisis",
        select: function(event, ui) {

            let nombre_contenerdor_parametros = `analisis_${ui.item.value}`;
            let parametros = (ui.item.parametros);
            event.preventDefault();

            $(this).val(ui.item.label);
            $(this).blur();

            let ids = getIds($(".item"));

            if (!ids.includes(ui.item.ID)) {
                let item = `<div data-id="${ui.item.ID}" class="alert alert-primary fade show item">
                            <span class="close salir" >×</span>
                            <strong> ${ui.item.label}</strong>
                        </div>`;
                $(".articulos").append(item);

            }

        }

    });*/



    var $frm_modficar_agregar_orden = $("#frm_modficar_agregar_orden");



    /*$(".articulos").on("click", ".salir", function() {
        swal("Quieres eliminar este analisis?", {
                buttons: {
                    cancel: "Cancelar",
                    catch: {
                        text: "Eliminar",
                        value: "eliminar",
                    }

                },
            })
            .then((value) => {

                if (value == "eliminar") {

                    $(this).parent().remove();
                    let elementos = getIds($(".item"));

                    if (elementos.length === 0) {
                        $('#btn_guardar_orden').addClass("disabled");
                    }

                }


            });
    });*/

    $('#analisis').change(function() {
        $('#btn_guardar_orden').removeClass("disabled");
    })



    /*$('#btn_guardar_orden').click(function() {
        console.log(getIds($(".item")));
    })*/




    window.Parsley.addValidator('cedula', {
        validateString: function(value) {

            let regex = new RegExp("^[0-9]{3}-?[0-9]{7}-?[0-9]{1}$");

            if (!regex.test(value)) {
                return falsedsd;
            }

        },
        messages: {
            es: 'Cedula no es valida',
            fr: "Cette valeur n'est pas l'inverse d'elle même."
        }
    });

    $("#cedula").change(function() {

        $("#nombre").val("");
        $("#id_paciente").val("");
        let cedula = btoa($(this).val());

        $.post(`pacientes/datosPorCedula/${cedula}`, function(data) {

            $("#nombre").val(`${data[0]["NOMBRE"]} ${data[0]["APELLIDOS"]}`);
            $("#id_paciente").val(data[0]["ID"])

        }, "json");




    });



    $('#listado_analisis').select2();
</script>