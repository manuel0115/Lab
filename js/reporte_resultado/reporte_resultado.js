var tblReporteResultado = $("#tblAnalisis").DataTable({
  ajax: "reporte_resultado/tablaReporteResultado",
  type: "POST",
  columns: [
    { data: "ID_ORDEN", className: "text-center", orderable: false },
    { data: "NOMBRE", className: "text-center", orderable: false },
    { data: "CEDULA", className: "text-center", orderable: false },
    { data: "CREADO_EN", className: "text-center", orderable: false },
    { data: null, className: "text-center", orderable: false },
    { data: null, className: "text-center", orderable: false },
  ],
  aoColumnDefs: [
    {
      aTargets: [4],
      mRender: function (data, type, full) {
        return (
          '<a href="javascript:void(0);" id="' +
          full.ID_RESULTADO +
          '"  class="btn btn-primary btn_editar_analsis" ><i class="fa fa-edit"></a>'
        );
      },
    },
    {
      aTargets: [5],
      mRender: function (data, type, full) {
        return (
          '<a href="javascript:void(0);" data-id="' +
          full.ID_RESULTADO +
          '"  class="btn btn-primary btn_imprimir_resultado" ><i class="fa fa-print"></a>'
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
        '<span class="btn-label"><i class="fa fa-plus"></i></span>&nbsp;Agregar Area analitica',
      action: function (nButton, oConfig, oFlash) {
        $(".modal_usuarios .modal-content").load(
          "analisis/getModalanalisis",
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
    "<'row'<'col-sm-5'l><'col-sm-7 'fr>>" +
    "t" +
    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
  preDrawCallback: function () {
    $(".dt-buttons").addClass("float-right");
    $(".dt-buttons").css("margin-left", "5px");
  },
});

$(".modal_usuarios .modal-content").on(
  "click",
  "#btn_guardar_analisis",
  function () {
    var url = $frm_modficar_agregar_analisis.attr("action");
    var datos = $frm_modficar_agregar_analisis.serializeArray();

    var validation = $frm_modficar_agregar_analisis.parsley().validate();
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
            tblReporteResultado.ajax.reload();
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

$("#tblAnalisis").on("click", ".btn_imprimir_resultado", function () {
  id = btoa(btoa(btoa($(this).attr("data-id"))));

  $(".modal_imprimir_resultado .modal-content").load(
    "reporte_resultado/getModalImprimir/" + id,
    function () {
      $(".modal_imprimir_resultado").modal({
        //backdrop: 'static',
        // keyboard: false,
        show: true,
      });
    }
  );
});

$("#tblAnalisis").on("click", ".btn_editar_analsis", function () {
  id = btoa(btoa(btoa($(this).attr("id"))));

  $(".modal_usuarios .modal-content").load(
    "reporte_resultado/editarModalResultado/" + id,
    function () {
      $(".modal_usuarios").modal({
        //backdrop: 'static',
        // keyboard: false,
        show: true,
      });
    }
  );
});

$(".modal_imprimir_resultado").on(
  "click",
  "#btn_imprimir_analisis",
  function () {
    let id = btoa(btoa(btoa($(this).attr("data-id-resultado"))));
    window.open("reporte_resultado/imprimir_resultado/" + id, "_blank") ||
      window.location.replace("reporte_resultado/imprimir_resultado/" + id);
  }
);

$(".modal_usuarios").on("click", "#btn_editar_resultado", function () {
  var url = $frm_guardar_resultado.attr("action");
  //var datos = $frm_guardar_resultado.serializeArray();

  datos = [];
  $(".padre-maestro").each(function (index, value) {
    //console.log(false,' ','false');

    let id_analisis = $(this).attr("data-analisis");

    let input_parametros = $(this)
      .children(".agrupar-parametros")
      .find(".valor");

    let objetoParametro = [];

    input_parametros.each(function (index, value) {
      let objeto = {
        id_paremetro: $(this).attr("data-parametro"),
        valor: $(this).val(),
      };

      objetoParametro.push(objeto);
    });

    let comentario = $(this)
      .children(".contenedor-comentario-parametros")
      .children("textarea")
      .val();

    objeto = {
      id_analisis: id_analisis,
      parametros: objetoParametro,
      comentario: comentario,
    };

    datos.push(objeto);
  });

  var validation = $frm_guardar_resultado.parsley().validate();
  if (validation) {
    //console.log(datos);
    //let $datos =JSON.stringify(datos);
    //console.log($datos);

    $.post(
      url,
      {datos: datos},
      function (data) {
        if (data.codigo == 0) {
          swal({
            text: data.mensaje,
            title: "Petfecto!",
            icon: "success",
          });

          tblordenes.ajax.reload();
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
});
