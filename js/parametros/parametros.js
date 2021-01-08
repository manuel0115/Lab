

var tblAnalisis= $("#tblAnalisis").DataTable({
    ajax: "parametros/tablaParametros",
    type: "POST",
    columns: [
    
      { data: "ID", className: "text-center", orderable: false },
      { data: "NOMBRE", className: "text-center", orderable: false },
      { data: "ANALISIS", className: "text-center", orderable: false },
      { data: null, className: "text-center", orderable: false }
   
   
    ],
    aoColumnDefs: [
      
      
      {
        aTargets: [3],
        mRender: function (data, type, full) {
          return (
            '<a href="javascript:void(0);" id="' +
            full.ID +
            '"  class="btn btn-primary btn_editar_parametro" ><i class="fa fa-edit"></a>'
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
          '<span class="btn-label"><i class="fa fa-plus"></i></span>&nbsp;Agregar parametro',
        action: function (nButton, oConfig, oFlash) {
          $(".modal_usuarios .modal-content").load("parametros/getModalparametro",function () {

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
      }

    
});

$(".modal_usuarios .modal-content").on("click","#btn_guardar",function(){

    
        var url = $frm_modficar_agregar_evento.attr("action");
        var datos = $frm_modficar_agregar_evento.serializeArray();
      
    
        var validation = $frm_modficar_agregar_evento.parsley().validate();
        if (validation) {
          $.post(url,datos,function (data) {
              if (data.codigo == 0) {
                swal({
                  text: data.mensaje,
                  title: "Petfecto!",
                  icon: "success",
                });

                tblAnalisis.ajax.reload();
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
   


$("#tblAnalisis").on("click", ".btn_editar_parametro", function () {


    let id=$(this).attr("id");
    id= btoa(btoa(btoa(id)));
  
  $(".modal_usuarios .modal-content").load("parametros/getModalparametro/"+id,function () {

     


      $(".modal_usuarios").modal({
        backdrop: 'static', 
        keyboard: false,
        show:true
      });
      

    }
  );

  //alert();
});



/*var $tabla_usuario = $("#tabla_administrar_usuarios").DataTable({
    "ajax": "area_analitica/datosTablaArea_analitica",
    columns: [
      { data: null, className: "text-center", orderable: false },
      { data: null, className: "text-center", orderable: false },
      { data: "TITULO", className: "text-center", orderable: false },
      { data: "SUBTITULO", className: "text-center", orderable: false },
      { data: "CATEGORIA", className: "text-center", orderable: false },
      { data: "NOMBRE", className: "text-center", orderable: false },
      { data: "FECHA_EVENTO", className: "text-center", orderable: false },
      { data: "FECHA_LIMITE", className: "text-center", orderable: false },
   
    ],
    aoColumnDefs: [
      {
        aTargets: [0],
        mRender: function (data, type, full) {
          return full.ACTIVO == 1
            ? '<h5><span class="label label-success">000' +
                full.ID +
                "</span></h5>"
            : '<h5><span class="label label-danger">000' +
                full.ID +
                "</span></h5>";
        },
      },
      {
        aTargets: [1],
        mRender: function (data, type, full) {
          var foto = full.FOTO == null ? "data/img/usuarios/guest.png" : full.FOTO+ full.ID+".png?"+Math.random();
          return (
            '<a href="javascript:void(0);" data-categoria="eventos" class="btn_subir_foto img-rounded height-30" id="' +
            full.ID +
            '"><div style="width:50px;"><img src="' +
            foto +
            '" style="width:100%; border-radius:7px;"></div></a>'
          );
        },
      },
      
      
      {
        aTargets: [9],
        mRender: function (data, type, full) {
          return (
            '<a href="javascript:void(0);" id="' +
            full.ID +
            '"  class="btn btn-primary btn_editar_usuario" ><i class="fa fa-edit"></a>'
          );
        },
      },
    ],
    dom:
      "<'row'<'col-sm-5'l><'col-sm-7 'Br>>" +
      "t" +
      "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
    preDrawCallback: function () {
      $(".dt-buttons").addClass("pull-right");
    },
    "buttons": [
      {
        //                            "extend": "text",
        "className": "btn btn-labeled btn-success",
        "text":
          '<span class="btn-label"><i class="fa fa-plus"></i></span>&nbsp;Agregar Area analitica',
        action: function (nButton, oConfig, oFlash) {
          $(".modal_usuarios .modal-content").load(
            "eventos/getModalEvento",
            function () {
              $(".modal_usuarios").modal("show");
            }
          );
        },
        init: function (api, node, config) {
          $(node).removeClass("dt-button");
        },
      },
      
    ],
    "language": {
      url: "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
    },
  });*/
  
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