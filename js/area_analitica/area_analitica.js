//alert("dd");


var tabla_administrar_area_analitica= $("#tabla_administrar_area_analitica").DataTable({
    ajax: "area_analitica/datosTablaArea_analitica",
    columns: [
      { data: "ID", className: "text-center", orderable: false },
      { data: "NOMBRE", className: "text-center", orderable: false },
      { data: null, className: "text-center", orderable: false },
   
    ],
    aoColumnDefs: [
      
      
      {
        aTargets: [2],
        mRender: function (data, type, full) {
          return (
            '<a href="javascript:void(0);" id="' +
            full.ID +
            '"  class="btn btn-primary btn_editar_area" ><i class="fa fa-edit"></a>'
          );
        },
      },
    ],
    "language": {
      url: "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
    },
    "buttons": [
      {
        //                            "extend": "text",
        "className": "btn btn-labeled btn-success",
        "text":
          '<span class="btn-label"><i class="fa fa-plus"></i></span>&nbsp;Agregar Area analitica',
        action: function (nButton, oConfig, oFlash) {
          $(".modal_usuarios .modal-content").load("area_analitica/getModalarea_analitica",function () {

            $(".modal_usuarios").modal("show");

      
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

$(".modal_usuarios .modal-content").on("click","#btn_guardar_area",function(){
  var url = $frm_modficar_area.attr("action");
  var datos = $frm_modficar_area.serializeArray();
 

  

  var validation = $frm_modficar_area.parsley().validate();
  if (validation) {
    $.post(url,datos,function (data) {
        if (data.codigo == 0) {
          swal({
            text: data.mensaje,
            title: "Petfecto!",
            icon: "success",
          });
          tabla_administrar_area_analitica.ajax.reload();
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

$("#tabla_administrar_area_analitica").on("click", ".btn_editar_area", function () {
  
  id=btoa(btoa(btoa($(this).attr("id"))));

  $(".modal_usuarios .modal-content").load("area_analitica/getModalarea_analitica/"+id,function () {
   
      $(".modal_usuarios").modal("show");
      

    }
  );

  //alert();
});

  
  /*var cropo;
  
  $("#tabla_administrar_usuarios").on("click", ".btn_subir_foto", function () {
    var usuario_id = $(this).attr("id");
    usuario_id = btoa(btoa(btoa(usuario_id)));
    var categoria = $(this).attr("data-categoria");
  
    $(".modal_agregar_foto_perfil .modal-content").load(
      "usuarios/getModalCargarFoto/" + usuario_id + "/" + categoria,
      function () {
        $("#file_img").click();
        $("#file_img").change(function (e) {
          var reader = new FileReader();
  
          reader.readAsDataURL(e.target.files[0]);
  
          reader.onload = function () {
            cropo = $("#image_contenedor").croppie({
              viewport: {
                width: 300,
                height: 300,
                type: "square",
              },
              boundary: { width: 700, height: 600 },
              mouseWheelZoom: false,
              enableResize: false,
            });
  
            cropo.croppie("bind", {
              url: reader.result,
            });
  
            $(".modal_agregar_foto_perfil").modal("show");
          };
        });
      }
    );
  });
  
  $(".modal_agregar_foto_perfil").on("click", ".btn_subir_imagen", function () {
    var usuario_id = $(this).attr("id");
    var categoria = $(this).attr("name");
    cropo
      .croppie("result", {
        type: "base64",
        size: "viewport",
        format: "png",
      })
      .then(function (resp) {
        $.post(
          "usuarios/cargarArchivoAjax",
          { imge_B64: resp, usuario_id: usuario_id, categoria: categoria },
          function (data) {
            if (data.codigo == 0) {
              swal({
                text: data.mensaje,
                title: "Petfecto!",
                icon: "success",
              });
  
              $tabla_usuario.ajax.reload();
  
              //$(".modal_agregar_foto_perfil").modal("hide");
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
      });
  });
  
  $(".modal_usuarios").on(
    "click",
    "#btn_guardar_cambios_agregar_eventos",
    function () {
      var url = $frm_modficar_agregar_evento.attr("action");
      var datos = $frm_modficar_agregar_evento.serializeArray();
      var hora = moment($("#hora").val(), "h:mm A").format("HH:mm");
      var fecha_evento = moment($("#fecha_evento").val(), "DD-MM-YYYY").format(
        "YYYY-MM-DD"
      );
      var fecha_limite = moment($("#fecha_limite").val(), "DD-MM-YYYY").format(
        "YYYY-MM-DD"
      );
  
      datos.push({ name: "hora", value: hora });
      datos.push({ name: "fecha_evento", value: fecha_evento });
      datos.push({ name: "fecha_limite", value: fecha_limite });
  
      var validation = $frm_modficar_agregar_evento.parsley().validate();
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
              $tabla_usuario.ajax.reload();
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
  
  $("#tabla_administrar_usuarios").on(
    "click",
    ".btn_editar_usuario",
    function () {
      var id = btoa(btoa(btoa($(this).attr("id"))));
  
      console.log(id);
  
      $(".modal_usuarios .modal-content").load(
        "eventos/getModalEvento/" + id,
        function () {
          $(".modal_usuarios").modal("show");
        }
      );
    }
  );
  */