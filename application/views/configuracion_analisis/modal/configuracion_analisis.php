<style>
    .ui-autocomplete {
        z-index: 2147483647;
    }

    input[readonly] {
        background-color: #fff !important;
    }
</style>
<div class="modal-header">
    <h4 class="modal-title"><?php echo ($id_configuracion_analisis) ? "Modificar configuracion" : "Agregar configuracion"; ?></h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">
    <div class="contenedor-medidas-padre d-none">
        <select name="" id="" class="form-control medida" style="
    width: 137px;
">
            <option value="0">Medida</option>
            <?php foreach ($lista_medidad as $value) { ?>}
            <option value="<?php echo $value["ID"] ?>"><?php echo $value["NOMBRE"] ?></option>
        <?php } ?>
        </select>
    </div>

    <form action="Configuracion_analisis/guardar_configuracion" id="frm_modficar_agregar_analisis" class="form-horizontal" data-parsley-validate="true" name="frm_modficar_agregar_analisis">
        <input type="hidden" id="modo" name="modo" value="<?php echo $modo ?>">

        <div class="form-group row m-b-15">
            <label class="col-md-2 col-sm-4 col-form-label" for="website">Analisis <stron style="color:red"> *</stron></label>
            <div class="col-md-10 col-sm-8">
                <input class="form-control" type="text" id="analisis" name="analisis" value="<?php echo $info[0]["NOMBRE_ANALISIS"] ?>" required />
                <input class="form-control" type="hidden" id="ID_ANALISIS" name="ID_ANALISIS" required="true" value="<?php echo $info[0]["ID_ANALISIS"] ?>" />

            </div>
        </div>

        <div class="form-group row m-b-15">
            <label class="col-md-2 col-sm-4 col-form-label" for="fullname">Parametros <stron style="color:red"> *</stron></label>
            <div class="col-md-10 col-sm-10">
                <div class="input-group">
                    <select id="parametros" data-parsley-noceroselecion class="default-select2 form-control select2" style="width:93%" data-parsley-errors-container="#selectError">
                        <option value="0">Selecionar un parametro</option>
                        <?php foreach ($lista_parametros as $value) { ?>

                            <option value="<?php echo $value["ID"]; ?>"><?php echo $value["NOMBRE"]; ?></option>



                        <?php } ?>
                    </select>
                    <div class="input-group-append">

                        <a href="javascript:;" class="btn btn-success disabled" id="btn-agregar-parametros">
                            <i class="fa fa-plus"></i>
                        </a>

                    </div>
                    <div id="selectError">

                    </div>
                </div>
            </div>



        </div>
        <div class="contenedor-parametros">


            <?php if ($modo == "E") { ?>

                <?php foreach ($info as $value) { ?>

                    <div data-id-parametro="<?php echo $value["ID_PARAMETRO"]  ?>" data-id_parametro-configuracion="<?php echo $value["CONFIGURACION_PARAMETRO"]; ?>" class="row pb-2 mb-1 mt-1 parametro-individual" style="border:1px solid #00acac;border-radius:3px ">
                        <div class="col-md-2 mt-2 pt-2">
                            <h5 class="d-inline-block mr-2"><?php echo $value["NOMBRE_PARAMETRO"] ?></h5>

                        </div>
                        <div class="col-md-3 mt-2 pl-0 contenedor-medidas">

                            <select name="" id="" class="form-control medida" style="width: 137px;">
                                <option value="">Medida</option>
                                <?php foreach ($lista_medidad as $value_m) { ?>
                                    <option value="<?php echo $value_m["ID"] ?>" <?php echo ($value_m["ID"] == $value["UNIDAD_MEDIDA"]) ? "selected" : ""; ?>><?php echo $value_m["NOMBRE"] ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-md-2 mt-2 pl-0 contenedor-medidas">
                            <input class="form-control orden_parametro" min="0" type="number" placeholder="orden" value="<?php echo $value["ORDEN_PARAMETRO"]; ?>" />
                        </div>
                        <div class="col-md-5 mt-2">
                            <button type="button" class="close float-right  eliminar-parametro" aria-hidden="true">×</button>
                        </div>
                        <div class="row hombre" style="max-width: 100%;">
                            <div class="col-md-2 mt-3 ">
                                <label class="col-md-3 col-sm-3 col-form-label" for="fullname">Masculino <stron style="color:red"></stron></label>
                            </div>
                            <div class="col-md-3 mt-3 ">
                                <input class="form-control nino" type="text" value='<?php echo $value["HOMBRE_NINO_REFERENCIA"]; ?>' placeholder="Niño" />
                            </div>
                            <div class="col-md-4 mt-3 ">
                                <input class="form-control adulto" type="text" value='<?php echo $value["HOMBRE_ADULTO_REFERENCIA"]; ?>' placeholder="Adulto" />
                            </div>
                            <div class="col-md-3 mt-3">
                                <input class="form-control anciano" type="text" value='<?php echo $value["HOMBRE_ANCIANO_REFERENCIA"]; ?>' placeholder="Anciano" />
                            </div>
                        </div>
                        <div class="row mujer" style="max-width: 100%;">
                            <div class="col-md-2 mt-3 ">
                                <label class="col-md-3 col-sm-3 col-form-label" for="fullname">Femenino <stron style="color:red"></stron></label>
                            </div>
                            <div class="col-md-3 mt-3 ">
                                <input class="form-control nino" type="text" value='<?php echo $value["MUJER_NINO_REFERENCIA"]; ?>' placeholder="Niño" />
                            </div>
                            <div class="col-md-4 mt-3 ">
                                <input class="form-control adulto" type="text" value='<?php echo $value["MUJER_ADULTO_REFERENCIA"]; ?>' placeholder="Adulto" />
                            </div>
                            <div class="col-md-3 mt-3">
                                <input class="form-control anciano" type="text" value='<?php echo $value["MUJER_ANCIANO_REFERENCIA"]; ?>' placeholder="Anciano" />
                            </div>
                        </div>
                    </div>
                <?php } ?>


            <?php } ?>
        </div>
</div>



</form>





</div>


<div class="modal-footer">
    <a href="javascript:;" class="btn btn-success" id="btn_guardar_analisis">Guardar Cambios <i class="fa fa-save"></i></a>
    <a href="javascript:;" class="btn btn-danger" data-dismiss="modal">Cancelar <i class="fa fa-times"></i></a>
</div>

<script>
    var $frm_modficar_agregar_analisis = $("#frm_modficar_agregar_analisis");

    $('#analisis').autocomplete({
        minLength: 1,
        source: "analisis/autocompletadoAnalisis",
        select: function(event, ui) {
            event.preventDefault();
            $("#analisis").val(ui.item.value);
            $("#ID_ANALISIS").val(ui.item.ID);
        }
    });






    $("#myTags").tagit({
        fieldName: "analisis[]"
    });

    $("#parametros").select2();
    $("#parametros").change(function() {
        $("#btn-agregar-parametros").removeClass('disabled');

        if ($(this).val() == 0) {

            $("#btn-agregar-parametros").addClass('disabled');
        }
    });

    window.Parsley.addValidator('noceroselecion',
            function(value) {
                return $(".contenedor-parametros").children().length != 0
            })
        .addMessage('es', 'noceroselecion', 'Debe agregar un parametro');
</script>