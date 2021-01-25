
<style>
    .ui-autocomplete {
        z-index: 2147483647;
    }

    input[readonly] {
        background-color: #fff !important;
    }
</style>
<div class="modal-header">
    <h4 class="modal-title"><?php echo ($area[0]["ID"]) ? "Modificar area analitica" : "Agregar area analitica"; ?></h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">
    <form action="area_analitica/guardar_area_analitica" id="frm_modficar_area" class="form-horizontal" data-parsley-validate="true">


        <div class="form-group row m-b-15">
            <label class="col-md-2 col-sm-4 col-form-label" for="fullname">Nombre <stron style="color:red"> *</stron></label>

            <?php if($area[0]["ID"]){ ?>
                <div class="col-md-10 col-sm-10">
                    <input class="form-control" type="text" id="area" name="area" required value="<?php echo $area[0]["NOMBRE"] ?>" />
                    <input type="hidden" id="id_area" name="id_area" value='<?php echo $area[0]["ID"] ?>' />
                </div>
            <?php }else{ ?>    
                <div class="col-md-10 col-sm-10">
                    <ul id="myTags" class="primary">
                        
                    </ul>
                </div>
            <?php } ?>    
            



        </div>
        



        </div>
    </form>
</div>


<div class="modal-footer">
    <a href="javascript:;" class="btn btn-success" id="btn_guardar_area">Guardar Cambios <i class="fa fa-save"></i></a>
    <a href="javascript:;" class="btn btn-danger" data-dismiss="modal">Cancelar <i class="fa fa-times"></i></a>
</div>

<script>
    var $frm_modficar_area = $("#frm_modficar_area");

    $("#myTags").tagit({
        fieldName: "area[]"
    });
</script>