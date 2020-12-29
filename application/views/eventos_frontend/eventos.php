<?php
echo "<pre>";
print_r($eventos);
echo "</pre>";
?>

<style>
    .eventos_contenedor {

        margin: 20px auto 40px auto;

    }

    .eventos {
        margin: 0 auto;
        align-items: center;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;

    }

    .evento {
        min-width: 260px;
        max-width: 260px;
        min-height: 550px;



        background-color: #f2f2f2;
        margin: 15px 5px;
        -webkit-box-shadow: 0px 2px 4px -1px rgba(0, 0, 0, 0.75);
        -moz-box-shadow: 0px 2px 4px -1px rgba(0, 0, 0, 0.75);
        box-shadow: 0px 2px 4px -1px rgba(0, 0, 0, 0.75);
        transition: all 0.5s ease;

        border-radius: 5px;


    }

    .texto {
        padding: 10px;
    }

    .evento:hover {
        -webkit-box-shadow: 0px 2px 18px -1px rgba(0, 0, 0, 0.75);
        -moz-box-shadow: 0px 2px 18px -1px rgba(0, 0, 0, 0.75);
        box-shadow: 0px 2px 18px -1px rgba(0, 0, 0, 0.75);
    }

    .marco {
        width: 100%;
        height: 50%;
        overflow: hidden;

        border-radius: 5px 5px 0px 0px;

    }

    .categoria,
    .titulo {
        font-family: 'Oswald', sans-serif;
        font-weight: 400;
        font-style: normal;
        text-transform: capitalize;

    }

    .categoria {
        line-height: 18px;
        color: #595959;
        font-size: 13px;
        margin-bottom: 10px;
        display: inline-block;
    }

    .titulo {
        line-height: 28px;
        color: #333333;
        font-size: 22px;
    }

    .categoria i {
        font-size: 1.1em;
        margin-right: 5px;

    }

    .descripcion {
        height: 170px;
        
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-md-12 my-4 border-top border-bottom pt-4">
            <h1 class="pagina_titulo text-center">Eventos de la fundacion</h1>
            <p class="text-center subtitulo_pagina">Participa de nuestros eventos</p>
        </div>
    </div>
</div>
<div class="eventos_contenedor">

    <div class="eventos">

        <!--

    <div class="evento">
            <div class="marco" style="width:100%" >
                <img src="data/img/evento/Imagen_no_disponible.png" style="width:100%" alt="">
            </div>
            <div class="texto">
                <h4 class="titulo">Titulo</h4>
                <h5 class="titulo">Subtitulo</h5>
                <p class="resumen_notica">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minus, quaerat, numquam, beatae, voluptatibus soluta voluptas dolor dignissimos illum illo consequatur laudantium id vero labore voluptate molestias ex blanditiis dolorem saepe explicabo hic atque rerum optio fugit accusamus ut ullam expedita natus ducimus maxime sequi eaque quas harum quisquam quam quibusdam?</p> 
            </div>
        </div>

-->

        <?php foreach ($eventos as $value) { ?>
            <div class="evento">
                <div class="marco">
                    <img src="<?php echo ($value["FOTO"] == FALSE) ? 'data/img/evento/Imagen_no_disponible.png' : $value['FOTO'] . $value['ID'] . '.png'; ?>" style="width:100%" alt="">
                </div>
                <div class="texto">
                    <h5 class="titulo"><?php echo $value["TITULO"] ?></h5>
                    <span class="categoria"><i class="fas <?php echo $value["ICONO"] ?>"></i><?php echo $value["CATEGORIA"] ?></span><br>

                    <!-- <span class="categoria"><i class="fas fa-calendar-alt"></i><?php echo $value["CATEGORIA"] ?></span><br>-->
                    <p class="descripcion"><?php echo $value["DESCRIPCION"]; ?></p>
                    <span class="categoria detalle"><i class="fas fa-calendar-alt"></i>Fecha: <?php echo $value["FECHA_EVENTO"] ?></span><br>
                    <span class="categoria detalle"><i class="fas fa-calendar-times"></i>Cierre de inscripcion: <?php echo $value["FECHA_LIMITE"] ?></span><br>
                    <span class="categoria detalle"><i class="fas fa-clock"></i>HORA: 8:00PM</span><br>
                    <div class="detalles">
                        <!--<a href="javascript:void(0);" class="inscipcion">Inscribirse</a>-->
                        <a href="#" class="btn  btn-primary btn-block">
                            <span class="d-flex align-items-center text-left">
                                <i class="fas fa-check fa-1x mr-3 text-white"></i>
                                <span>
                                    <span class="d-block mb-n1"><b>Inscribirse</b></span>
                                </span>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>


</div>