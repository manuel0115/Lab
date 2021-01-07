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
</style>
<div class="modal-header">
    <h4 class="modal-title"><?php echo (is_array($datos_evento)) ? "Generar Resultado" : "Modificar Resultado"; ?></h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">


    <form action="ordenes/guardar_resultado" id="frm_guardar_resultado" class="form-horizontal" data-parsley-validate="true">
        <input type="hidden" id="id_orden" name="id_orden" value='<?php echo $id_orden; ?>' />


        <fieldset>

            <?php foreach ($formulario as $key => $value) :

                if ($value["PARAMETROS"] == 0) {
                    $id_parametro=explode("-",$value['NOMBRE_PARAMETRO'][0]);
                    $key=1+(int)$key
            ?>


                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label"><?php echo $value["NOMBRE_ANALISIS"]?></label>

                        <div class="col-sm-8 contenedor-checkbox">
                            <div class="switcher switcher-success ">
                                <input type="checkbox" name="<?php echo "switcher_checkbox_".$key; ?>" id="<?php echo "switcher_checkbox_".$key; ?>" checked="" value="1" class="positivo">
                              
                                <label for="<?php echo "switcher_checkbox_".$key; ?>"></label>
                            </div>
                            <input type="hidden" class="parametros_valores" data-parameretros="false"  checked="" value="<?php echo $value['ID_ANALISIS'].'_'.$id_parametro[0] ?>">
                        </div>
                        <div class="col-sm-12 mt-2 contenedor-comentario">
                            <h6>Comentario</h6>
                            <textarea class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="form-group row">
                        <h3 for="inputEmail3" class="col-sm-12 col-form-label"><?php echo $value["NOMBRE_ANALISIS"]?></h3>
                    </div>

                    <?php 
                        foreach ($value["NOMBRE_PARAMETRO"] as $key_r => $value_r) {  
                            $id_parametro=explode("-",$value_r);
                    ?>
                       
                        <div class="form-group row contenedor-parametro" data-id-parametro="<?php echo $id_parametro[0] ;?>">
                            <label  for="inputEmail3" class="col-sm-2 col-form-label"><?php echo $id_parametro[1] ?></label>

                            <div class="col-md-2 valor">
                                <input type="text" class="form-control parametro"  placeholder="valor"  required  />
                            </div>
                            <div class="col-md-4 medida">
                                <!--<select class="form-control">
                            <option value="0">una medida</option>
                        </select>-->
                                <input type="text" class="form-control parametro"  placeholder="medida" value="" required  />
                            </div>

                            <div class="col-md-4 referencia">
                                <input type="text" class="form-control parametro"  placeholder="Valor de referencia" value="" required />
                            </div>
                            
                            

                        </div>
                    <?php } ?>
                    <div class="form-group row">
                    <input type="hidden" class="parametros_valores" data-pararmetros="true" placeholder="Valor de referencia" value="<?php echo $value['ID_ANALISIS']; ?> "/>
                        <div class="col-sm-12 mt-2 contenedor-comentario-parametros">
                            <h6>Comentario</h6>
                            <textarea class="form-control" rows="3"></textarea>
                        </div>
                    </div>


                <?php } ?>
            <?php endforeach ?>

           


        </fieldset>




    </form>
</div>


<div class="modal-footer">
    <a href="javascript:;" class="btn btn-success" id="btn_guardar_resultado">Guardar Cambios <i class="fa fa-save"></i></a>
    <a href="javascript:;" class="btn btn-danger" data-dismiss="modal">Cancelar <i class="fa fa-times"></i></a>
</div>

<script>
    var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));

    elems.forEach(function(html) {
        var switchery = new Switchery(html);
    });

    var $frm_guardar_resultado = $("#frm_guardar_resultado");


    /* window.Parsley.addValidator("cierre-Evento", {
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
*/




    $(".add_areas").click(function(e) {
        let area = $(this).parent().siblings().children("#area").val();





    })


    //console.log(moment().format('MMMM Do YYYY, h:mm:ss a'));
</script>