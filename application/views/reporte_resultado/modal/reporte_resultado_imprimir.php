<?php
echo "<pre>";
print_r($info_resulatdo);
echo "</pre>";



?>
<style>
    .ui-autocomplete {
        z-index: 2147483647;
    }

    input[readonly] {
        background-color: #fff !important;
    }
</style>
<div class="modal-header">
    <!--<h4 class="modal-title"><?php echo (is_array($datos_evento)) ? "Modificar analisis" : "Agregar analsis"; ?></h4>-->
    <h4 class="modal-title">Imprimir Reporte de Resultado</h4>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <img src="data/img/reporte_logo/lara_1.jpeg" class="mx-auto d-block" alt="" style="width:250px;">
            </div>
        </div>

        <div class="row pt-3 pb-3 pl-0 mb-3" style="border-top:double black;border-bottom:double black;">

            <div class="col-md-8">
                <span class="font-weight-bolder">Orden:</span>&nbsp;<span><?php echo $info_resulatdo[0]["NUMERO_ORDEN"]?></span><br>
                <span class="font-weight-bold">Paciente:</span>&nbsp;<span><?php echo $info_resulatdo[0]["NUMERO_PACIENTE"]?></span><br>
                <span class="font-weight-bold">Nombre</span>&nbsp;<span><?php echo $info_resulatdo[0]["PACIENTE_CEDULA"]?><br>
                <span class="font-weight-bold">Cedula o Pasaporte:</span>&nbsp;<span><?php echo $info_resulatdo[0]["PACIENTE_CEDULA"]?></span><br>
                <span class="font-weight-bold">Edad:</span>&nbsp;<span><?php echo $info_resulatdo[0]["EDAD"]."años"?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <span class="font-weight-bold">Genero:</span><span><?php echo $info_resulatdo[0]["GENERO"]?></span>

            </div>

            <div class="col-md-4">
                <span class="font-weight-bolder">Fecha Entrada :</span></span>&nbsp;<span><?php echo $info_resulatdo[0]["FECHA_ENTRADA"]?></span><br>
                <span class="font-weight-bolder">Fecha Salida :</span></span>&nbsp;<span><?php echo $info_resulatdo[0]["FECHA_SALIDA"]?></span><br>
                <span class="font-weight-bolder">Medico:</span></span>&nbsp;<span><?php echo $info_resulatdo[0]["MEDICO"]?></span><br>
                <span class="font-weight-bolder">Cobertura:</span></span>&nbsp;<span><?php echo $info_resulatdo[0]["COBERTURA"]?></span><br>
                <span class="font-weight-bolder">Procedencia:</span></span>&nbsp;<span><?php echo $info_resulatdo[0]["MEDICO"]?></span><br>
            </div>

        </div>
        <?php foreach($resultado as $value){ 
            if($value['TIENE_PARAMETROS']){

        ?>
            

        <div class="row">
        <h4><?php echo $value['NOMBRE_ANALISIS'];?></h4>
            <div class="table-responsive">
                <table id="tblAnalisis" class="table table-borderless" style="width:100%;">
                 
                        <tr>
                            <th width="8%" class="text-rap" class="text-center">&nbsp;</th>
                            <th width="8%" class="text-rap" class="text-center">Resultado</th>
                            <th width="8%" class="text-rap" class="text-center">unidad de mediad </th>
                            <th width="8%" class="text-rap" class="text-center">valor der referecnia</th>
                        </tr>
                   
                    <tbody>
                        <?php foreach($value["PARAMETROS"] as $value_p){ ?>
                        <tr>
                            <td width="8%" class="text-rap" class="text-center"><span class="font-weight-bolder"><?php echo $value_p['nombre'];?></span></td>
                            <td width="8%" class="text-rap" class="text-center"><?php echo $value_p['valor'];?></td>
                            <td width="8%" class="text-rap" class="text-center"><?php echo $value_p['medida'];?></td>
                            <td width="8%" class="text-rap" class="text-center"><?php echo $value_p['referencia'];?></td>
                        </tr>
                        <?php } ?>
                        
                    <tbody>
                </table>
            </div>
            <div class="comentario">
                <h5>Observacion</h5>
                <p><?php echo $value['COMENTARIO'];?></p>
            </div>
        </div>
            <?php }else{ ?>
        <div class="row">
        <h4><?php echo $value['NOMBRE_ANALISIS'];?></h4>
            <div class="table-responsive">
                <table id="tblAnalisis" class="table table-borderless" style="width:100%;">
                 
                        <tr>
                            <th width="8%" class="text-rap" class="text-center">&nbsp;</th>
                            <th width="8%" class="text-rap" class="text-center">&nbsp;</th>
                            <th width="8%" class="text-rap" class="text-center">&nbsp;</th>
                            <th width="8%" class="text-rap" class="text-center">&nbsp;</th>
                        </tr>
                   
                    <tbody>
                        <tr>
                            <td width="8%" class="text-rap" class="text-center">Resultado:</td>
                            <td width="8%" class="text-rap" class="text-center"><span class="font-weight-bolder">POSITIVO</span></td>
                            <td width="8%" class="text-rap" class="text-center">&nbsp;</td>
                            <td width="8%" class="text-rap" class="text-center">&nbsp;</td>
                           
                        </tr>
                       
                    <tbody>
                </table>
            </div>
            <div class="comentario">
                <h5>Observacion</h5>
                <p><?php echo $value['COMENTARIO'];?></p>
            </div>
        </div>
            <?php }  
        }
        ?>




    </div>


    <div class="modal-footer">
        <a href="javascript:;" class="btn btn-success" id="btn_guardar_analisis">Guardar Cambios <i class="fa fa-save"></i></a>
        <a href="javascript:;" class="btn btn-danger" data-dismiss="modal">Cancelar <i class="fa fa-times"></i></a>
    </div>

    <script>
        var $frm_modficar_agregar_analisis = $("#frm_modficar_agregar_analisis");


        //console.log(moment().format('MMMM Do YYYY, h:mm:ss a'));
    </script>