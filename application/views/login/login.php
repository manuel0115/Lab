<?php include('inc/login/head.php')?>
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
                <div class="news-image" style="background-image: url(../assets/login/img/login-bg/login-bg-11.jpg)"></div>
                <div class="news-caption">
                    <h4 class="caption-title">UFEJI</h4>
                    <p>
                        UNION DE FORMACION Y EDUCACION JURIDICA E INSTITUCIONAL
                    </p>
                </div>
            </div>
            <!-- end news-feed -->
            <!-- begin right-content -->
            <div class="right-content">
                <!-- begin login-header -->
                <div class="login-header">
                    <div class="brand">
                    <img src="../data/img/corporativo/logo-ufeji.png" width="40px" style="margin-right:10px"> <b>UFEJI</b>
                        <small>Educacion que Forma</small>
                    </div>
                    <div class="icon">
                        <i class="fa fa-sign-in-alt"></i>
                    </div>
                </div>
                <!-- end login-header -->
                <!-- begin login-content -->
                <div class="login-content">
                    <form action="../login/login_user"class="margin-bottom-0" data-parsley-validate="true" id="frm_login">
                        <div class="form-group m-b-15">
                            <input type="text" name="email" class="form-control form-control-lg" placeholder="Direccion de Email" required  data-parsley-type="email" />
                        </div>
                        <div class="form-group m-b-15">
                            <input type="password" name="pass" class="form-control form-control-lg" placeholder="Contraseña" required />
                        </div>
                        
                        <div class="login-buttons">
                            <input type="button" value="Iniciar Sesion" class="btn btn-success btn-block btn-lg" id="btn_inicio_de_sesion" />

                        </div>
                        <div class="m-t-20 m-b-40 p-b-40 text-inverse">
                            ¿No eres miembro? haz click <a href="registrarse">aqui</a> para registrarse.<br>
                            ¿No eres miembro? haz click <a href="../inicio">aqui</a> para ir a la pagina de inicio.
                        </div>
                        <hr />
                        <p class="text-center text-grey-darker mb-0">
                            &copy;Ufeji todos los derechos reservados <?php echo date("Y"); ?>
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

<?php include('inc/login/footer.php')?>    