<style>
    .ui-autocomplete {
        z-index: 2147483647;
    }

    input[readonly] {
        background-color: #fff !important;
    }
</style>


<div class="modal-header">
    <h4 class="modal-title"><?php echo ($info[0]["ID"]) ? "Modificar Sucursal" : "Agregar Sucursal"; ?></h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">
    <form action="sucursales/guardar_sucursal" id="frm_modficar_agregar_analisis" class="form-horizontal" data-parsley-validate="true" name="frm_modficar_agregar_analisis">

        <input type="hidden" id="id_sucursal" name="id_sucursal" value='<?php echo $info[0]["ID"] ?>' />



        <div class="form-group row m-b-15">
            <label class="col-md-2 col-sm-4 col-form-label" for="website">Nombre <stron style="color:red"> *</stron></label>

            <div class="col-md-10 col-sm-10">
                <input class="form-control" type="text" id="nombre" name="nombre" required value='<?php echo $info[0]["NOMBRE"] ?>' />



            </div>
        </div>
        <div class="form-group row m-b-15">
            <label class="col-md-2 col-sm-4 col-form-label" for="website">Laboratorio <stron style="color:red"> *</stron></label>
            <div class="col-md-10 col-sm-8">
                <select style="text-transform:capitalize;" class="form-control" id="laboratorio" name="laboratorio" data-parsley-required="true" data-parsley-noselectseleccion>
                <option value="0">Seleccione una Laboratorio</option>
                    <?php foreach ($laboratorio as $value) { ?>
                        <option style="text-transform:capitalize;" value="<?php echo $value["ID"]; ?>" <?php echo ($info[0]["ID_LABORATORIO"] == $value["ID"]) ? "selected" : ""; ?>><?php echo $value["NOMBRE"] ?></option>
                    <?php } ?>
                </select>

            </div>
        </div>
       
        <div class="form-group row m-b-15">
            <label class="col-md-2 col-sm-4 col-form-label" for="website">Dirrecion <stron style="color:red"> *</stron></label>

            <div class="col-md-10 col-sm-10">
                <input class="form-control" type="text" id="direccion" name="direcion" required value='<?php echo $info[0]["DIRECCION"] ?>' />

            </div>


        </div>



        <div class="form-group row m-b-15">
            <label class="col-md-2 col-sm-4 col-form-label" for="website">Telefono <stron style="color:red"> *</stron></label>

            <div class="col-md-10 col-sm-10">
                <input class="form-control" type="text" id="telefono" name="telefono" required value='<?php echo $info[0]["TELEFONOS"] ?>' />

            </div>


        </div>
        <div class="form-group row m-b-15">
            <label class="col-md-2 col-sm-4 col-form-label" for="website">Activo <stron style="color:red"> *</stron></label>
            <div class="col-md-10 col-sm-8">
                <div class="custom-control custom-switch pt-1 mb-1">
                    <input type="checkbox" name="activo" class="custom-control-input" id="customSwitch1" <?php echo ($info[0]["ACTIVO"] == "1") ? "checked" : ""; ?> value="on">
                    <label class="custom-control-label" for="customSwitch1">Activo</label>
                </div>

            </div>
        </div>









    </form>
</div>


<div class="modal-footer">
    <a href="javascript:;" class="btn btn-success" id="btn_guardar_SUCURSAL">Guardar Cambios <i class="fa fa-save"></i></a>
    <a href="javascript:;" class="btn btn-danger" data-dismiss="modal">Cancelar <i class="fa fa-times"></i></a>
</div>

<script>
    var $frm_modficar_agregar_analisis = $("#frm_modficar_agregar_analisis");

    window.Parsley.addValidator('noselectseleccion',
            function(value) {
                return value != 0
            })
        .addMessage('es', 'noselectseleccion', 'Debe seleccionar una opcion');
</script>