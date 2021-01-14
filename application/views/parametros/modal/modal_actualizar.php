<?php
/*echo "<pre>";
print_r($info);
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
    <h4 class="modal-title"><?php echo ($info[0]["ID"]) ? "Modificar evento" : "Agregar evento"; ?></h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">
    <form action="parametros/actualizarParametros" id="frm_modficar_agregar_evento" class="form-horizontal" data-parsley-validate="true">
        <input type="hidden" id="id" name="id" value='<?php echo $info[0]["ID"] ?>' />

        <!-- <div class="form-group row m-b-15">
            <label class="col-md-2 col-sm-4 col-form-label" for="fullname"> Analisis <stron style="color:red"> *</stron></label>
            <div class="col-md-10 col-sm-8">
                <input class="form-control" type="text" id="analisis" name="analisis" required="true" value="<?php echo $info[0]["ANALISIS"] ?>" />
                <input class="form-control" type="hidden" id="ID_ANALISIS" name="ID_ANALISIS" required="true" value="<?php echo $info[0]["ID_ANALISIS"] ?>" />
            </div>
        </div>-->



        <div class="form-group row m-b-15">
            <label class="col-md-2 col-sm-4 col-form-label" for="fullname">Nombre <stron style="color:red"> *</stron></label>
            <?php if ($info[0]["ID"]) { ?>
                <div class="col-md-10 col-sm-10">
                    <input class="form-control" type="text" id="parametro" name="parametro" required value="<?php echo $info[0]["NOMBRE"] ?>" />
                </div>
            <?php } else { ?>
                <div class="col-md-10 col-sm-10">
                    <ul id="myTags" class="primary">

                    </ul>
                </div>
            <?php } ?>
        </div>




    </form>
</div>


<div class="modal-footer">
    <a href="javascript:;" class="btn btn-success" id="btn_guardar">Guardar Cambios <i class="fa fa-save"></i></a>
    <a href="javascript:;" class="btn btn-danger" data-dismiss="modal">Cancelar <i class="fa fa-times"></i></a>
</div>

<script>
    /*$('#analisis').autocomplete({
        minLength: 1,
        source: "analisis/autocompletadoAnalisis",
        select: function(event, ui) {
            event.preventDefault();
            $("#analisis").val(ui.item.value);
            $("#ID_ANALISIS").val(ui.item.ID);
        }

    });*/

    $("#myTags").tagit({
        fieldName: "parametro[]"
    });




    var $frm_modficar_agregar_evento = $("#frm_modficar_agregar_evento");
</script>