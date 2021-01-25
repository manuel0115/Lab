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

        <?php foreach ($formulario as $key => $value) : ?>
            <div style="padding:15px" class="padre-maestro" data-analisis="<?php echo $value["ID"] ?>">
                <span style="font-size:12px;font-weight:bold"><?php echo $value["NOMBRE_ANALISIS"] ?></span>
                <div class="custom-control custom-switch mt-2 mb-2">
                    <input type="checkbox" class="custom-control-input acti_com" id="<?php echo "ac_coment_" . $value['ID_ANALISIS'] ?>" <?php echo $value["COMENTARIO"]?"checked":""  ?>>
                    <label class="custom-control-label" for="<?php echo "ac_coment_" . $value['ID_ANALISIS'] ?>"> Activar Comentarios</label>
                </div>
                <div class="agrupar-parametros">
                    <?php

                    $paremetros=explode(",",$value["PARAMETROS"]);
                    foreach ($paremetros as $key_r => $value_r) {
                        $id_parametro = explode("|", $value_r);
                        $status =  ($id_parametro[3]=="NTV")?"AGREGAR":"EDITAR";
                    ?>

                        <div class="form-group">
                            <label><?php echo ($id_parametro[2]=="SIN PARAMETRO")?"":$id_parametro[2]; ?></label>
                            <div class="input-group">
                                <input type="text" class="form-control valor" data-parametro="<?php echo $id_parametro[1] ?>"  data-parsley-errors-container="<?php echo "#error_" . $value["ID_ANALISIS"] . "_" . $id_parametro[1]; ?>" data-status="<?php echo $status; ?>" value="<?php echo ($id_parametro[3]=="NTV")?"":$id_parametro[3];  ?>">
                            </div>

                            <small id="<?php echo "error_" . $value["ID_ANALISIS"] . "_" . $id_parametro[1]; ?>">

                            </small>
                        </div>



                    <?php } ?>
                </div>

                <div class="form-group contenedor-comentario-parametros <?php echo $value["COMENTARIO"]?"":"d-none"  ?>" id="<?php echo "cj_coment_" . $value['ID_ANALISIS']; ?>">
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