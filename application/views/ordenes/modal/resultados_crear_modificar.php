<?php
echo "<pre>";

print_r($formulario);
echo "</pre>";

?>
<style>
    .ui-autocomplete {
        z-index: 2147483647;
    }

    input[readonly] {
        background-color: #fff !important;
    }

    hr {
        margin-top: 1rem !important;
        margin-bottom: 1rem !important;
        border: 0 !important;
        border-top: 1px solid rgb(0, 0, 0) !important;
    }
</style>
<div class="modal-header">
    <h4 class="modal-title"><?php echo (is_array($datos_evento)) ? "Modificar Resultado" : "Crear Resultado"; ?></h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body p-0">


    <form action="ordenes/guardar_resultado" id="frm_guardar_resultado" class="form-horizontal" data-parsley-validate="true" data-id-orden="<?php echo $id_orden; ?>">
       
        <?php

        /*
            Array
(
    [0] => Array
        (
            [ID] => 35
            [ID_ANALISIS] => 53
            [NOMBRE_ANALISIS] => HEMOGRAMA
            [ID_PARAMETRO] => 15
            [VALOR] => 
            [COMENTARIO] => 
            [PARAMETROS] => 1-15-(WBC) GB-NO TIENE VALOR,2-16-LYM%-NO TIENE VALOR,3-17-MID%-NO TIENE VALOR,4-46-GRANULITOS%-NO TIENE VALOR,5-48-NO. LINFOCITOS-NO TIENE VALOR,6-47-MIXTOS-NO TIENE VALOR,7-49-NO. GRANULITOS-NO TIENE VALOR,8-50-HGB-NO TIENE VALOR,9-51-(RBC) GR-NO TIENE VALOR,10-52-HCTO-NO TIENE VALOR,11-53-MVC-NO TIENE VALOR,12-54-MCH-NO TIENE VALOR,13-55-MCHC-NO TIENE VALOR,14-56-RWD-CV-NO TIENE VALOR
        )

    [1] => Array
        (
            [ID] => 36
            [ID_ANALISIS] => 174
            [NOMBRE_ANALISIS] => ORINA
            [ID_PARAMETRO] => 1
            [VALOR] => 
            [COMENTARIO] => 
            [PARAMETROS] => 1-1-COLOR-NO TIENE VALOR,2-4-OLOR-NO TIENE VALOR,3-3-ASPECTO-NO TIENE VALOR,4-5-P.H.-NO TIENE VALOR,5-6-DENSIDAD-NO TIENE VALOR,6-22-GLUCOSA EN ORINA-NO TIENE VALOR,7-24-PROTEINA-NO TIENE VALOR,8-27-UROBILINOGENOS-NO TIENE VALOR,9-26-BILIRRUBINA-NO TIENE VALOR,10-28-NITRITO-NO TIENE VALOR,11-23-ACETONA EN ORINA-NO TIENE VALOR,12-25-SANGRE OCULTA-NO TIENE VALOR,13-7-LEUCOCITOS.-NO TIENE VALOR,14-8-HEMATIES-NO TIENE VALOR,15-32-FIBRA-MUCOSA-NO TIENE VALOR,16-34-BACTERIAS-NO TIENE VALOR,17-33-EPITELIOS-NO TIENE VALOR,18-31-CILINDROS-NO TIENE VALOR,19-35-CRISTALES-NO TIENE VALOR,20-63-otros-NO TIENE VALOR
        )

         */
        ?>


        <?php foreach ($formulario as $key => $value) : ?>
            <div style="padding:15px" class="padre-maestro" data-analisis="<?php echo $value["ID"] ?>">
                <span style="font-size:12px;font-weight:bold"><?php echo $value["NOMBRE_ANALISIS"] ?></span>
                <div class="custom-control custom-switch mt-2 mb-2">
                    <input type="checkbox" class="custom-control-input acti_com" id="<?php echo "ac_coment_" . $value['ID_ANALISIS'] ?>">
                    <label class="custom-control-label" for="<?php echo "ac_coment_" . $value['ID_ANALISIS'] ?>"> Activar Comentarios</label>
                </div>
                <div class="agrupar-parametros">
                    <?php

                    $paremetros=explode(",",$value["PARAMETROS"]);
                    foreach ($paremetros as $key_r => $value_r) {
                        $id_parametro = explode("-", $value_r);
                    ?>

                        <div class="form-group">
                            <label><?php echo $id_parametro[2]; ?></label>
                            <div class="input-group">
                                <input type="text" class="form-control valor" data-parametro="<?php echo $id_parametro[0] ?>" required data-parsley-errors-container="<?php echo "#error_" . $value["ID_ANALISIS"] . "_" . $id_parametro[1]; ?>">
                            </div>

                            <small id="<?php echo "error_" . $value["ID_ANALISIS"] . "_" . $id_parametro[1]; ?>">

                            </small>
                        </div>



                    <?php } ?>
                </div>

                <div class="form-group contenedor-comentario-parametros d-none" id="<?php echo "cj_coment_" . $value['ID_ANALISIS']; ?>">
                    <label>Observaciones</label>
                    <textarea class="form-control" rows="3" data-parsley-errors-container="<?php echo "#errorcm_" . $value["ID_ANALISIS"]; ?>"><?php echo $value["COMENTARIO"]; ?></textarea>
                    <small id="<?php echo "errorcm_" . $value["ID_ANALISIS"]; ?>">

                    </small>
                </div>

            </div>
            <hr>
        <?php endforeach ?>










    </form>
</div>


<div class="modal-footer">
    <a href="javascript:;" class="btn btn-success" id="btn_guardar_resultado">Guardar Cambios <i class="fa fa-save"></i></a>
    <a href="javascript:;" class="btn btn-danger" data-dismiss="modal">Cancelar <i class="fa fa-times"></i></a>
</div>

<script>
    var $frm_guardar_resultado = $("#frm_guardar_resultado");


    $(".acti_com").change(function() {
        let item = $(this).parent().parent(".padre-maestro").children(".contenedor-comentario-parametros");

        item.toggleClass("d-none");

        item.children("textarea").val("");

        $(this).prop("checked", function(i, val) {
            if (val) {
                item.children("textarea").prop("required", true);
            } else {
                item.children("textarea").prop("required", false);
            }
        });



    })
</script>