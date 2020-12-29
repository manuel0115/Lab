
<style>
    #image_contenedor{
        max-width: 100%;
    }   

    /*    .cr-boundary {
            
            height: 600px !important;
        }*/

</style>
<div class="modal-header">
    <h4 class="modal-title"><?php echo (is_array($datos_usuarios)) ? "Modificar Usuario" : "Agregar Usuario"; ?></h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">
    <form id="frm_modficar_agregar_usuario" class="form-horizontal"enctype="multipart/form-data">
        <input id="file_img" type="file" style="display: none" />
        <input id="categoria" name="categoria" type="hidden" value="<?php echo $categoria; ?>" style="display: none" />
        <input id="id_usuario" name="id_usuario" type="hidden" value="<?php echo $usuario_id; ?>" style="display: none" />


        <div id="image_contenedor">

        </div>

    </form>
</div>

<div class="modal-footer">
    <a href="javascript:;" class="btn btn-success btn_subir_imagen" name="<?php echo $categoria; ?>"  id="<?php echo $usuario_id; ?>">Subir imagen<i class="fa fa-save"></i></a>
    <a href="javascript:;" class="btn btn-danger" data-dismiss="modal">Cancelar<i class="fa fa-times"></i></a>
</div>

<script>


</script>



