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
    <h4 class="modal-title"><?php echo (is_array($datos_evento)) ? "Generar Resultado" : "Modificar Resultado"; ?></h4>
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
                <form  class="form-horizontal">
                    <thead>
                        <tr>
                            <th width="1%" class="text-rap" class="text-center">ID</th>
                            <th width="5%" class="text-rap" class="text-center">NOMBRE</th>
                            <th width="10%" class="text-rap" class="text-center">CEDULA</th>
                            <th width="1%" class="text-rap" class="text-center">GENERO</th>
                            <th width="5%" class="text-rap" class="text-center">FECHA</th>

                        </tr>
                        <tr>
                            <th width="1%" class="text-rap" class="text-center"><input class="form" style="width:100%" type="text"></th>
                            <th width="5%" class="text-rap" class="text-center"><input class="form" style="width:100%" type="text"></th>
                            <th width="10%" class="text-rap" class="text-center"><input class="form" style="width:100%" type="text"></th>
                            <th width="1%" class="text-rap" class="text-center"><input class="form" style="width:100%" type="text"></th>
                            <th width="5%" class="text-rap" class="text-center"><input class="form" style="width:100%" type="text"></th>

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
        ajax: "pacientes/cargarDatosPacientes",
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
                data: "CEDULA",
                className: "text-center",
                orderable: false
            },
            {
                data: "GENERO",
                className: "text-center",
                orderable: false
            },
            {
                data: "FECHA_NACIMIENTO",
                className: "text-center",
                orderable: false
            }

        ],
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
        },
        buttons: [{
            //                            "extend": "text",
            className: "btn btn-labeled btn-success",
            text: '<span class="btn-label"><i class="fa fa-plus"></i></span>&nbsp;Agregar paciente',
            action: function(nButton, oConfig, oFlash) {
                $(".modal_usuarios .modal-content").load(
                    "pacientes/getModalPacientes",
                    function() {
                        $(".modal_usuarios").modal({
                            backdrop: 'static',
                            keyboard: false,
                            show: true
                        });
                    }
                );
            },
            init: function(api, node, config) {
                $(node).removeClass("dt-button");
            },
        }, ],
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

    $('#tblPacientesFiltado tbody').on('dblclick', 'tr', function () {
       let id=$(this).children().eq(0).text();
       let nombre=$(this).children().eq(1).text();
       let cedula=$(this).children().eq(2).text();
        
       $("#id_paciente").val(id);
       $("#nombre").val(nombre);
       $("#cedula").val(cedula);

       $(".modal_tabla_pacientes").modal("hide");
       $('.modal_usuarios').modal("show");
    } );
</script>