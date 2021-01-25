<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Reporte_resultado extends CI_Controller
{

    private $datos_usuarios;

    public function __construct()
    {
        parent::__construct();
        $this->load->model("Reporte_resultado_model");


        $this->datos_usuarios = $this->session->userdata();
        if (!$this->datos_usuarios["ID_USUARIO"] > 0) {
            redirect('login/page_login');
        }
    }

    public function index()
    {
        //die("dd");
        $this->load->view("reporte_resultado/reporte_resultado");
    }

    public function tablaReporteResultado()
    {
        $resultado["data"] = $this->Reporte_resultado_model->getTablaReporteResultado();
        echo json_encode($resultado);
    }

    public function getModalImprimir($id)
    {


        $id = base64_decode(base64_decode(base64_decode($id)));



        $data["info_resulatdo"] = $this->Reporte_resultado_model->getInfoResultados($id);

        /*echo "<pre>";
        print_r($data["info_resulatdo"]);
        echo "</pre>";
        die();*/

        $data["orden"] = $id;


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

    public function generarDatosResultado($id)
    {

        $parametros = $this->Reporte_resultado_model->getModalresultados($id);



        $formulario = array();



        foreach ($parametros as $key => $value) {

            $value["NOMBRE_PARAMETRO"] = $value["ID_PARAMETRO_RESULTADO"] . '-' . $value["NOMBRE_PARAMETRO"];
            $analisis_sistema = $value["ID_ANALISIS"];
            $value["ID_ANALISIS"] = $value["ANALISIS_PADRE"];

            if (empty($formulario)) {
                $formulario[] = [
                    "NOMBRE_AREA" => $value["NOMBRE_AREA"],
                    "ID_ANALISIS" =>  $value["ID_ANALISIS"],
                    "NOMBRE_ANALISIS" => $value["NOMBRE_ANALSIS"],
                    "PARAMETROS" => [
                        ["nombre" => $value["NOMBRE_PARAMETRO"], "valor" => $value["VALOR"], "medida" => $value["NOMBRE_UNIDAD_MEDIDA"], "referencia" => $value["REFERENCIA"]]
                    ],
                    "COMENTARIO" => $value["COMENTARIO"],
                    "ANALISIS_SISTEMA" => $analisis_sistema
                ];
            } else {
                if (!$this->in_multi_array($value["ID_ANALISIS"], $formulario)) {

                    /*$parametros = ($value["TIENE_PARAMETROS"]) ? [["nombre" => $value["NOMBRE_PARAMETRO"], "valor" => $value["VALOR"], "medida" => $value["MEDIDA"], "referencia" => $value["REFERENCIA"]]] : [["nombre" => $value["NOMBRE_PARAMETRO"], "valor" => $value["VALOR"]]];*/

                    $formulario[] = [
                        "NOMBRE_AREA" => $value["NOMBRE_AREA"],
                        "ID_ANALISIS" =>  $value["ID_ANALISIS"],
                        "NOMBRE_ANALISIS" => $value["NOMBRE_ANALSIS"],
                        "PARAMETROS" => [
                            ["nombre" => $value["NOMBRE_PARAMETRO"], "valor" => $value["VALOR"], "medida" => $value["NOMBRE_UNIDAD_MEDIDA"], "referencia" => $value["REFERENCIA"]]
                        ],
                        "COMENTARIO" => $value["COMENTARIO"],
                        "ANALISIS_SISTEMA" => $analisis_sistema

                    ];
                } else {
                    $clave = $this->bucarKey($value["ID_ANALISIS"], $formulario);
                    $formulario[$clave]["PARAMETROS"][] = ["nombre" => $value["NOMBRE_PARAMETRO"], "valor" => $value["VALOR"], "medida" => $value["NOMBRE_UNIDAD_MEDIDA"], "referencia" => $value["REFERENCIA"]];
                }
            }
        }


        /*echo "<pre>";
        print_r($formulario);
        echo "</pre>";
        die();*/


        return $formulario;
    }

    public function in_multi_array($needle, $haystack, $strict = false)
    {
        foreach ($haystack as $item) {
            if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && $this->in_multi_array($needle, $item, $strict))) {
                return true;
            }
        }
        return false;
    }

    public function bucarKey($id, $array)
    {
        foreach ($array as $key => $val) {
            if ($val['ID_ANALISIS'] == $id) {
                return $key;
            }
        }

        return null;
    }

    public function imprimir_resultado($id)
    {
        $id = base64_decode(base64_decode(base64_decode($id)));
        $info_resulatdo = $this->Reporte_resultado_model->getInfoResultados($id);
        $formulario = $this->generarDatosResultado($id);
        $datos_organizacion = $this->session->get_userdata();


        /*$mpdf=new mPDF('utf-8', 'Letter', 0, '', 200, 0, 0, 0, 0, 0);




/*
class mPDF ([ string $mode [, mixed $format [, float $default_font_size [, string $default_font [, float $margin_left , float $margin_right , float $margin_top , float $margin_bottom , float $margin_header , float $margin_footer [, string $orientation ]]]]]])*/
        $this->load->library('Pdf');
        $pdf = new PDF("c", "letter",0,'',200,0,0,0,0,0);
        $pdf->setAutoTopMargin = 'stretch';

        $HEADER = '<div style="100%">
        
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
            $info_resulatdo[0]["NUMERO_PACIENTE"]
            . '</span></td>
                    <td>
                        <span style="font-weight:bold">Fecha Salida :</span></span>&nbsp;<span>' . $info_resulatdo[0]["FECHA_SALIDA"] . '</span>
                    </td>

                </tr>
            
                <tr>
                    <td>
                        <span style="font-weight:bold">Paciente:</span>&nbsp;<span>' . $info_resulatdo[0]["NOMBRE_PACIENTE"] . '</span>
                    </td>
                    <td>
                    <span style="font-weight:bold">Medico:</span></span>&nbsp;<span>' . $info_resulatdo[0]["MEDICO"] . '</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span style="font-weight:bold">Cedula:</span>&nbsp;<span>' . $info_resulatdo[0]["PACIENTE_CEDULA"] . '</span>
                    </td>
                    <td>
                        <span style="font-weight:bold">Cobertura :</span></span>&nbsp;<span>' . $info_resulatdo[0]["NOMBRE_REFERENCIA"] . '</span>
                    </td>
                </tr>
        <tr>
              <td><span style="font-weight:bold">Edad:</span>&nbsp;<span>' . $info_resulatdo[0]["EDAD"] . 'años
                </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <span style="font-weight:bold">Genero:</span><span>' . $info_resulatdo[0]["GENERO"] . '</span></td>
            <td>
                <span style="font-weight:bold">Procedencia :</span></span>&nbsp;<span>' . $info_resulatdo[0]["PROCEDENCIA"]
            . '</span>
            </td>
        </tr>
    </table>
</div>

<table style="width:100%;">
            <thead>
                <tr style=" background:#d6d6d6">
                    <td width="163px" style="font-weight:bold;text-align:left">Pruebas</th>
                    <th width="20%" style="text-align:center">Resultado</th>
                    <th width="20%" style="text-align:center">Unidad de medida</th>
                    <th width="20%" style="text-align:center">Referencia</th>
                    <th width="20%" style="text-align:center">Area Analitica</th>
                <tr>
            </thead>

            <tbody>
               
            </tbody>
            </table>';

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
                
</div>



        ';

        $pdf->SetHTMLHeader($HEADER);
        $pdf->setHTMLFooter($footer);

        $thead = '
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
    
<div class="reporte-body" style="margin-top:10px">';

        /*$table_header =' <table style="width:100%;">
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
                <tr>
            </tbody>
            </table>';*/




        $pdf->WriteHTML($thead);
        //$pdf->WriteHTML($table_header);
        //$pdf->WriteHTML("<pagebreak />");
        foreach ($formulario as $value) {
            $pagina_sola = array(53, 43, 174);
            $lista_parametros = "";
            $analisis_comentario = ($value['COMENTARIO']) ? '
                 <tr>
                            <th style="font-weight:normal;font-size:16px" COLSPAN="5">
                                <br><span style="font-weight:bold;width:100%">Observacion</span><br>' .
                $value['COMENTARIO'] . '
                            </th>
                        </tr>' : "";

            $cantidad_parametros = count($value["PARAMETROS"]);
            if ($cantidad_parametros > 1) {

                foreach ($value["PARAMETROS"] as $value_r) {
                    $nombre_parametro_id = explode("-", $value_r['nombre']);
                    $lista_parametros .= '<tr>
                    <th width="24%" style="font-size:18px;font-weight:normal;text-align:left;text-transform:uppercase">' .  $nombre_parametro_id[1] . '</th>
                    <th style="font-size:18px;font-weight:normal;text-align:center;ext-align:left;text-transform:uppercase">' . $value_r['valor'] . '</th>
                    <th style="font-size:18px;font-weight:normal;text-align:center;">' . $value_r['medida'] . '</th>
                    <th style="font-size:18px;font-weight:normal;text-align:center;">' . $value_r['referencia'] . '</th>
                    <th style="font-size:18px;font-weight:normal;text-align:center;">&nbsp;</th>
                <tr>';
                }

                $tabla_Analsisi_parametro = ' <table class="analisis" style="width:100%;">
            <thead>
                <tr style="">
                    <td width="20%" style="font-weight:bold;text-align:left"></th>
                    <th width="20%" style="text-align:center"></th>
                    <th width="20%" style="text-align:center"></th>
                    <th width="20%" style="text-align:center"></th>
                    <th width="20%" style="text-align:center"></th>
                <tr>
            </thead>

            <tbody>
            <tr class="filas" style="border-bottom:0.5px solid #c2c2c2">
            <th width="24%" style="font-size:18px;text-align:left;text-transform:uppercase">' . $value['NOMBRE_ANALISIS'] . '</th>
            <th>&nbsp;</th>
            <th></th>
            <th>&nbsp;</th>
            <th style="font-size:15px;font-weight:normal;text-align:center;text-transform:uppercase">' . $value["NOMBRE_AREA"] . '</th>

        <tr>' . $lista_parametros . $analisis_comentario . '
            </tbody>
            </table>';

                $pdf->WriteHTML($tabla_Analsisi_parametro);

                if (in_array($value["ANALISIS_SISTEMA"], $pagina_sola)) {
                    $pdf->WriteHTML("<pagebreak />");
                }
            } else {
                foreach ($value['PARAMETROS'] as $value_r) {



                    $tabla_Analsis_sin_parametro = '<table class="analisis" style="width:100%; ">
                    <thead>
                        <tr style="">
                            <td width="20%" style="font-weight:bold;text-align:left"></th>
                            <th width="20%" style="text-align:center"></th>
                            <th width="20%" style="text-align:center"></th>
                            <th width="20%" style="text-align:center"></th>
                            <th width="20%" style="text-align:center"></th>
                        <tr>
                    </thead>
        
                    <tbody><tr>
                    <th width="24%" style="font-size:18px;text-align:left;text-align:left;text-transform:uppercase" >' . $value['NOMBRE_ANALISIS'] . '</th>
                    <th style="font-size:18px;font-weight:normal;text-align:center;text-transform:uppercase">' . $value_r['valor'] . '</th>
                    <th  style="font-size:18px;font-weight:normal;text-align:center">' . $value_r['medida'] . '</th>
                    <th  style="font-size:18px;font-weight:normal;text-align:center">' . $value_r['referencia'] . '</th>
                    <th style="font-size:18px;font-weight:normal;text-align:center;text-transform:uppercase">' . $value["NOMBRE_AREA"] . '</th>
                </tr>' .$analisis_comentario . '
                </tbody>
                </table>';

                $pdf->WriteHTML($tabla_Analsis_sin_parametro);
                }
            }
        }

        
      














  

    
        



        

        $pdf->Output("prueba.pdf", "I");

        die();

        $contenido_tabla = "";










       





        //$pdf->WriteHTML($html2);


    }


    public function editarModalResultado($id_orden)
    {
        $id_orden = base64_decode(base64_decode(base64_decode($id_orden)));
        $data["datos_resultados"] = $this->generarDatosResultado($id_orden);




        $this->load->view("reporte_resultado/modal/editar_resultado.php", $data);
    }

    public function editarResultado()
    {
        $codigo = 500;
        $mensaje = 'error';

        $obj = new stdClass();

        foreach ($this->input->post() as $key => $value) {

            $obj->$key = $value;
        }


        /*echo "<pre>";
        print_r($obj->datos);
        echo "</pre>";
        die();*/

        $resultado = $this->Reporte_resultado_model->modificarfoResultados($obj->datos);



        if ($resultado) {
            $codigo = 0;
            $mensaje = "orden guardarda con exito";
        }

        echo json_encode(array('mensaje' => $mensaje, 'codigo' => $codigo));
    }
}
