<!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
<link href="assets/admin/plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
<link href="assets/admin/plugins/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" />
<!-- ================== END PAGE LEVEL STYLE ================== -->

<!-- begin breadcrumb -->

<!-- end breadcrumb -->
<!-- begin page-header -->
<h1 class="page-header">Usuarios <small id="prueba"> >Administrar Usuarios</small></h1>
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
        <table id="tabla_administrar_usuarios" class="table table-striped table-bordered table-td-valign-middle" style="width:100%;">
               <thead>
               <tr>
               <th width="1%">Codigo</th>
            <th width="1%" data-orderable="false">Foto</th>
            <th width="8%" class="text-rap">Nombre</th>
            <th width="9%" class="text-rap">Telefono</th>
            <th width="8%" class="text-rap">Correo</th>
            <th width="8%" class="text-rap">Titulo</th>
            <th width="8%" class="text-rap">Ocupacion</th>
            <th width="8%" class="text-rap">Cargo</th>
            <th width="1%" class="text-rap">Editar</th>
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
    <div class="modal-dialog" style="width: 100%;max-width: 700px;">
        <div class="modal-content">

        </div>
    </div>
</div>
</div>

<div class="modal fade modal_agregar_foto_perfil" >
    <div class="modal-dialog" style="width: 100%;max-width: 800px;">
        <div class="modal-content">

        </div>
    </div>
</div>
<!-- ================== BEGIN PAGE LEVEL JS ================== -->
<script>
    App.setPageTitle('UFEJI | Administrar Usuarios');
    App.restartGlobalFunction();

    $.getScript('assets/admin/plugins/datatables.net/js/jquery.dataTables.min.js?<?php echo time(); ?>').done(function () {
        $.when(
                $.getScript('assets/admin/plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js'),
                $.getScript('assets/admin/plugins/datatables.net-responsive/js/dataTables.responsive.min.js'),
                $.getScript('assets/admin/plugins/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js'),
                $.getScript('assets/admin/plugins/datatables.net-buttons/js/dataTables.buttons.min.js'),
                $.getScript('assets/admin/plugins/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js'),
                $.getScript('assets/admin/plugins/croppie/croppie.js?<?php echo time(); ?>').done(function () {
            $('head').append('<link rel="stylesheet" type="text/css" href="../../../assets/admin/plugins/croppie/croppie.css?<?php echo time(); ?>">')
        }),
                $.Deferred(function (deferred) {
                    $(deferred.resolve);
                })
                ).done(function () {
            $.getScript('assets/admin/js/demo/table-manage-default.demo.js'),
                    $.getScript('js/administrar_usuarios/administrar_usuarios.js?<?php echo time(); ?>'),
                    $.Deferred(function (deferred) {
                        $(deferred.resolve);
                    })
        });
    });




$("#prueba").click(function(){
    alert("d");
});
</script>
<!-- ================== END PAGE LEVEL JS ================== -->
