<?php
echo "<pre>";
print_r($info);
echo "</pre>";




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
    <h4 class="modal-title"><?php echo ($info[0]["ID"]) ? "Modificar analisis" : "Agregar analisis"; ?></h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">
    <form action="analisis/guardar_analisis" id="frm_modficar_agregar_analisis" class="form-horizontal" data-parsley-validate="true" name="frm_modficar_agregar_analisis">


        <div class="form-group row m-b-15">
            <label class="col-md-2 col-sm-4 col-form-label" for="website">Area <stron style="color:red"> *</stron></label>
            <div class="col-md-10 col-sm-8">
                <select style="text-transform:capitalize;" class="form-control" id="area" name="area" data-parsley-required="true">
                    <?php foreach ($areas as $value) { ?>
                        <option style="text-transform:capitalize;" value="<?php echo $value["ID"]; ?>" <?php echo ($info[0]["ID_AREA_ANALITICA"] == $value["ID"]) ? "selected" : ""; ?>><?php echo $value["NOMBRE"] ?></option>
                    <?php } ?>
                </select>

            </div>
        </div>

        <div class="form-group row m-b-15">
            <label class="col-md-2 col-sm-4 col-form-label" for="fullname">Nombre <stron style="color:red"> *</stron></label>

            <?php if($info[0]["ID"]){ ?>
                <div class="col-md-10 col-sm-10">
                    <input class="form-control" type="text" id="analisis" name="analisis" required value='<?php echo $info[0]["NOMBRE"] ?>' />
                    <input type="hidden" id="id_analisis" name="id_analisis" value='<?php echo $info[0]["ID"] ?>' />
                </div>
            <?php }else{ ?> 
                <div class="col-md-10 col-sm-10">
                    <ul id="myTags" class="primary">
                        
                    </ul>
                </div>
            <?php } ?>    
        </div>

       
            



    </form>
</div>


<div class="modal-footer">
    <a href="javascript:;" class="btn btn-success" id="btn_guardar_analisis">Guardar Cambios <i class="fa fa-save"></i></a>
    <a href="javascript:;" class="btn btn-danger" data-dismiss="modal">Cancelar <i class="fa fa-times"></i></a>
</div>

<script>
    var $frm_modficar_agregar_analisis = $("#frm_modficar_agregar_analisis");
    
    $("#myTags").tagit({
        fieldName: "analisis[]"
    });



   
</script>