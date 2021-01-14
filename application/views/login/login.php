<?php include('inc/login/head.php') ?>

<body class="pace-top">
    <!-- begin #page-loader -->
    <div id="page-loader" class="fade show"><span class="spinner"></span></div>
    <!-- end #page-loader -->

    <!-- begin #page-container -->
    <div id="page-container" class="fade">
        <!-- begin login -->
        <div class="login login-with-news-feed">
            <!-- begin news-feed -->
            <div class="news-feed">
                <div class="news-image" style="background-image: url(data/img/sistema/background/bg-login.jpeg)"></div>
                <div class="news-caption">
                    <h4 class="caption-title">Labotech</h4>
                    <p>
                        Sistema de administracion de Laboratorios Clinicos
                    </p>
                </div>
            </div>
            <!-- end news-feed -->
            <!-- begin right-content -->
            <div class="right-content">
                <div class="contenedor-mensaje">
                    <div class="alert alert-danger d-none fade show m-b-10">
                        Usuario o contraseña incorrecta
                    </div>

                </div>


                <!-- begin login-header -->
                <div class="login-header">
                    <div class="brand">
                        <img src="data/img/sistema/logo/labotech-logo-temp.png" width="40px" style="margin-right:10px"> <b>Labotech</b>
                        <small class="mt-2">Un producto Jtech</small>
                    </div>
                    <div class="icon">
                        <i class="fa fa-sign-in-alt"></i>
                    </div>
                </div>
                <!-- end login-header -->
                <!-- begin login-content -->
                <div class="login-content">
                    <form action="login/login_user" class="margin-bottom-0" data-parsley-validate="true" id="frm_login">
                        <div class="form-group m-b-15">
                            <input type="text" name="email" class="form-control form-control-lg" placeholder="Direccion de Email" required data-parsley-type="email" />
                        </div>
                        <div class="form-group m-b-15">
                            <input type="password" name="pass" class="form-control form-control-lg" placeholder="Contraseña" required />
                        </div>

                        <div class="login-buttons">
                            
                            <a href="javascript:;" class="btn btn-success btn-block btn-lg" id="btn_inicio_de_sesion" >Iniciar Sesion</a>
                        </div>
                        <div class="m-t-20 m-b-40 p-b-40 text-inverse">
                            ¿Olvidaste tu Contraseña? haz click <a href="registrarse">aqui</a><br>

                        </div>
                        <hr />
                        <p class="text-center text-grey-darker mb-0">
                            &copy;Labotech todos los derechos reservados <?php echo date("Y"); ?>
                        </p>
                    </form>
                </div>
                <!-- end login-content -->
            </div>
            <!-- end right-container -->
        </div>
        <!-- end login -->

        <!-- begin theme-panel -->

        <!-- end theme-panel -->
    </div>
    <!-- end page container -->

    <?php include('inc/login/footer.php') ?>