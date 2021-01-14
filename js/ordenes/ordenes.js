var tblordenes = $("#tblAnalisis").DataTable({
  ajax: "ordenes/cargarDatosOrdenes",
  type: "POST",
  columns: [
    { data: "ORDEN", className: "text-center", orderable: false },
    { data: "PACIENTE", className: "text-center", orderable: false },
    { data: "REFERENCIA", className: "text-center", orderable: false },
    { data: "COBERTURA", className: "text-center", orderable: false },
    { data: "FECHA_ENTRADA", className: "text-center", orderable: false },
    { data: null, className: "text-center", orderable: false },
    { data: null, className: "text-center", orderable: false }
  ],
  aoColumnDefs: [
    

    {
      aTargets: [5],
      mRender: function (data, type, full) {

        let existe_Resultado=(full.RESULATADO_EXISTENTES === "1") ? "disabled":"";
        return (
          '<a href="javascript:void(0);" id="' +
          full.ORDEN +
          '"  class="btn btn-primary btn_editar_ordenes '+ existe_Resultado +'" ><i class="fa fa-edit"></i></a>'
        );
      },
    },
    {
      
      aTargets: [6],
      mRender: function (data, type, full) {

        let existe_Resultado=(full.RESULATADO_EXISTENTES === "1") ? "disabled":"";
        return (
          '<a href="javascript:void(0);" data-orde-id="' +
          full.ORDEN +
          '" data-lista-analisis="'+full.LISTA_ANALISIS+'"  class="btn btn-primary btn_crear_resultado '+ existe_Resultado +'" ><i class="fas fa-poll"></i></a>'
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
        '<span class="btn-label"><i class="fa fa-plus"></i></span>&nbsp;Crear Nueva orden',
      action: function (nButton, oConfig, oFlash) {
        $(".modal_usuarios .modal-content").load(
          "ordenes/getModalOrden",
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
    $(".dt-buttons").css("margin-left", "5px");
  },
});

$("#tblAnalisis").on("click", ".btn_editar_ordenes", function () {

  let id_orden=btoa(btoa(btoa($(this).attr("id"))));

  


  $(".modal_usuarios .modal-content").load(
    `ordenes/getModalOrden/${id_orden}`,
    function () {
      $(".modal_usuarios").modal({
        backdrop: 'static', 
        keyboard: false,
        show:true
      });
    }
  );
});

$("#tblAnalisis").on("click", ".btn_crear_resultado", function () {

  let lista_analisis=btoa($(this).attr("data-lista-analisis"));
  let orden_id=$(this).attr("data-orde-id");

  




  $(".modal_resultado .modal-content").load(
    `ordenes/getModalResultado/${lista_analisis}/${orden_id}`,
    function () {
      $(".modal_resultado").modal({
        //backdrop: 'static', 
        keyboard: false,
        show:true
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
  }
);





$(".modal_resultado").on("click","#btn_guardar_resultado",()=>{

        
  var url = $frm_guardar_resultado.attr("action");
  //var datos = $frm_guardar_resultado.serializeArray();


  datos= []
  //data-parameretros
  let comentario;
  let objeto;
  $(".parametros_valores").each(function(index,value){
  //console.log(false,' ','false');
    
    
    
    let valores=$(this).val();
    valores=valores.split("_");

    if($(this).attr("data-parameretros") === "false"){
      
      
      let valor_parametro= $(this).siblings('.switcher').children(".positivo").is(":checked");
      comentario= $(this).parent('.contenedor-checkbox').siblings(".contenedor-comentario").children("textarea").val();
  

      objeto={
            "id_analisis":valores[0],
            "id_parametro":11,
            "parametros":false,
            "positivo": valor_parametro,
            "comentario":comentario
      }

      datos.push(objeto);
     

    }else{
      let id_analisis=$(this).val();
      comentario= $(this).siblings('.contenedor-comentario-parametros').children("textarea").val();

      let contenedor_parametro=$(this).parent(".form-group.row").siblings(".contenedor-parametro");
      let objetoParametro= [];

      contenedor_parametro.each(function(index,value){

            let id_parametro=$(this).attr("data-id-parametro");
            let valor=  $(this).children(".valor").children("input[type='text']").val();
            let medida= $(this).children(".medida").children("input[type='text']").val();
            let referencia=  $(this).children(".referencia").children("input[type='text']").val();
            
            let objeto={
              "id_parametro":id_parametro,
              "valor":valor,
              "medida":medida ,
              "referencia":referencia 
          }

          objetoParametro.push(objeto)


      })

      console.log("parametros",objetoParametro);
     

      objeto={
        "id_analisis":id_analisis,
        "parametros":true,
        "lista_parametros":objetoParametro,
        "comentario":comentario,
        
      }

      

      datos.push(objeto);
      //datos.push(comentario);

      
    }

    console.log(objeto); 
    
  })


  
  var validation = $frm_guardar_resultado.parsley().validate();
  if (validation) {
      //console.log(datos);
      //let $datos =JSON.stringify(datos);
      //console.log($datos);
    
    $.post(url,{"datos":datos,"id_orden":$('#id_orden').val()},function (data) {
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
  
  
  
  
  
    

        
})



