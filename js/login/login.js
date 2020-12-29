$('#frm_login').parsley();
$("#btn_inicio_de_sesion").on('click', function (e) {
    e.preventDefault();

    var validation = $('#frm_login').parsley().validate();
    if (validation) {
        var url = $('#frm_login').attr('action');

        var datos = $('#frm_login').serialize();
        $.post(url, datos, function (data) {
            if (data == 0) {
                swal("Usuario y/o Contraseña Incorrectos",{
                    closeOnClickOutside: true,
                    button:false,
                    icon:"error"
                });
                
            } else {
                
                
                window.location='/inicio';
            }
        }, 'json');
    }
});

$("#frm_login").keypress(function(e){
    if(e.which == 13){
       $("#btn_inicio_de_sesion").click();
    }
})

