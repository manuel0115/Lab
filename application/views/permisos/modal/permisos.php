
<style>
    .ui-autocomplete {
        z-index: 2147483647;
    }

    input[readonly] {
        background-color: #fff !important;
    }
</style>
<div class="modal-header">
    <h4 class="modal-title"><?php echo ($info[0]["ID"]) ? "Modificar permisos" : "Agregar permisos"; ?></h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">
    <form action="permisos/guardar_permiso" id="frm_modficar_agregar_analisis" class="form-horizontal" data-parsley-validate="true" name="frm_modficar_agregar_analisis">

        <input type="hidden" name="id_permisos" name="id_permisos" value="<?php echo $info[0]["ID"]; ?>">
        <!--<div class="form-group row m-b-15">
            <label class="col-md-2 col-sm-4 col-form-label" for="website">Menu <stron style="color:red"> *</stron></label>
            <div class="col-md-10 col-sm-8">
                <select style="text-transform:capitalize;" class="form-control" id="menu" name="menu" data-parsley-required="true" data-parsley-noselectseleccion <?php echo ($info[0]["ID"] > 0) ? "disabled" : ""; ?>>
                    <option value="0">Selecione un menu</option>

                    <?php foreach ($menus as $value) { ?>
                        <option style="text-transform:capitalize;" value="<?php echo $value["ID"]; ?>" <?php echo ($info[0]["MENU"] == $value["ID"]) ? "selected" : ""; ?>><?php echo $value["NOMBRE"] ?></option>
                    <?php } ?>
                </select>

            </div>
        </div>-->

        <div class="form-group row m-b-15">
            <label class="col-md-2 col-sm-4 col-form-label" for="website">Roles <stron style="color:red"> *</stron></label>
            <div class="col-md-10 col-sm-8">
                <select style="text-transform:capitalize;" class="form-control" id="roles" name="roles" data-parsley-required="true" data-parsley-noselectseleccion <?php echo ($info[0]["ID"] > 0) ? "readonly" : ""; ?>>

                    <?php foreach ($roles as $value) { ?>


                        <option style="text-transform:capitalize;" value="<?php echo $value["id"]; ?>" <?php echo ($info[0]["ROL"] == $value["id"]) ? "selected" : ""; ?>><?php echo $value["name"] ?></option>
                    <?php } ?>
                </select>

            </div>
        </div>

        <div class="form-group row m-b-15">
            <label class="col-md-2 col-sm-4 col-form-label" for="website">Restrinciones <stron style="color:red"> *</stron></label>
            <div class="col-md-10 col-sm-8">
                <?php $lista_de_restrinciones = explode(',', $info[0]["LISTA_RESTRICIONES"]); ?>
                <select class="multiple-select2 form-control" multiple="multiple" name="restrinciones[]" required data-parsley-errors-container="#listFieldError">
                    <option value="0">Sin restriciones</option>
                    <?php foreach ($menus as $value) { ?>
                        <option style="text-transform:capitalize;" value="<?php echo $value["ID"]; ?>" <?php echo (in_array($value["ID"],$lista_de_restrinciones)) ? "selected" : ""; ?>><?php echo $value["NOMBRE"] ?></option>
                    <?php } ?>
                </select>
                <span id="listFieldError"></span>
            </div>
        </div>


        <!--<div class="form-group row m-b-15">
            <label class="col-md-2 col-sm-4 col-form-label" for="website">Permisos <stron style="color:red"> *</stron></label>
            <div class="col-md-2 col-sm-8">
                <div class="checkbox checkbox-css checkbox-inline">
                    <input type="checkbox" id="inlineCssCheckbox1" name ="ver" value="on"  <?php echo ($info[0]["LEER"]) ? "checked" : ""; ?>/>
                    <label for="inlineCssCheckbox1">Ver</label>
                </div>

            </div>
            <div class="col-md-2 col-sm-8">
                <div class="checkbox checkbox-css checkbox-inline">
                    <input type="checkbox" id="inlineCssCheckbox2" name ="actualizar" value="on" <?php echo ($info[0]["ACTUALIZAR"]) ? "checked" : ""; ?>/>
                    <label for="inlineCssCheckbox2">Actualizar</label>
                </div>

            </div>
            <div class="col-md-2 col-sm-8">
                <div class="checkbox checkbox-css checkbox-inline">
                    <input type="checkbox" id="inlineCssCheckbox3"  name ="borrar" value="on" <?php echo ($info[0]["ELIMINAR"]) ? "checked" : ""; ?>/>
                    <label for="inlineCssCheckbox3">Borrar</label>
                </div>

            </div>
            <div class="col-md-3 col-sm-8">
                <div class="checkbox checkbox-css checkbox-inline">
                    <input type="checkbox" id="inlineCssCheckbox4" name ="crear" value="on" <?php echo ($info[0]["CREAR"]) ? "checked" : ""; ?>/>
                    <label for="inlineCssCheckbox4">Crear</label>
                </div>

            </div>-->
</div>











</form>
</div>


<div class="modal-footer">
    <a href="javascript:;" class="btn btn-success" id="btn_guardar_permiso">Guardar Cambios <i class="fa fa-save"></i></a>
    <a href="javascript:;" class="btn btn-danger" data-dismiss="modal">Cancelar <i class="fa fa-times"></i></a>
</div>

<script>
    var $frm_modficar_agregar_analisis = $("#frm_modficar_agregar_analisis");

    window.Parsley.addValidator('noselectseleccion',
            function(value) {
                return value != 0
            })
        .addMessage('es', 'noselectseleccion', 'Debe seleccionar una opcion');

    $(".multiple-select2").select2();
</script>