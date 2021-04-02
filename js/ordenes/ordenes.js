var tblordenes = $("#tblAnalisis").DataTable({
  //ajax: "ordenes/cargarDatosOrdenes",
  //type: "POST",
  order: [[0, "desc"]],
  /*columns: [
    { data: "ORDEN", className: "text-center", orderable: false },
    { data: "PACIENTE", className: "text-center", orderable: false },
    { data: "REFERENCIA", className: "text-center", orderable: false },
    { data: "FECHA", className: "text-center", orderable: false },
    { data: null, className: "text-center", orderable: false },
    { data: null, className: "text-center", orderable: false },
    { data: null, className: "text-center", orderable: false },
    { data: null, className: "text-center", orderable: false },
  ],*/
  /*aoColumnDefs: [
    {
      aTargets: [4],
      mRender: function (data, type, full) {
        let existe_Resultado =
          full.RESULATADO_EXISTENTES === "1" ? "disabled" : "";
        return (
          '<a href="javascript:void(0);" id="' +
          full.ORDEN +
          '"  class="btn btn-primary btn_editar_ordenes ' +
          existe_Resultado +
          '" ><i class="fa fa-edit"></i></a>'
        );
      },
    },
    {
      aTargets: [5],
      mRender: function (data, type, full) {
        let existe_Resultado =
          full.RESULATADO_EXISTENTES === "1" ? "disabled" : "";
        return (
          '<a href="javascript:void(0);" data-orde-id="' +
          full.ORDEN +
          '" data-lista-analisis="' +
          full.LISTA_ANALISIS +
          '"  class="btn btn-success btn_crear_resultado ' +
          existe_Resultado +
          '" ><i class="fas fa-poll"></i></a>'
        );
      },
    },
    {
      aTargets: [6],
      mRender: function (data, type, full) {
        let existe_Resultado =
          full.RESULATADO_EXISTENTES === "1" ? "disabled" : "";
        return (
          '<a href="javascript:void(0);" data-orde-id="' +
          full.ORDEN +
          '" data-lista-analisis="' +
          full.LISTA_ANALISIS +
          '"  class="btn btn-warning btn_imprimir_resulatdo" > <i class="fas fa-print"></i></a>'
        );
      },
    },
    {
      aTargets: [7],
      mRender: function (data, type, full) {
        let existe_Resultado =
          full.RESULATADO_EXISTENTES === "1" ? "disabled" : "";
        return (
          '<a href="javascript:void(0);" data-orde-id="' +
          full.ORDEN +
          '" data-lista-analisis="' +
          full.LISTA_ANALISIS +
          '"  class="btn btn-danger btn_eliminar_orden" > <i class="fas fa-times"></i></a>'
        );
      },
    },
  ],*/
  language: {
    url: "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
  },
  buttons: [
    {
      //                            "extend": "text",
      className: "btn btn-labeled btn-success",
      text:
        '<span class="btn-label"><i class="fa fa-plus"></i></span>&nbsp;Crear Nueva orden',
      action: function (nButton, oConfig, oFlash) {
        $(".modal_usuarios .modal-content").load(
          "ordenes/getModalOrden",
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
    "<'row'<'col-sm-5'l><'col-sm-7 'r>>" +
    "t" +
    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
  preDrawCallback: function () {
    $(".dt-buttons").addClass("float-right");
    $(".dt-buttons").css("margin-left", "5px");
  },
});

$("#tblAnalisis").on("click", ".btn_editar_ordenes", function () {
  let id_orden = btoa(btoa(btoa($(this).attr("id"))));

  $(".modal_usuarios .modal-content").load(
    `ordenes/getModalOrden/${id_orden}`,
    function () {
      $(".modal_usuarios").modal({
        backdrop: "static",
        keyboard: false,
        show: true,
      });
    }
  );
});

$("#tblAnalisis").on("click", ".btn_crear_resultado", function () {
  //let lista_analisis = btoa($(this).attr("data-lista-analisis"));
  let orden_id = $(this).attr("data-orde-id");

  $(".modal_resultado .modal-content").load(
    `ordenes/getModalResultado/${orden_id}`,
    function () {
      $(".modal_resultado").modal({
        //backdrop: 'static',
        keyboard: false,
        show: true,
      });
    }
  );
});

$(".modal_usuarios .modal-content").on(
  "click",
  "#btn_guardar_orden",
  function () {
    let url = $frm_modficar_agregar_orden.attr("action");
    let datos = $frm_modficar_agregar_orden.serializeArray();

    var validation = $frm_modficar_agregar_orden.parsley().validate();
    if (validation) {
      let listaAnalisisOrdenes = [];

      $("#tblAnalisisOrdenes tbody tr td:nth-child(1)").each(function () {
        //add item to array
        listaAnalisisOrdenes.push($(this).text());
      });

      datos.push({ name: "lista_analisis", value: listaAnalisisOrdenes });

      if($("#id_orden").val() > 0){

        datos.push({ name: "lista_analisis_old", value: $("#lista_analisis_old").val() });
      }
      

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

            //tblordenes.ajax.reload();

            //location.reload();
            //$(".modal_usuarios").modal("hide");
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

$(".modal_resultado").on("click", "#btn_guardar_resultado", () => {
  var url = $frm_guardar_resultado.attr("action");
  let orden = $frm_guardar_resultado.attr("data-id-orden");
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
        status:$(this).attr("data-status"),
      };

      objetoParametro.push(objeto);
    });

    let comentario = $(this)
      .children(".contenedor-comentario-parametros")
      .children("textarea")
      .val();

    objeto = {
      id_analisis_resultado: id_analisis,
      parametros: objetoParametro,
      comentario: comentario,
    };

    datos.push(objeto);
  });

  // console.log( {"datos":datos,"id_orden":orden});

  var validation = $frm_guardar_resultado.parsley().validate();
  if (validation) {
    

    $.post(
      url,
      { datos: datos, id_orden: orden },
      function (data) {
        if (data.codigo == 0) {
          swal({
            text: data.mensaje,
            title: "Petfecto!",
            icon: "success",
          });

          //tblordenes.ajax.reload();

          /*location.reload();
          $(".modal_resultado").modal("hide");*/
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

$(".modal_usuarios .modal-content").on(
  "dblclick",
  ".tabla_paciente",
  function () {
    $(".modal_tabla_pacientes .modal-content").load(
      `ordenes/getModalPacientes/`,
      function () {
        $(".modal_tabla_pacientes").modal({
          backdrop: "static",
          keyboard: false,
          show: true,
        });
      }
    );
  }
);

$("#tblAnalisis").on("click", ".btn_eliminar_orden", function () {


  swal({
    title: "¿Esta seguro que desea eliminar esta analisis?",
    icon: "warning",
    buttons: true,
    dangerMode: true,
})
.then((cerrar_sesion) => {
    if (cerrar_sesion) {
      let id_orden = btoa(btoa(btoa($(this).attr("data-orde-id"))));

      $.post(
        "ordenes/eliminarOrdenes/" + id_orden,
        function (data) {
    
          if (data.codigo == 0) {
            swal({
              text: data.mensaje,
              title: "Petfecto!",
              icon: "success",
            });
        
            //tblordenes.ajax.reload();

            /*location.reload();
            $(".modal_resultado").modal("hide");*/
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
  
  

 
});

$("#tblAnalisis").on("click", ".btn_imprimir_resulatdo", function () {
  id = btoa(btoa(btoa($(this).attr("data-orde-id"))));

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

$(".modal_imprimir_resultado").on(
  "click",
  "#btn_imprimir_analisis",
  function () {
    let id = btoa(btoa(btoa($(this).attr("data-id-resultado"))));
    window.open("reporte_resultado/imprimir_resultado/" + id, "_blank") ||
      window.location.replace("reporte_resultado/imprimir_resultado/" + id);
  }
);

$("#tblAnalisis thead th input[type=text]").on('keyup', function() {


  tblordenes
      .column($(this).parent().index() + ':visible')
      .search(this.value)
      .draw();
});


$("#btn_agregar_ordenes").click(function(){
  $(".modal_usuarios .modal-content").load(
    "ordenes/getModalOrden",
    function () {
      $(".modal_usuarios").modal({
        backdrop: "static",
        keyboard: false,
        show: true,
      });
    }
  );
});

function totalPrecios(claseName){
  let total=0;
  $(`.${claseName}`).each(function(){
    total += parseFloat($(this).text());
    
  });

  return `Total: $RD ${total}`
 
};
