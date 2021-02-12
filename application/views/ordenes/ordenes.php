<!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
<link href="assets/admin/plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css?<?php echo time(); ?>" rel="stylesheet" />
<link href="assets/admin/plugins/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css?<?php echo time(); ?>" rel="stylesheet" />


<style>
    .modal {
        overflow-y: auto !important;
    }
</style>
<!-- ================== END PAGE LEVEL STYLE ================== -->

<!-- begin breadcrumb -->

<!-- end breadcrumb -->
<!-- begin page-header -->
<h1 class="page-header">Analisis <small> > ordenes </small></h1>
<!-- end page-header -->
<!-- begin panel -->
<div class="panel panel-inverse">
    <!-- begin panel-heading -->
    <div class="panel-heading">
        <h4 class="panel-title"></h4>

    </div>
    <!-- end panel-heading -->
    <!-- begin panel-body -->
    <div class="panel-body table-responsive">
        <?php
        $grupo = array(1, 2, 3, 5);
        if ($this->ion_auth->in_group($grupo)) {
        ?>

            <a href="javascript:;" class="btn btn-primary float-right">Agregar Orden <i class="fas fa-plus"></i></a>
        <?php } ?>
        <table id="tblAnalisis" class="table table-striped table-bordered table-td-valign-middle" style="width:100%;">
            <thead>

                <tr>
                    <th width="10%" class="text-rap" class="text-center">Id</th>
                    <th width="8%" class="text-rap" class="text-center">Nombre paciente</th>
                    <th width="8%" class="text-rap" class="text-center">Referencia</th>
                    <th width="8%" class="text-rap" class="text-center">Fecha entrada</th>
                    <th width="8%" class="text-rap" class="text-center">Id paciente</th>
                    <th width="8%" class="text-rap" class="text-center">Cedula</th>
                    <th width="8%" class="text-rap" class="text-center">Correo</th>
                    <th width="8%" class="text-rap" class="text-center">Telefono</th>
                    <?php
                    $grupo = array(1, 2, 3, 5);
                    if ($this->ion_auth->in_group($grupo)) {
                    ?>
                        <th width="1%" class="text-rap" class="text-center">Opciones</th>
                    <?php } ?>
                    <th width="1%" class="text-rap" class="text-center">Manejo de resultados</th>
                    <th width="1%" class="text-rap" class="text-center">Impresion de resultados</th>
                    <?php
                    $grupo = array(1, 2, 3, 5);
                    if ($this->ion_auth->in_group($grupo)) {
                    ?>
                        <th width="1%" class="text-rap" class="text-center">Eliminar orden</th>
                    <?php } ?>

                </tr>
                <tr>
                    <form class="form-horizontal">
                        <th width="5%" class="text-rap" class="text-center"><input class="form-control" style="width:100%" type="text"></th>
                        <th width="5%" class="text-rap" class="text-center"><input class="form-control" style="width:100%" type="text"></th>
                        <th width="10%" class="text-rap" class="text-center"><input class="form-control" style="width:100%" type="text"></th>
                        <th width="10%" class="text-rap" class="text-center"><input class="form-control" style="width:100%" type="text"></th>
                        <th width="1%" class="text-rap" class="text-center"><input class="form-control" style="width:100%" type="text"></th>
                        <th width="5%" class="text-rap" class="text-center"><input class="form-control" style="width:100%" type="text"></th>
                        <th width="10%" class="text-rap" class="text-center"><input class="form-control" style="width:100%" type="text"></th>
                        <th width="10%" class="text-rap" class="text-center"><input class="form-control" style="width:100%" type="text"></th>
                        <?php
                        $grupo = array(1, 2, 3, 5);
                        if ($this->ion_auth->in_group($grupo)) {
                        ?>
                            <th width="1%" class="text-rap" class="text-center">&nbsp;</th>
                        <?php } ?>

                        <th width="1%" class="text-rap" class="text-center">&nbsp;</th>
                        <th width="1%" class="text-rap" class="text-center">&nbsp;</th>

                        <?php
                        $grupo = array(1, 2, 3, 5);
                        if ($this->ion_auth->in_group($grupo)) {
                        ?>
                            <th width="1%" class="text-rap" class="text-center">&nbsp;</th>
                        <?php } ?>




                    </form>
                </tr>


            </thead>
            <tbody>
                <?php foreach ($datos_tabla as $value) { ?>

                    <tr>
                        <td width="1%" class="text-rap" class="text-center"><?php echo $value["ORDEN"]; ?></td>
                        <th width="8%" class="text-rap" class="text-center"><?php echo $value["PACIENTE"]; ?></th>
                        <th width="8%" class="text-rap" class="text-center"><?php echo $value["REFERENCIA"]; ?></th>
                        <th width="8%" class="text-rap" class="text-center"><?php echo $value["FECHA"]; ?></th>
                        <th width="8%" class="text-rap" class="text-center"><?php echo $value["ID_PACIENTE"]; ?></th>
                        <th width="8%" class="text-rap" class="text-center"><?php echo $value["CEDULA_PACIENTE"]; ?></th>
                        <th width="8%" class="text-rap" class="text-center"><?php echo $value["CORREO_PACIENTE"]; ?></th>
                        <th width="8%" class="text-rap" class="text-center"><?php echo $value["TELEFONO_PACIENTE"]; ?></th>

                        <?php
                        $grupo = array(1, 2, 3, 5);
                        if ($this->ion_auth->in_group($grupo)) {
                        ?>
                            <th width="1%" class="text-rap" class="text-center"><?php echo "<a href='javascript:void(0);' id='" . $value["ORDEN"] . "' class='btn btn-primary btn_editar_ordenes'><i class='fa fa-edit'></i></a>"; ?></th>
                        <?php } ?>



                        <th width="1%" class="text-rap" class="text-center"><?php echo '<a href="javascript:void(0);" data-orde-id="' . $value["ORDEN"] . '"   class="btn btn-success btn_crear_resultado" ><i class="fas fa-poll"></i></a>' ?></th>
                        <th width="1%" class="text-rap" class="text-center"><?php echo '<a href="javascript:void(0);" data-orde-id="' . $value["ORDEN"] . '"   class="btn btn-warning btn_imprimir_resulatdo" ><i class="fas fa-print"></i></a>' ?></th>

                        <?php
                        $grupo = array(1, 2, 3, 5);
                        if ($this->ion_auth->in_group($grupo)) {
                        ?>
                            <th width="1%" class="text-rap" class="text-center"><?php echo '<a href="javascript:void(0);" data-orde-id="' . $value["ORDEN"] . '"   class="btn btn-danger btn_eliminar_orden" ><i class="fas fa-times"></i></a>' ?></th>
                        <?php } ?>


                    </tr>
                <?php } ?>

            <tbody>

        </table>
    </div>
    <!-- end panel-body -->
