<?php
//echo '<pre>';
//print_r($datos_sesion_usuario);
//echo '</pre>';
?>
<style>
    .MY_user-img{
        width: 2.25rem !important;
        height: 2.25rem;
        /*        margin: .625rem .625rem .625rem 0 !important;*/
        -webkit-border-radius: 120px !important;
        border-radius: 120px !important;
    }
    .dropdown-menu{
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,.175) !important;
    }
</style>
<div id="top-nav" class="top-nav" style="background:#fff">
    <!-- BEGIN container -->
    <div class="container">
        <div class="collapse navbar-collapse">

            <ul class="nav navbar-nav navbar-right">

                <?php if ($datos_sesion_usuario['id'] > 0) { ?> 
                    <li class="dropdown navbar-user">
                        <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <img src="<?php echo ($datos_sesion_usuario['img'] != FALSE) ? $datos_sesion_usuario['img'] : 'data/img/usuario/guest.png' ?>" alt="" class="MY_user-img"> 
                            <span class="d-none d-md-inline" class="txt-black" style="color:#000;text-transform: capitalize"><?php echo $datos_sesion_usuario['nombre_completo'] . ' ' . $datos_sesion_usuario['apellido']; ?></span> <b class="caret"></b>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="background: #fff;position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(9px, 50px, 0px);">
                            <a href="javascript:void(0);" class="dropdown-item" id="btn_admin" ><i class="fas fa-users-cog"></i>&nbsp;Admin</a>
                            <a href="javascript:void(0);" class="dropdown-item" ><i class="fa fa-cog"></i>&nbsp;Configuracion de la cuenta</a>
                            <div class="dropdown-divider"></div>
                            <a href="javascript:;" class="dropdown-item" id="btn-cerrar-sesion" class="txt-black">Cerra Sesion</a>
                        </div>
                    </li>

                <?php } else { ?> 
                    <li>
                        <a href="javascript:void(0)" id="btn_pagina_iniciar_sesion" style="color:#000;padding-top:17px;">Iniciar Sesion&nbsp;<i class="fas fa-sign-in-alt"></i></a>
                    </li>
                <?php } ?> 

            </ul>
        </div>
    </div>
    <!-- END container -->
</div>
<div class="container">


    <div id="header" class="header menu_contenedor">
        <!-- BEGIN container -->
        <div class="container pr-0">
            <!-- BEGIN header-container -->
            <div class="header-container">
                <!-- BEGIN navbar-toggle -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- END navbar-toggle -->
                <!-- BEGIN header-logo -->
                <div class="header-logo">
                    <a href="javascript:void(0);">
                        <img src="data/img/corporativo/logo-ufeji.png"  style="margin-right:10px"></img>
                        
                        <span class="brand-text">
                            <span class="text-primary">UFEJI</span>
                            <small>Educacion que Forma</small>
                        </span>
                    </a>
                </div>
                <!-- END header-logo -->
                <!-- BEGIN header-nav -->
                <div class="header-nav pull-right mr-0">
                    <div class=" collapse navbar-collapse" id="navbar-collapse">
                        <ul class="nav">
                            <li class="menu_header"><a name="inicio"  class="menu_item" href="javascript:void(0);">Inicio</a></li>
                            <li class="menu_header"><a name="eventos"  class="menu_item" href="javascript:void(0);">Eventos</a></li>
                            <li class="menu_header"><a name="noticia"  class="menu_item" href="javascript:void(0);">Noticias</a></li>
                            <li class="menu_header"><a name="acercade"  class="menu_item" href="javascript:void(0);">Acerca de Nosotro</a></li>
                            <li class="menu_header"><a name="preguntasf"  class="menu_item" href="javascript:void(0);">Preguntas freceuntes</a></li>
                            <li class="menu_header"><a name="contacto"  class="menu_item" href="javascript:void(0);">contactos</a></li>
                        </ul>
                    </div>
                </div>
                <!-- END header-nav -->
                <!-- BEGIN header-nav -->

                <!-- END header-nav -->
            </div>
            <!-- END header-container -->
        </div>
        <!-- END container -->
    </div>
    <div class="contenedor-pagina-load">