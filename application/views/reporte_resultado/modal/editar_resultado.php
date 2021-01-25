<?php
/*echo "<pre>";
print_r($datos_resultados);
echo "$id_orden";
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

    hr {
        margin-top: 1rem !important;
        margin-bottom: 1rem !important;
        border: 0 !important;
        border-top: 1px solid rgb(0, 0, 0) !important;
    }
</style>
<div class="modal-header">
    <h4 class="modal-title"><?php echo (is_array($datos_evento)) ? "Generar Resultado" : "Modificar Resultado"; ?></h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body p-0">


    <form action="reporte_resultado/editarResultado" id="frm_guardar_resultado" class="form-horizontal" data-parsley-validate="true">
        <input type="hidden" id="id_orden" name="id_orden" value='<?php echo $id_orden; ?>' />
        <?php
        
        /**
         * 
         *  [2] => Array
        (
            [NOMBRE_AREA] => QUIMICA
            [ID_ANALISIS] => 13
            [NOMBRE_ANALISIS] => CREATININA
            [PARAMETROS] => Array
                (
                    [0] => Array
                        (
                            [nombre] => 45-SIN PARAMETRO
                            [valor] => NEGATVO
                            [medida] => mq/dl
                            [referencia] => 0.6-1.3
                        )

                )

        )

    [3] => Array
        (
            [NOMBRE_AREA] => PRUEBAS ESP.
            [ID_ANALISIS] => 137
            [NOMBRE_ANALISIS] => PSA LIBRE Y TOTAL
            [PARAMETROS] => Array
                (
                    [0] => Array
                        (
                            [nombre] => 46-PSA TOTAL
                            [valor] => 30
                            [medida] => nq/dl
                            [referencia] => 0.0-4.0
                        )

                    [1] => Array
                        (
                            [nombre] => 47-PSA LIBRE
                            [valor] => 50
                            [medida] => nq/ml
                            [referencia] => 0.00-1.30
                        )

                    [2] => Array
                        (
                            [nombre] => 48-PSA TOTAL/LIBRE
                            [valor] => 80
                            [medida] => nq/ml
                            [referencia] => 
                        )

                )

        )
         */
        
        
        ?>

        <?php foreach ($datos_resultados as $key => $value) : ?>
            <div style="padding:15px" class="padre-maestro" data-analisis="<?php echo $value["ID_ANALISIS"] ?>">
                <span style="font-size:12px;font-weight:bold"><?php echo $value["NOMBRE_ANALISIS"] ?></span>
                <div class="custom-control custom-switch mt-2 mb-2">
                    <input type="checkbox" class="custom-control-input acti_com" id="<?php echo "ac_coment_" . $value['ID_ANALISIS'] ?>" <?php echo ($value["COMENTARIO"])?"checked":""; ?> >
                    <label class="custom-control-label" for="<?php echo "ac_coment_" . $value['ID_ANALISIS'] ?>"> Activar Comentarios</label>
                </div>
                <div class="agrupar-parametros">
                    <?php
                    foreach ($value["PARAMETROS"] as $key_r => $value_r) {
                        $id_parametro = explode("-", $value_r["nombre"]);
                    ?>

                        <div class="form-group">
                            <label><?php echo $id_parametro[1]; ?></label>
                            <div class="input-group">
                                <input type="text" class="form-control valor" data-parametro="<?php echo $id_parametro[0] ?>" required data-parsley-errors-container="<?php echo "#error_" . $value["ID_ANALISIS"] . "_" . $id_parametro[0]; ?>" value="<?php echo $value_r["valor"]; ?>">
                            </div>

                            <small id="<?php echo "error_" . $value["ID_ANALISIS"] . "_" . $id_parametro[0]; ?>">

                            </small>
                        </div>



                    <?php } ?>
                </div>

                <div class="form-group contenedor-comentario-parametros <?php echo (!$value["COMENTARIO"])?"d-none":""; ?>" id="<?php echo "cj_coment_" . $value['ID_ANALISIS']; ?>">
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
    <a href="javascript:;" class="btn btn-success" id="btn_editar_resultado">Guardar Cambios <i class="fa fa-save"></i></a>
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



    });
</script>