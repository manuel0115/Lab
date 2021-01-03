$('#frm_login').parsley();
$("#btn_inicio_de_sesion").on('click', function (e) {

    

    e.preventDefault();

    var validation = $('#frm_login').parsley().validate();
    if (validation) {
        $("#btn_inicio_de_sesion").html('<span class="spinner-border spinner-border-sm"></span>  Cargado ...');
        $("#btn_inicio_de_sesion").addClass('disabled');
        var url = $('#frm_login').attr('action');

        var datos = $('#frm_login').serialize();
        $.post(url, datos, function (data) {
            $("#btn_inicio_de_sesion").html('Iniciar Sesion');
            $("#btn_inicio_de_sesion").removeClass('disabled');
            console.log(data);
            if (!data.mensaje == 0) {
                let mensaje =$(".contenedor-mensaje").children(".alert").removeClass("d-none");
                
                
            } else {
                
                
                window.location='inicio_admin';
            }
        }, 'json');
    }
});

$("#frm_login").keypress(function(e){
    if(e.which == 13){
       $("#btn_inicio_de_sesion").click();
    }
})

