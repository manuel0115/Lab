$("#cerrar_sesion").on('click', function () {
    
    swal({
        title: "¿Esta seguro que desea cerrar sesion?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
            .then((cerrar_sesion) => {
                if (cerrar_sesion) {
                    $.post('/login/logout', function (data) {
                        window.location="inicio";

                    }, 'text');
                }
            });
});