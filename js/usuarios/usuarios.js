
var tablaAnalisis = $("#tblAnalisis").DataTable({
  ajax: "usuarios/cargarDatosUSUARIOS",
  type: "POST",
  columns: [
    { data: "ID_USUARIO", className: "text-center", orderable: false },
    { data: "NOMBRE_USUARIO", className: "text-center", orderable: false },
    { data: "CORREO_USUARIO", className: "text-center", orderable: false },
    { data: "CELULAR", className: "text-center", orderable: false },
    { data: "CEDULA", className: "text-center", orderable: false },
    { data: "GENERO", className: "text-center", orderable: false },
    { data: "ROL", className: "text-center", orderable: false },
    { data: null, className: "text-center", orderable: false },
    { data: null, className: "text-center", orderable: false },
    { data: null, className: "text-center", orderable: false },
  ],
  aoColumnDefs: [
    {
      aTargets: [7],
      mRender: function (data, type, full) {
        let activo =
          full.ACTIVO == "0"
            ? '<span class="label label-danger">Suspendido</span>'
            : '<span class="label label-success">Activo</span>';
        return activo;
      },
    },
    {
      aTargets: [8],
      mRender: function (data, type, full) {
        return (
          '<a href="javascript:void(0);" id="' +
          full.ID_USUARIO +
          '"  class="btn btn-primary btn_editar_usuario" ><i class="fa fa-edit"></a>'
        );
      },
    },
    {
      aTargets: [9],
      mRender: function (data, type, full) {
        return (
          '<a href="javascript:void(0);" data_id_usuario="' +
          full.ID_USUARIO +
          '"  class="btn btn-danger btn_editar_eliminar_usuario" ><i class="fa fa-times"></a>'
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
        '<span class="btn-label"><i class="fa fa-plus"></i></span>&nbsp;Agregar usuario',
      action: function (nButton, oConfig, oFlash) {
        $(".modal_usuarios .modal-content").load(
          "usuarios/getModalUsuarios",
          function () {
            $(".modal_usuarios").modal({
              backdrop: "static",
              keyboard: false,
              show: true,
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
    $(".dt-buttons").css("margin-left", "5px");
  },
});

$(".modal_usuarios .modal-content").on(
  "click",
  "#btn_guardar_usuario",
  function () {
    var url = $frm_modficar_agregar_analisis.attr("action");
    var datos = $frm_modficar_agregar_analisis.serializeArray();

    var validation = $frm_modficar_agregar_analisis.parsley().validate();
    //alert();
    if (validation) {
      $.post(
        url,
        datos,
        function (data) {
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
  }
);

$("#tblAnalisis").on("click", ".btn_editar_usuario", function () {
  id = btoa(btoa(btoa($(this).attr("id"))));

  $(".modal_usuarios .modal-content").load(
    "usuarios/getModalUsuarios/" + id,
    function () {
      $(".modal_usuarios").modal({
        backdrop: "static",
        keyboard: false,
        show: true,
      });
    }
  );
});

$("#tblAnalisis thead th input[type=text]").on("keyup", function () {
  tablaAnalisis
    .column($(this).parent().index() + ":visible")
    .search(this.value)
    .draw();
});

$("#tblAnalisis").on("click", ".btn_editar_eliminar_usuario", function () {
  swal({
    title: "¿Esta seguro que desea eliminar el usuario?",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  }).then((cerrar_sesion) => {
    if (cerrar_sesion) {
      id = btoa(btoa(btoa($(this).attr("data_id_usuario"))));

      $.post("usuarios/eliminarUsuario/" + id, function (data) {
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
      },"json");
    }
  });
});
