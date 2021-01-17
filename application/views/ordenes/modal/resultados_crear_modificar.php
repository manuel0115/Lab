<?php
/*echo "<pre>";
//print_r($formulario);
echo "$id_orden";
echo "</pre>";
die("in modal")*/
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


    <form action="ordenes/guardar_resultado" id="frm_guardar_resultado" class="form-horizontal" data-parsley-validate="true">
        <input type="hidden" id="id_orden" name="id_orden" value='<?php echo $id_orden; ?>' />
        <?php

        /*
                Array
(
    [0] => Array
        (
            [ID_ANALISIS] => 53
            [NOMBRE_ANALISIS] => HEMOGRAMA
            [NOMBRE_PARAMETRO] => Array
                (
                    [1] => 15-(WBC) GB
                    [2] => 16-LYM%
                    [3] => 17-MID%
                    [4] => 46-GRANULITOS%
                    [5] => 48-NO. LINFOCITOS
                    [6] => 47-MIXTOS
                    [7] => 49-NO. GRANULITOS
                    [8] => 50-HGB
                    [9] => 51-(RBC) GR
                    [10] => 52-HCTO
                    [11] => 53-MVC
                    [12] => 54-MCH
                    [13] => 55-MCHC
                    [14] => 56-RWD-CV
                    [15] => 57-PLT
                    [16] => 58-MPV
                    [17] => 59-PDW
                    [18] => 60-PCT
                )

        )

    [1] => Array
        (
            [ID_ANALISIS] => 3
            [NOMBRE_ANALISIS] => AMILASA
            [NOMBRE_PARAMETRO] => Array
                (
                    [1] => 11-SIN PARAMETRO
                )

        )

    [2] => Array
        (
            [ID_ANALISIS] => 8
            [NOMBRE_ANALISIS] => COLESTEROL
            [NOMBRE_PARAMETRO] => Array
                (
                    [1] => 11-SIN PARAMETRO
                )

        )

    [3] => Array
        (
            [ID_ANALISIS] => 13
            [NOMBRE_ANALISIS] => CREATININA
            [NOMBRE_PARAMETRO] => Array
                (
                    [1] => 11-SIN PARAMETRO
                )

        )

    [4] => Array
        (
            [ID_ANALISIS] => 137
            [NOMBRE_ANALISIS] => PSA LIBRE Y TOTAL
            [NOMBRE_PARAMETRO] => Array
                (
                    [1] => 43-PSA TOTAL
                    [2] => 44-PSA LIBRE
                    [3] => 45-PSA TOTAL/LIBRE
                )

        )

)
            
            */
        ?>


        <?php foreach ($formulario as $key => $value) : ?>
            <div style="padding:15px" class="padre-maestro" data-analisis="<?php echo $value["ID_ANALISIS"] ?>">
                <span style="font-size:12px;font-weight:bold"><?php echo $value["NOMBRE_ANALISIS"] ?></span>
                <div class="custom-control custom-switch mt-2 mb-2">
                    <input type="checkbox" class="custom-control-input acti_com" id="<?php echo "ac_coment_" . $value['ID_ANALISIS'] ?>">
                    <label class="custom-control-label" for="<?php echo "ac_coment_" . $value['ID_ANALISIS'] ?>"> Activar Comentarios</label>
                </div>
                <div class="agrupar-parametros">
                    <?php
                    foreach ($value["NOMBRE_PARAMETRO"] as $key_r => $value_r) {
                        $id_parametro = explode("-", $value_r);
                    ?>

                        <div class="form-group">
                            <label><?php echo $id_parametro[1]; ?></label>
                            <div class="input-group">
                                <input type="text" class="form-control valor" data-parametro="<?php echo $id_parametro[0] ?>" required data-parsley-errors-container="<?php echo "#error_" . $value["ID_ANALISIS"] . "_" . $id_parametro[0]; ?>">
                            </div>

                            <small id="<?php echo "error_" . $value["ID_ANALISIS"] . "_" . $id_parametro[0]; ?>">

                            </small>
                        </div>



                    <?php } ?>
                </div>

                <div class="form-group contenedor-comentario-parametros d-none" id="<?php echo "cj_coment_" . $value['ID_ANALISIS']; ?>">
                    <label>Observaciones</label>
                    <textarea class="form-control" rows="3" data-parsley-errors-container="<?php echo "#errorcm_" . $value["ID_ANALISIS"]; ?>"></textarea>
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