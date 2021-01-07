<?php
echo "<pre>";
print_r($datos_organizacion);
echo "</pre>";
?>

<div class="modal-header">
    <!--<h4 class="modal-title"><?php echo (is_array($datos_evento)) ? "Modificar analisis" : "Agregar analsis"; ?></h4>-->
    <h4 class="modal-title">Imprimir Reporte de Resultado</h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">
    <style>
        .ui-autocomplete {
            z-index: 2147483647;
        }

        input[readonly] {
            background-color: #fff !important;
        }
        table,th,td{
            text-align: left;
        }
    </style>



    <div style="height:100px;text-align:center"> 
        <div>
            <img src="data/img/reporte_logo/lara_1.jpeg" class="mx-auto d-block" alt="" style="width:250px;">
        </div>
    </div>
    
    <div style="border-top:double black;border-bottom:double black; display: flex"> 
        
        
        <table style="width:100%">
            <thead>
                <th style="width:50%;font-weight: normal;"> <span style="font-weight:bold">Orden:</span>&nbsp;<span><?php echo $info_resulatdo[0]["NUMERO_ORDEN"]; ?></span></th>
                                <th style="width:50%;font-weight: normal;"> <span style="font-weight:bold">Fecha Entrada :</span></span>&nbsp;<span><?php
                echo $info_resulatdo[0]
                ["FECHA_ENTRADA"]
                ?></span></th>
            </thead>
           
            <tr>
                <td><span style="font-weight:bold">Paciente #:</span>&nbsp;<span><?php
                
                echo $info_resulatdo[0]
                ["NUMERO_PACIENTE"]
                ?></span></td>
                <td>
                    <span style="font-weight:bold">Fecha Salida :</span></span>&nbsp;<span><?php
                echo $info_resulatdo[0]
                ["FECHA_SALIDA"]
                ?></span>
                </td>
                
            </tr>
            
            <tr>
                <td><span style="font-weight:bold">Paciente:</span>&nbsp;<span><?php
                echo $info_resulatdo[0]
                ["NOMBRE_PACIENTE"]
                ?></span></td>
                <td>
                    <span style="font-weight:bold">Fecha Salida :</span></span>&nbsp;<span><?php
                echo $info_resulatdo[0]
                ["MEDICO"]
                ?></span>
                </td>
            </tr>
            <tr>
                  <td><span style="font-weight:bold">Cedula:</span>&nbsp;<span><?php
                echo $info_resulatdo[0]
                ["PACIENTE_CEDULA"]
                ?></span></td>
                <td>
                    <span style="font-weight:bold">Cobertura :</span></span>&nbsp;<span><?php
                echo $info_resulatdo[0]
                ["COBERTURA"]
                ?></span>
                </td>
            </tr>
            <tr>
                  <td><span style="font-weight:bold">Edad:</span>&nbsp;<span><?php echo $info_resulatdo[0]["EDAD"] . "años"
                    ?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <span style="font-weight:bold">Genero:</span><span><?php echo $info_resulatdo[0]["GENERO"] ?></span></td>
                <td>
                    <span style="font-weight:bold">Procedencia :</span></span>&nbsp;<span><?php
                echo $info_resulatdo[0]
                ["PROCEDENCIA"]
                ?></span>
                </td>
            </tr>
        </table>
    </div>


    
    <div class="reporte-body">
        <table style="width:100%">
            <thead>
                <tr>
                    <th width="24%">&nbsp;&nbsp;</th>
                    <th>Resultado</th>
                    <th>Unidad</th>
                    <th>Referencia</th>
                <tr>
            </thead>

            <tbody>
                <tr>
                    <th width="24%">&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                <tr>





                    <?php
                    $area_Analitica = "";


                    foreach ($resultado as $value) {
                        if ($value["TIENE_PARAMETROS"]) {
                            ?>
                        <tr style="border-bottom:5px solid #c2c2c2">
                            <th width="24%" style="font-size:15px"><?php echo $value['NOMBRE_ANALISIS']; ?></th>
                            <th>&nbsp;</th>
                            <th><?php echo $value['NOMBRE_AREA']; ?></th>
                            <th>&nbsp;</th>
                        <tr>
                            <?php foreach ($value["PARAMETROS"] as $value_r) { ?>
                            <tr>
                                <th width="24%"><?php echo $value_r['nombre']; ?></th>
                                <th><?php echo $value_r['valor']; ?></th>
                                <th><?php echo $value_r['medida']; ?></th>
                                <th><?php echo $value_r['referencia']; ?></th>
                            <tr>

                            <?php } ?>
                            <?php if ($value['COMENTARIO']) { ?>        
                            <tr>
                                <th COLSPAN="4">
                                    <br><span>Observacion</span><br>
                                    <?php echo $value['COMENTARIO']; ?>
                                </th>
                            </tr>
                        <?php } ?>      
                        <tr>
                            <th width="24%">&nbsp;</th>
                            <th>&nbsp;</th>
                            <th>&nbsp;</th>
                            <th>&nbsp;</th>
                        <tr>

                        <?php } else { ?>
                        <tr  style="border-bottom:0.5px solid #c2c2c2">
                            <th width="24%">&nbsp;</th>
                            <th>&nbsp;</th>
                            <th><?php echo $value['NOMBRE_AREA']; ?></th>
                            <th>&nbsp;</th>
                        </tr>
                            <?php foreach ($value["PARAMETROS"] AS $value_r) { ?>
                            <tr>
                                <th width="24%"><?php echo $value['NOMBRE_ANALISIS']; ?></th>
                                <th><?php echo ($value_r['valor'] === "TRUE") ? "POSITIVO" : "NEGATIVO"; ?></th>
                                <th><?php echo $value_r['medida']; ?></th>
                                <th><?php echo $value_r['referencia']; ?></th>
                            </tr>
                            <?php } ?>
                            <?php if ($value['COMENTARIO']) { ?>        
                            <tr>
                                <th COLSPAN="4">
                                    <br><span>Observacion</span><br>
                                    <?php echo $value['COMENTARIO']; ?>
                                </th>
                            </tr>
                        <?php } ?>
                        <tr>
                            <th width="24%">&nbsp;</th>
                            <th>&nbsp;</th>
                            <th>&nbsp;</th>
                            <th>&nbsp;</th>
                        <tr>


                        <?php } ?>
                    <?php } ?>

            </tbody>
        </table>

        <div class="row">


            <div class="col-md-3 offset-md-9 mt-3">
                <p class="font-weight-bolder text-center" style="border-top:1px solid black">
                    <?php echo "Firma Encargada"; ?>

                </p>

            </div>




        </div>
        <div class="row mb-3 mt-3" style="border-top:1px solid black" >

            <div class="col-md-4 mt-2">
                <img src="data/img/sistema/logo/labotech-logo-temp.png" width="60px">
                <span>Labotech</span>

            </div>
            <div class="col-md-8 mt-3">
                <p class="font-weight-bolder text-center">
                    <?php
                    echo "C/" . $datos_organizacion["CALLE"] . 'NO.' . $datos_organizacion["NUMERO"] . ',' .
                    $datos_organizacion["SECTOR"] . ',' . $datos_organizacion["PROVINCIA"] . ',' . $datos_organizacion["PAIS"] . ',Telefono:' . $datos_organizacion["TELEFONOS_SUCURSALES"] . ',RNC' . $datos_organizacion["RNC"] . ',Correo:' . $datos_organizacion["CORREO_LABORATORIO"];
                    ?>
                </p>

            </div>
        </div>
    </div>
</div>


        </div>


        






























</div>


<div class="modal-footer">
    <a href="javascript:;" class="btn btn-success"  data-id-resultado="<?php echo $id_resultado; ?>" id="btn_imprimir_analisis">Imprimir Resultado <i class="fa fa-print"></i></a>
    <a href="javascript:;" class="btn btn-danger" data-dismiss="modal">Cancelar <i class="fa fa-times"></i></a>
</div>

<script>
    var $frm_modficar_agregar_analisis = $("#frm_modficar_agregar_analisis");


    //console.log(moment().format('MMMM Do YYYY, h:mm:ss a'));
</script>