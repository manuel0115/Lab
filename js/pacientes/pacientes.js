
var tablaAnalisis = $("#tblAnalisis").DataTable({
  ajax: "pacientes/cargarDatosPacientes",
  type: "POST",
  columns: [
    { data: "ID", className: "text-center", orderable: false },
    { data: "NOMBRE", className: "text-center", orderable: false },
    { data: "CEDULA", className: "text-center", orderable: false },
    { data: "GENERO", className: "text-center", orderable: false },
    { data: "FECHA_NACIMIENTO", className: "text-center", orderable: false },
    { data: null, className: "text-center", orderable: false },
  ],
  aoColumnDefs: [
    {
      aTargets: [5],
      mRender: function (data, type, full) {
        return (
          '<a href="javascript:void(0);" id="' +
          full.ID +
          '"  class="btn btn-primary btn_editar_pacientes" ><i class="fa fa-edit"></a>'
        );
      },
    },
  ],
  language: {
    url: "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
  },
  buttons: [
    {
      //                            "extend": "text",
      className: "btn btn-labeled btn-success",
      text:
        '<span class="btn-label"><i class="fa fa-plus"></i></span>&nbsp;Agregar paciente',
      action: function (nButton, oConfig, oFlash) {
        $(".modal_usuarios .modal-content").load(
          "pacientes/getModalPacientes",
          function () {
            $(".modal_usuarios").modal({
              backdrop: 'static', 
              keyboard: false,
              show:true
            });
          }
        );
      },
      init: function (api, node, config) {
        $(node).removeClass("dt-button");
      },
    },
  ],
  dom:
    "<'row'<'col-sm-5'l><'col-sm-7 'Bfr>>" +
    "t" +
    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
    preDrawCallback: function () {
      $(".dt-buttons").addClass("float-right");
      $(".dt-buttons").css("margin-left","5px");
    },
});

$(".modal_usuarios .modal-content").on("click","#btn_guardar_paciente",function(){

  var url = $frm_modficar_agregar_analisis .attr("action");
  var datos = $frm_modficar_agregar_analisis .serializeArray();

  var validation = $frm_modficar_agregar_analisis .parsley().validate();
  if (validation) {
    $.post(url,datos,function (data) {
        if (data.codigo == 0) {
          swal({
            text: data.mensaje,
            title: "Petfecto!",
            icon: "success",
          });
          tablaAnalisis.ajax.reload();
          $(".modal_usuarios").modal("hide");
        } else {
          swal({
            text: data.mensaje,
            title: "Error!",
            icon: "error",
          });
        }
      },
      "json"
    );
  }
})

$("#tblAnalisis").on("click", ".btn_editar_pacientes", function () {
  
  id=btoa(btoa(btoa($(this).attr("id"))));

  $(".modal_usuarios .modal-content").load("pacientes/getModalPacientes/"+id,function () {
   
      $(".modal_usuarios").modal({
        backdrop: 'static', 
        keyboard: false,
        show:true
      });
      

    })
});