</div>
<!-- end panel -->
<!-- #modal-alert -->
<div class="modal fade modal_usuarios">
    <div class="modal-dialog" style="width: 100%;max-width: 800px;">
        <div class="modal-content">

        </div>
    </div>
</div>

<div class="modal fade modal_tabla_pacientes">
    <div class="modal-dialog" style="width: 100%;max-width: 650px;">
        <div class="modal-content">

        </div>
    </div>
</div>
</div>

<div class="modal fade modal_resultado">
    <div class="modal-dialog" style="width: 100%;max-width: 500px;">
        <div class="modal-content">

        </div>
    </div>
</div>

<div class="modal fade modal_imprimir_resultado">
    <div class="modal-dialog" style="width: 100%;max-width: 900px;">
        <div class="modal-content">

        </div>
    </div>
</div>
</div>


<!-- ================== BEGIN PAGE LEVEL JS ================== -->
<script>
    App.setPageTitle('UFEJI | Administrar Usuarios');
    App.restartGlobalFunction();

    $.getScript('assets/admin/plugins/datatables.net/js/jquery.dataTables.min.js?<?php echo time(); ?>').done(function() {
        $.when(
            $.getScript('assets/admin/plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js'),
            $.getScript('assets/admin/plugins/datatables.net-responsive/js/dataTables.responsive.min.js'),
            $.getScript('assets/admin/plugins/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js'),
            $.getScript('assets/admin/plugins/datatables.net-buttons/js/dataTables.buttons.min.js'),
            $.getScript('assets/admin/plugins/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js'),

            $.Deferred(function(deferred) {
                $(deferred.resolve);
            })
        ).done(function() {

            $.getScript('js/ordenes/ordenes.js?<?php echo time(); ?>'),
                $.Deferred(function(deferred) {
                    $(deferred.resolve);
                })
        });
    });
</script>
<!-- ================== END PAGE LEVEL JS ================== -->