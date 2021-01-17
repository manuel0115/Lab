<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Reporte_resultado extends CI_Controller {

    private $datos_usuarios;

    public function __construct() {
        parent::__construct();
        $this->load->model("Reporte_resultado_model");

        
        $this->datos_usuarios= $this->session->userdata();
        if(!$this->datos_usuarios["ID_USUARIO"] > 0){
            redirect('login/page_login');
        }
    }

    public function index() {
        //die("dd");
        $this->load->view("reporte_resultado/reporte_resultado");
    }

    public function tablaReporteResultado() {
        $resultado["data"] = $this->Reporte_resultado_model->getTablaReporteResultado();
        echo json_encode($resultado);
    }

    public function getModalImprimir($id) {
        $id = base64_decode(base64_decode(base64_decode($id)));


        $data["info_resulatdo"] = $this->Reporte_resultado_model->getInfoResultados($id);
        $data["id_resultado"] = $id;

        $formulario = $this->generarDatosResultado($id);




        /* echo "<pre>";
          print_r($formulario);
          echo "<pre>";
          die();


          //die("s"); */

        $data["resultado"] = $formulario;
        $data["datos_organizacion"] = $this->datos_usuarios;

        $this->load->view("reporte_resultado/modal/reporte_resultado_imprimir", $data);
    }

    public function generarDatosResultado($id) {

        $parametros = $this->Reporte_resultado_model->getModalresultados($id);

       /* echo "<pre>";
        print_r($parametros);
        echo "</pre>";
        die();*/

        /*
            [0] => Array
        (
            [ID_PARAMETRO_RESULTADO] => 1
            [ID_PARAMETRO] => 15
            [VALOR] => A
            [CONFIGURACION_PARAMETRO_ID] => 50
            [ID_UNIDAD_MEDIDA] => 3
            [NOMBRE_UNIDAD_MEDIDA] => 10E3/UL
            [NOMBRE_PARAMETRO] => (WBC) GB
            [ANALISIS_PADRE] => 1
            [ID_ANALISIS] => 53
            [NOMBRE_ANALSIS] => HEMOGRAMA
            [NOMBRE_AREA] => HEMATOLOGIA
            [ID_RESULATADO] => 1
            [ID_ORDEN] => 3
            [ID_PACIENTE] => 1
            [FECHA_NACIMIENTO] => 1993-01-15
            [EDAD] => 28
            [GENERO] => M
            [REFERENCIA] => 4.0-10.0
        )

    [1] => Array
        (
            [ID_PARAMETRO_RESULTADO] => 2
            [ID_PARAMETRO] => 16
            [VALOR] => B
            [CONFIGURACION_PARAMETRO_ID] => 51
            [ID_UNIDAD_MEDIDA] => 0
            [NOMBRE_UNIDAD_MEDIDA] => 
            [NOMBRE_PARAMETRO] => LYM%
            [ANALISIS_PADRE] => 1
            [ID_ANALISIS] => 53
            [NOMBRE_ANALSIS] => HEMOGRAMA
            [NOMBRE_AREA] => HEMATOLOGIA
            [ID_RESULATADO] => 1
            [ID_ORDEN] => 3
            [ID_PACIENTE] => 1
            [FECHA_NACIMIENTO] => 1993-01-15
            [EDAD] => 28
            [GENERO] => M
            [REFERENCIA] => 20.0-40.0
        )

        */ 

        $formulario = array();



        foreach ($parametros as $key => $value) {
            if (empty($formulario)) {
                $formulario[] = [
                    "NOMBRE_AREA" => $value["NOMBRE_AREA"],
                    "ID_ANALISIS" =>  $value["ID_ANALISIS"],
                    "NOMBRE_ANALISIS" => $value["NOMBRE_ANALSIS"],
                    "PARAMETROS" => [
                        ["nombre" => $value["NOMBRE_PARAMETRO"], "valor" => $value["VALOR"],"medida" => $value["NOMBRE_UNIDAD_MEDIDA"],"referencia" => $value["REFERENCIA"]]
                    ]
                ];
            } else {
                if (!$this->in_multi_array($value["ID_ANALISIS"], $formulario)) {

                    /*$parametros = ($value["TIENE_PARAMETROS"]) ? [["nombre" => $value["NOMBRE_PARAMETRO"], "valor" => $value["VALOR"], "medida" => $value["MEDIDA"], "referencia" => $value["REFERENCIA"]]] : [["nombre" => $value["NOMBRE_PARAMETRO"], "valor" => $value["VALOR"]]];*/

                    $formulario[] = [
                    "NOMBRE_AREA" => $value["NOMBRE_AREA"],
                    "ID_ANALISIS" =>  $value["ID_ANALISIS"],
                    "NOMBRE_ANALISIS" => $value["NOMBRE_ANALSIS"],
                    "PARAMETROS" => [
                        ["nombre" => $value["NOMBRE_PARAMETRO"], "valor" => $value["VALOR"],"medida" => $value["NOMBRE_UNIDAD_MEDIDA"],"referencia" => $value["REFERENCIA"]]
                    ]
                   
                    ];
                }else {
                    $clave = $this->bucarKey($value["ID_ANALISIS"], $formulario);
                    $formulario[$clave]["PARAMETROS"][] = ["nombre" => $value["NOMBRE_PARAMETRO"], "valor" => $value["VALOR"],"medida" => $value["NOMBRE_UNIDAD_MEDIDA"],"referencia" => $value["REFERENCIA"]];
                   

                }
            }
        }


       /* echo "<pre>";
        print_r($formulario);
        echo "</pre>";
        die();*/

        
        return $formulario;
    }

    public function in_multi_array($needle, $haystack, $strict = false) {
        foreach ($haystack as $item) {
            if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && $this->in_multi_array($needle, $item, $strict))) {
                return true;
            }
        }
        return false;
    }

    public function bucarKey($id, $array) {
        foreach ($array as $key => $val) {
            if ($val['ID_ANALISIS'] == $id) {
                return $key;
            }
        }

        return null;
    }

    public function imprimir_resultado($id) {
        $this->load->library('Pdf');

        $id = base64_decode(base64_decode(base64_decode($id)));



        $info_resulatdo = $this->Reporte_resultado_model->getInfoResultados($id);

        $formulario = $this->generarDatosResultado($id);

        $contenido_tabla = "";


        foreach ($formulario as $value) {
            $cantidad_parametros=count($value["PARAMETROS"]);
                           
            if ($cantidad_parametros > 1) {
           
                $fila = ' <tr class="filas" style="border-bottom:0.5px solid #c2c2c2">
                            <th width="24%" style="font-size:15px;text-align:left">' . $value['NOMBRE_ANALISIS'] . '</th>
                            <th>&nbsp;</th>
                            <th></th>
                            <th>&nbsp;</th>
                            <th style="font-size:12px;font-weight:normal;text-align:center">'.$value["NOMBRE_AREA"].'</th>
                        <tr>';

                foreach ($value["PARAMETROS"] as $value_r) {
                    $fila .= '<tr>
                                <th width="24%" style="font-size:12px;font-weight:normal;">' . $value_r['nombre'] . '</th>
                                <th style="font-size:12px;font-weight:normal;text-align:center;">' . $value_r['valor'] . '</th>
                                <th style="font-size:12px;font-weight:normal;text-align:center;">' . $value_r['medida'] . '</th>
                                <th style="font-size:12px;font-weight:normal;text-align:center;">' . $value_r['referencia'] . '</th>
                            <tr>';
                }
                if ($value['COMENTARIO']) {
                    $fila .= ' <tr>
                                <th style="font-weight:normal;font-size:14px" COLSPAN="4">
                                    <br><span style="font-weight:bold">Observacion</span><br>' .
                            $value['COMENTARIO'] . '
                                </th>
                            </tr>';
                }

                $contenido_tabla .= $fila . '<tr>
                    <th width="24%">&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                <tr>';
            } else {

                $fila = '<tr class="filas" style="border-bottom:0.5px solid #c2c2c2">
                            <th width="24%">&nbsp;</th>
                            <th>&nbsp;</th>
                            <th style="text-align:center"><span style="display:inline-block;border-bottom:0.5px solid #c2c2c2;font-size:10px;width:55px"></span></th>
                            <th>&nbsp;</th>
                        </tr>';

                foreach ($value['PARAMETROS'] AS $value_r) {


                  
                    $fila .= '<tr>
                    <th width="24%" style="font-size:15px;text-align:left" >' . $value['NOMBRE_ANALISIS'] . '</th>
                    <th style="font-size:12px;font-weight:normal;text-align:center">' . $value_r['valor'] . '</th>
                    <th  style="font-size:12px;font-weight:normal;text-align:center">' . $value_r['medida'] . '</th>
                    <th  style="font-size:12px;font-weight:normal;text-align:center">' . $value_r['referencia'] . '</th>
                    <th style="font-size:12px;font-weight:normal;text-align:center">'.$value["NOMBRE_AREA"].'</th>
                </tr>';
                }
                if ($value['COMENTARIO']) {
                    $fila .= ' <tr>
                                <th style="font-weight:normal;font-size:14px" COLSPAN="4">
                                    <br><span style="font-weight:bold">Observacion</span><br>' .
                            $value['COMENTARIO'] . '
                                </th>
                            </tr>';
                }




                $contenido_tabla .= $fila . '<tr>
                    <th width="24%">&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                </tr>';
            }
        }



        $data["resultado"] = $formulario;
        $data["datos_organizacion"] = $this->session->get_userdata();


        $html = $this->load->view("reporte_resultado/modal/reporte_resultado_imprimir", $data, TRUE);


        $HEADER = '
        
            <div style="text-align:center"> 
                <div>
                    <img src="data/img/reporte_logo/lara_1.jpeg" class="mx-auto d-block" alt="" style="width:250px;">
                </div>
            </div> 
    
            <div style="border-top:double black;border-bottom:double black;"> 
        
        
            <table style="width:100%;border-collapse: collapse;">
                <thead>
                   <tr>
                    <th style="width:50%;font-weight: normal;text-align:left"> <span style="font-weight:bold">Orden:</span>&nbsp;<span>' . $info_resulatdo[0]["NUMERO_ORDEN"] . '</span>
                    </th>
                    <th style="width:50%;font-weight:normal;text-align:left;"><span style="font-weight:bold">Fecha Entrada :</span></span>&nbsp;<span>' . $info_resulatdo[0]["FECHA_ENTRADA"] . '</span>
                    </th>
                   </tr>
                </thead>
                
                <tbody>
                    <tr>
                        <td><span style="font-weight:bold">Paciente #:</span>&nbsp;<span>' .
                $info_resulatdo[0]
                ["NUMERO_PACIENTE"]
                . '</span></td>
                        <td>
                            <span style="font-weight:bold">Fecha Salida :</span></span>&nbsp;<span>' . $info_resulatdo[0]
                ["FECHA_SALIDA"] . '</span>
                        </td>

                    </tr>
                
                    <tr>
                        <td>
                            <span style="font-weight:bold">Paciente:</span>&nbsp;<span>' . $info_resulatdo[0]
                ["NOMBRE_PACIENTE"] . '</span>
                        </td>
                        <td>
                        <span style="font-weight:bold">Fecha Salida :</span></span>&nbsp;<span>' . $info_resulatdo[0]["MEDICO"] . '</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span style="font-weight:bold">Cedula:</span>&nbsp;<span>' . $info_resulatdo[0]
                ["PACIENTE_CEDULA"] . '</span>
                        </td>
                        <td>
                            <span style="font-weight:bold">Cobertura :</span></span>&nbsp;<span>' . $info_resulatdo[0]
                ["COBERTURA"] . '</span>
                        </td>
                    </tr>
            <tr>
                  <td><span style="font-weight:bold">Edad:</span>&nbsp;<span>' . $info_resulatdo[0]["EDAD"] . 'años
                    </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <span style="font-weight:bold">Genero:</span><span>' . $info_resulatdo[0]["GENERO"] . '</span></td>
                <td>
                    <span style="font-weight:bold">Procedencia :</span></span>&nbsp;<span>' . $info_resulatdo[0]
                ["PROCEDENCIA"]
                . '</span>
                </td>
            </tr>
        </table>
    </div>';

        $html2 = '
        <style>
                    table{
                         border-collapse: collapse;
                    }
                    
                    th,td{
                        text-align: letf;
                       
            
                    }
                    
                    .reporte-body td{
                        text-align:center;
                    }
                    
                    
                </style> 
    
<div class="reporte-body" style="margin-top:10px">
        <table style="width:100%;">
            <thead>
                <tr style=" background:#d6d6d6">
                    <td width="20%" style="font-weight:bold;text-align:left">Pruebas</th>
                    <th width="20%" style="text-align:center">Resultado</th>
                    <th width="20%" style="text-align:center">Unidad de medida</th>
                    <th width="20%" style="text-align:center">Referencia</th>
                    <th width="20%" style="text-align:center">Area Analitica</th>
                <tr>
            </thead>

            <tbody>
                <tr >
                    <th width="24%">&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                <tr>' .
                $contenido_tabla
                . '
                

            </tbody>
            </table>
            </div>
            

  

            
';
        
       $datos_organizacion=$this->session->get_userdata();
        
        $footer='<div style="text-align:center">
                       <p style="float:right;border-top:1px solid black;display:inline-block;width:250px;text-align:center;">Firma Encargada</p>
                </div>
                
                <div style="border-top:0.6 solid #c2c2c2;margin-top:25px;padding:5px">
                
                   <table style="width:100%" >
                    <tr>
                        <td>
                             <div>&nbsp;&nbsp;&nbsp;</div>
                            
                        </td>
                        <td style="width:12%;text-align:center;" >
                             <div><span>LaboPro</span></div>
                        </td>
                        <td style="width:12%;text-align:center;" >
                             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </td>
                        
                        <td style="text-align:center;width:70%" >'.
                             "C/" . $datos_organizacion["CALLE"] . 'NO.' . $datos_organizacion["NUMERO"] . ',' .
                    $datos_organizacion["SECTOR"] . ',' . $datos_organizacion["PROVINCIA"] . ',' . $datos_organizacion["PAIS"] . ',Telefono:' . $datos_organizacion["TELEFONOS_SUCURSALES"] . ',RNC' . $datos_organizacion["RNC"] . ',Correo:' . $datos_organizacion["CORREO_LABORATORIO"]

                         .'</td>
                    </tr>
                    
                   </table>
                
                </div>
                




        ';
        /*echo $HEADER;
    
        echo $html2;
        echo $footer;
        die();*/



        $pdf = new PDF("c","letter");
        $pdf->setAutoTopMargin = 'stretch';
        $pdf->SetHTMLHeader($HEADER);
        $pdf->setHTMLFooter($footer);
       



        $pdf->WriteHTML($html2);
        
        $pdf->Output("prueba.pdf", "I");
    }

}
