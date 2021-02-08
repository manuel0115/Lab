<?php
/*
echo "<pre>";
print_r($lista_analisis);
echo "</pre>";

*/
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
    <h4 class="modal-title">Obtener Sucursal</h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body p-0">

    <div class="panel panel-inverse">
        <!-- begin panel-heading -->
        <div class="panel-heading">
            <h4 class="panel-title"></h4>

        </div>
        <!-- end panel-heading -->
        <!-- begin panel-body -->
        <div class="panel-body table-responsive p-0">
            <table id="tblPacientesFiltado" class="table table-striped table-bordered table-td-valign-middle" style="width:100%;">
                <form class="form-horizontal">
                    <thead>
                        <tr>
                            <th width="1%" class="text-rap" class="text-center">ID</th>
                            <th width="5%" class="text-rap" class="text-center">NOMBRE</th>
                            <th width="10%" class="text-rap" class="text-center">ID LABORATORIO</th>
                            <th width="10%" class="text-rap" class="text-center">LABORATORIO</th>



                        </tr>
                        <tr>
                            <th width="1%" class="text-rap" class="text-center"><input class="form" style="width:100%" type="text"></th>
                            <th width="5%" class="text-rap" class="text-center"><input class="form" style="width:100%" type="text"></th>
                            <th width="10%" class="text-rap" class="text-center"><input class="form" style="width:100%" type="text"></th>
                            <th width="10%" class="text-rap" class="text-center"><input class="form" style="width:100%" type="text"></th>

                        </tr>

                    </thead>
                </form>
                <tbody>

                <tbody>
            </table>
        </div>

    </div>
</div>




<div class="modal-footer">
    <a href="javascript:;" class="btn btn-success" id="btn_guardar_orden">Guardar Cambios <i class="fa fa-save"></i></a>
    <a href="javascript:;" class="btn btn-danger" data-dismiss="modal">Cancelar <i class="fa fa-times"></i></a>
</div>

<script>
    var tblPacientesFiltado = $("#tblPacientesFiltado").DataTable({
        ajax: "sucursales/cargarDatosSucursales",
        type: "POST",
        columns: [{
                data: "ID",
                className: "text-center",
                orderable: false
            },
            {
                data: "NOMBRE",
                className: "text-center",
                orderable: false
            },
            {
                data: "ID_LABORATORIO",
                className: "text-center",
                orderable: false
            },
            {
                data: "LABORATORIO_NOMBRE",
                className: "text-center",
                orderable: false
            }

        ],
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
        },

        dom: "<'row'<'col-sm-5'><'col-sm-7 '>>" +
            "t" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        preDrawCallback: function() {
            $(".dt-buttons").addClass("float-right");
            $(".dt-buttons").css("margin-left", "5px");
        },
    });

    $("#tblPacientesFiltado thead th input[type=text]").on('keyup', function() {


        tblPacientesFiltado
            .column($(this).parent().index() + ':visible')
            .search(this.value)
            .draw();
    });

    $('#tblPacientesFiltado tbody').on('dblclick', 'tr', function() {
        let id = $(this).children().eq(0).text();
        let nombresucursal = $(this).children().eq(1).text();
        let idlaboratorio = $(this).children().eq(2).text();
        let nombrelaboratorio = $(this).children().eq(3).text();


        if ($("#grupo").val() == 3) {
            $("#sucursal").val(nombrelaboratorio);
        } else{
            $("#sucursal").val(nombresucursal);
        }



        $("#id_sucursal").val(id);
       
        $("#idlaboratorio").val(idlaboratorio);

        $(".modal_tabla_sucursales").modal("hide");

    });
</script>