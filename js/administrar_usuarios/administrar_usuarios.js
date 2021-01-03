

var $tabla_usuario = $("#tabla_administrar_usuarios").DataTable({

    "sAjaxSource": 'usuarios/datosTablaUsuarios',
    "columns": [
        {"data": null, className: "text-center"},
        {"data": null, className: "text-center"},
        {"data": null, className: "text-center"},
        {"data": "telefono", className: "text-center"},
        {"data": "correo", className: "text-center"},
        {"data": "titulo", className: "text-center"},
        {"data": "ocupacion", className: "text-center"},
        {"data": "cargo", className: "text-center"},
        {"data": null, className: 'text-center'},
    ],
    "aoColumnDefs": [
        {
            "aTargets": [0],
            "mRender": function (data, type, full) {
                return (full.estado == 1) ? '<h5><span class="label label-success">000' + full.id + '</span></h5>' : '<h5><span class="label label-danger">000' + full.id + '</span></h5>';
            }
        },
        {
            "aTargets": [1],
            "mRender": function (data, type, full) {
                var foto = (full.FOTO == null) ? "data/img/usuarios/guest.png?"+ Math.random() : full.FOTO +"?"+ Math.random();
                return '<a href="javascript:void(0);" data-categoria="usuarios" class="btn_subir_foto  img-rounded height-30" id="' + full.id + '"><div style="width:50px;"><img src="' + foto + '" style="width:100%; border-radius:7px;"></div></a>';
            }
        },
        {
            "aTargets": [2],
            "mRender": function (data, type, full) {
                return (full.genero == "M") ? '<h5><span name="' + full.id + '" class="label label-primary">' + full.nombre + '</span></h5>' : '<h5><span class="label label-pink">' + full.nombre + '</span></h5>';
            }
        },
        {
            "aTargets": [8],
            "mRender": function (data, type, full) {


                return '<a href="javascript:void(0);" id="' + full.id + '"  class="btn btn-primary btn_editar_usuario" ><i class="fa fa-edit"></a>';
            }
        }

    ],
    "dom": "<'row'<'col-sm-5'l><'col-sm-7 'Br>>" +
            "t" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
    "preDrawCallback": function () {
        $('.dt-buttons').addClass('pull-right');
    },
    "buttons": [
        {
//                            "extend": "text",
            "className": "btn btn-labeled btn-success",
            "text": '<span class="btn-label"><i class="fa fa-plus"></i></span>&nbsp;Agregar Usuarios',
            "action": function (nButton, oConfig, oFlash) {


                $('.modal_usuarios .modal-content').load('usuarios/getModalUsuarios', function () {
                    $('.modal_usuarios').modal("show");
                });


            },
            init: function (api, node, config) {
                $(node).removeClass('dt-button')
            }
        }

    ],
    "language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
    }

});





var cropo;

$("#tabla_administrar_usuarios").on("click", ".btn_subir_foto", function () {

    var usuario_id = $(this).attr("id");
    usuario_id = btoa(btoa(btoa(usuario_id)));
    var categoria = $(this).attr("data-categoria");


    $('.modal_agregar_foto_perfil .modal-content').load('usuarios/getModalCargarFoto/' + usuario_id + '/' + categoria, function () {
        $("#file_img").click();
        $("#file_img").change(function (e) {
            var reader = new FileReader();

            reader.readAsDataURL(e.target.files[0]);

            reader.onload = function () {
                cropo = $('#image_contenedor').croppie({
                    viewport: {
                        width: 300,
                        height: 300,
                        type: 'square'
                    },
                    boundary: {width: 700, height: 600},
                    mouseWheelZoom: false,
                    enableResize: false
                });

                cropo.croppie('bind', {
                    url: reader.result,

                });


                $('.modal_agregar_foto_perfil').modal("show");
            };

        });



    });


});



$(".modal_agregar_foto_perfil").on("click", ".btn_subir_imagen", function () {

    var usuario_id = $(this).attr("id");
    var categoria = $(this).attr("name");
    cropo.croppie('result', {
        type: 'base64',
        size: 'viewport',
        format: 'png'
    }).then(function (resp) {
        $.post("usuarios/cargarArchivoAjax", {imge_B64: resp, usuario_id: usuario_id, categoria: categoria}, function (data) {
            if (data.codigo == 0) {
                swal({
                    text: data.mensaje,
                    title: 'Petfecto!',
                    icon: "success",

                });

                $tabla_usuario.ajax.reload();

                $(".modal_agregar_foto_perfil").modal("hide");
            } else {
                swal({
                    text: data.mensaje,
                    title: 'Error!',
                    icon: "error",

                })

            }
        }, "json");

    });

});

$(".modal_usuarios").on("click", "#btn_guardar_cambios_agregar_usuario", function () {

    var url = $frm_modficar_agregar_usuario.attr("action");
    var datos = $frm_modficar_agregar_usuario.serialize();
    var validation = $frm_modficar_agregar_usuario.parsley().validate();
    if (validation) {


        $.post(url, datos, function (data) {
            if (data.codigo == 0) {
                swal({
                    text: data.mensaje,
                    title: 'Petfecto!',
                    icon: "success",

                });
                $tabla_usuario.ajax.reload();
                $(".modal_usuarios").modal("hide");
            } else {
                swal({
                    text: data.mensaje,
                    title: 'Error!',
                    icon: "error",

                })

            }
        }, "json")
    }

});

$("#tabla_administrar_usuarios").on("click", ".btn_editar_usuario", function () {

    var id = btoa(btoa(btoa($(this).attr('id'))));

    console.log(id);

    $('.modal_usuarios .modal-content').load('usuarios/getModalUsuarios/' + id, function () {
        $('.modal_usuarios').modal("show");
    });

})




