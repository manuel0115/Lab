var tblconfiguracionAnalisis = $("#tblAnalisis").DataTable({
  ajax: "configuracion_analisis/cargarDatosConfiguracion_analisis",
  type: "POST",
  columns: [
    { data: "ID_ANALISISIS", className: "text-center", orderable: true },
    { data: "NOMBRE", className: "text-center", orderable: false },
    { data: "NOMBRE_LABORATORIO", className: "text-center", orderable: false },
    { data: null, className: "text-center", orderable: false },
    { data: null, className: "text-center", orderable: false },
  ],
  aoColumnDefs: [
    
    {
      aTargets: [3],
      mRender: function (data, type, full) {
        return (
          '<a href="javascript:void(0);" id="' +
          full.ID_ANALISISIS +
          '" data-modo="E"  class="btn btn-primary btn_editar_configuracion" ><i class="fa fa-edit"></a>'
        );
      },
    },
    {
      aTargets: [4],
      mRender: function (data, type, full) {
        return (
          '<a href="javascript:void(0);" data_id_configuracion="' +
          full.ID_ANALISISIS +
          '"  class="btn btn-danger btn_eliminar_configuracion" ><i class="fa fa-times"></a>'
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
        '<span class="btn-label"><i class="fa fa-plus"></i></span>&nbsp;Agregar Configuracion analisis',
      action: function (nButton, oConfig, oFlash) {
        $(".modal_usuarios .modal-content").load(
          "configuracion_analisis/getModalConfiguracionanalisis",
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
  "#btn_guardar_analisis",
  function () {
    

    


    var url = $frm_modficar_agregar_analisis.attr("action");
    
    let id_analisis=$("#ID_ANALISIS").val();
    let id_analisis_confifuracion=$("#modo").val();

    var validation = $frm_modficar_agregar_analisis.parsley().validate();
    if (validation) {


    let parametros=[];
    
    
    
    $(".parametro-individual").each(function(index,value){

      let id=$(this).attr("data-id-parametro");
      let medida=$(this).find(".medida").val();
      let hombre=$(this).find(".hombre").val();
      let mujer=$(this).find(".mujer").val();
      let Hnino=$(this).find(".hombre").find(".nino").val();
      let Hadulto=$(this).find(".hombre").find(".adulto").val();
      let Hanciano=$(this).find(".hombre").find(".anciano").val();
      let Mnino=$(this).find(".mujer").find(".nino").val();
      let Madulto=$(this).find(".mujer").find(".adulto").val();
      let Manciano=$(this).find(".mujer").find(".anciano").val();
      let orden_parametro=$(this).find(".orden_parametro").val();


      


      let parametro={
        "ID_PARAMETRO":`${id}`,
        "ORDEN_PARAMETRO":orden_parametro,        
        "MEDIDA":`${medida}`,
        "HOMBRE_NINO":Hnino,
        "HOMBRE_ADULTO":Hadulto,
        "HOMBRE_ANCIANO":Hanciano,
        "MUJER_NINO":Mnino,
        "MUJER_ADULTO":Madulto,
        "MUJER_ANCIANO":Manciano
          
      }
        

      

      parametros.push(parametro);

    });

      
   

    let datos={
      "parametros":parametros,
      "id_analisis":id_analisis,
      "id_analisis_confifuracion":id_analisis_confifuracion
    };

    swal({
      title: "¿Esta seguro que desea guardar estos analisis?",
      icon: "warning",
      buttons: true,
      dangerMode: true,
  })
          .then((cerrar_sesion) => {
              if (cerrar_sesion) {
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
                      tblconfiguracionAnalisis.ajax.reload();
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

      
    }
  }
);

$("#tblAnalisis").on("click", ".btn_editar_configuracion", function () {
  id = btoa(btoa(btoa($(this).attr("id"))));
  modo = btoa($(this).attr("data-modo"));


  $(".modal_usuarios .modal-content").load(
    "configuracion_analisis/getModalConfiguracionanalisis/" + id +'/'+modo,
    function () {
      $(".modal_usuarios").modal({
        
        show: true,
      });
    }
  );
});

$(".modal_usuarios .modal-content").on(
  "click",
  "#btn-agregar-parametros",
  function () {
    let contenedor_parametros = $(".contenedor-parametros");

    let idParametro = $(this).parent().siblings().val();
    let nombreParametro = $(this).parent().siblings().find(":selected").text();

    let parametros_individuales = $(".parametro-individual");

    let medidas = $(".contenedor-medidas-padre").html();
    let cantidad_parametros =$(contenedor_parametros).children().length;



    console.log(cantidad_parametros);
    
    if (cantidad_parametros == 0) {
        
        let numero_de_orden= cantidad_parametros + 1;
        let plantillaParemetro = agregarParametro(
        nombreParametro,
        idParametro,
        medidas,
        numero_de_orden
      
      );
      $(contenedor_parametros).append(plantillaParemetro);
    } else {
      let valor = false;
      parametros_individuales.each(function (index, value) {
        if ($(this).attr("data-id-parametro") == idParametro) {
          valor = true;
        }
      });

      if (!valor) {
        let numero_de_orden= cantidad_parametros + 1;
        let plantillaParemetro = agregarParametro(
          nombreParametro,
          idParametro,
          medidas,
          numero_de_orden
    

        );
        $(contenedor_parametros).append(plantillaParemetro);
      }
    }
  }
);

$(".modal_usuarios .modal-content").on(
  "click",
  ".eliminar-parametro",
  function () {
    swal({
      title: "¿Esta seguro que desea eliminar esta parametro?",
      icon: "warning",
      buttons: true,
      dangerMode: true,
  })
          .then((cerrar_sesion) => {
              if (cerrar_sesion) {
                $(this).parent().parent().remove();
              }
          });
   
    
   
  }
);

function agregarParametro(nombre, id, medida,numero_orden) {
  let plantillaParemetro = `<div data-id-parametro="${id}" class="row pb-2 mb-1 mt-1 parametro-individual" style="border:1px solid #00acac;border-radius:3px ">
  <div class="col-md-2 mt-2 pt-2">
      <h5 class="d-inline-block mr-2">${nombre}</h5>
      
  </div>
  <div class="col-md-3 mt-2 pl-0 contenedor-medidas">
      
      ${medida}
  </div>
  <div class="col-md-2 mt-2 pl-0 contenedor-medidas">
    <input class="form-control orden_parametro" min="1" type="number" value='${numero_orden}' placeholder="orden" />
  </div>
  <div class="col-md-5 mt-2">
      <button type="button" class="close float-right  eliminar-parametro" aria-hidden="true">×</button>
  </div>
  <div class="row hombre" style="max-width: 100%;">
      <div class="col-md-2 mt-3 ">
          <label class="col-md-3 col-sm-3 col-form-label" for="fullname">Masculino <stron style="color:red"></stron></label>
      </div>
      <div class="col-md-3 mt-3 ">
          <input class="form-control nino" type="text" value='' placeholder="Niño" />
      </div>
      <div class="col-md-4 mt-3 ">
          <input class="form-control adulto" type="text" value='' placeholder="Adulto" />
      </div>
      <div class="col-md-3 mt-3">
          <input class="form-control anciano" type="text" value='' placeholder="Anciano" />
      </div>
  </div>
  <div class="row mujer" style="max-width: 100%;">
      <div class="col-md-2 mt-3 ">
          <label class="col-md-3 col-sm-3 col-form-label" for="fullname">Femenino <stron style="color:red"></stron></label>
      </div>
      <div class="col-md-3 mt-3 ">
          <input class="form-control nino" type="text" value='' placeholder="Niño" />
      </div>
      <div class="col-md-4 mt-3 ">
          <input class="form-control adulto" type="text" value='' placeholder="Adulto" />
      </div>
      <div class="col-md-3 mt-3">
          <input class="form-control anciano" type="text" value='' placeholder="Anciano" />
      </div>
  </div>
</div>`;
  return plantillaParemetro;
}


$("#tblAnalisis").on("click",".btn_eliminar_configuracion",function(){
    let id=btoa(btoa(btoa($(this).attr("data_id_configuracion"))));

   
    swal({
      title: "¿Esta seguro que desea eliminar esta configuracion?",
      icon: "warning",
      buttons: true,
      dangerMode: true,
  })
          .then((cerrar_sesion) => {
              if (cerrar_sesion) {
                $.post("configuracion_analisis/eliminarConfiguracion/"+id,function(data){
                  if (data.codigo == 0) {
                    swal({
                      text: data.mensaje,
                      title: "Petfecto!",
                      icon: "success",
                    });
                    tblconfiguracionAnalisis.ajax.reload();
                    $(".modal_usuarios").modal("hide");
                  } else {
                    swal({
                      text: data.mensaje,
                      title: "Error!",
                      icon: "error",
                    });
                  }
                },'json');
              }
          });
   
   
  
    
      
})
