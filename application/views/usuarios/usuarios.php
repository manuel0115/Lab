<!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
<link href="assets/admin/plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css?<?php echo time(); ?>" rel="stylesheet" />
<link href="assets/admin/plugins/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css?<?php echo time(); ?>" rel="stylesheet" />
<link href="assets/admin/plugins/tag-it/css/jquery.tagit.css" rel="stylesheet" />
<style>
    .modal {
        overflow-y: auto !important;
    }
</style>

<!-- ================== END PAGE LEVEL STYLE ================== -->

<!-- begin breadcrumb -->

<!-- end breadcrumb -->
<!-- begin page-header -->
<h1 class="page-header">Usuarios <small> > Lista de usuarios </small></h1>
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
        <table id="tblAnalisis" class="table table-striped table-bordered table-td-valign-middle" style="width:100%;">
            <thead>
                <tr>
                    <th width="5%" class="text-rap" class="text-center">ID</th>
                    <th width="10%" class="text-rap" class="text-center">NOMBRE</th>
                    <th width="10%" class="text-rap" class="text-center">CORREO</th>
                    <th width="10%" class="text-rap" class="text-center">CELULAR</th>
                    <th width="10%" class="text-rap" class="text-center">CEDULA</th>
                    <th width="10%" class="text-rap" class="text-center">GENERO</th>
                    <th width="10%" class="text-rap" class="text-center">ROL</th>
                    <th width="10%" class="text-rap" class="text-center">ESTADO</th>
                    <th width="1%" class="text-rap" class="text-center">OPCIONES</th>
                    <th width="10%" class="text-rap" class="text-center">ELIMINAR</th>
                </tr>
                <tr>
                    <th width="10%" class="text-rap" class="text-center"><input type="text" style="width: 100%;" class="form-control"></th>
                    <th width="10%" class="text-rap" class="text-center"><input type="text" style="width: 100%;" class="form-control"></th>
                    <th width="10%" class="text-rap" class="text-center"><input type="text" style="width: 100%;" class="form-control"></th>
                    <th width="10%" class="text-rap" class="text-center"><input type="text" style="width: 100%;" class="form-control"></th>
                    <th width="10%" class="text-rap" class="text-center"><input type="text" style="width: 100%;" class="form-control"></th>
                    <th width="10%" class="text-rap" class="text-center"><input type="text" style="width: 100%;" class="form-control"></th>
                    <th width="10%" class="text-rap" class="text-center"><input type="text" style="width: 100%;" class="form-control"></th>
                    <th width="10%" class="text-rap" class="text-center"><input type="text" style="width: 100%;" class="form-control"></th>
                    <th width="1%" class="text-rap" class="text-center">&nbsp;</th>
                    <th width="1%" class="text-rap" class="text-center">&nbsp;</th>
                </tr>
            </thead>
            <tbody>

            <tbody>
        </table>
    </div>
    <!-- end panel-body -->
</div>
<!-- end panel -->
<!-- #modal-alert -->
<div class="modal fade modal_usuarios" >
    <div class="modal-dialog" style="width: 100%;max-width: 650px;">
        <div class="modal-content">

        </div>
    </div>
</div>

<div class="modal fade modal_tabla_sucursales" >
    <div class="modal-dialog" style="width: 100%;max-width: 650px;">
        <div class="modal-content">

        </div>
    </div>
</div>

<!-- ================== BEGIN PAGE LEVEL JS ================== -->
<script>
    App.setPageTitle('LaboPro | Administrar analisis');
    App.restartGlobalFunction();

    $.getScript('assets/admin/plugins/datatables.net/js/jquery.dataTables.min.js?<?php echo time(); ?>').done(function () {
        $.when(
                $.getScript('assets/admin/plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js'),
                $.getScript('assets/admin/plugins/datatables.net-responsive/js/dataTables.responsive.min.js'),
                $.getScript('assets/admin/plugins/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js'),
                $.getScript('assets/admin/plugins/datatables.net-buttons/js/dataTables.buttons.min.js'),
                $.getScript('assets/admin/plugins/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js'),
                $.getScript('assets/admin/plugins/tag-it/js/tag-it.min.js'),
                $.Deferred(function (deferred) {
                    $(deferred.resolve);
                })
                ).done(function () {
            $.getScript('js/usuarios/usuarios.js?<?php echo time(); ?>'),
                    $.Deferred(function (deferred) {
                        $(deferred.resolve);
                    })
        });
    });






</script>
<!-- ================== END PAGE LEVEL JS ================== -->
