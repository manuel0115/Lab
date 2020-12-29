$("#btn_pagina_iniciar_sesion").on("click", function () {
  window.location = "login/page_login";
});

$("#btn_admin").on("click", function () {
  window.location = "inicio_admin";
});

$("#btn-cerrar-sesion").on("click", function () {
  swal({
    title: "¿Esta seguro que desea cerrar sesion?",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  }).then((cerrar_sesion) => {
    if (cerrar_sesion) {
      $.post(
        "/login/logout",
        function (data) {
          window.location.reload();
        },
        "text"
      );
    }
  });
});

$(".menu_item").click(function () {
  var menu = $(this).attr("name");

  $(".contenedor-pagina-load").load(menu, function () {
    

  });
});
