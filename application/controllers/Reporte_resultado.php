<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Reporte_resultado extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("Reporte_resultado_model");
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
        $parametros= $this->Reporte_resultado_model->getModalresultados($id);
       $data["info_resulatdo"]=$this->Reporte_resultado_model->getInfoResultados($id);
        
        $formulario= array();
        
        foreach($parametros as $key => $value){
            if(empty($formulario)){
                $formulario[]=[
                    "ID_ANALISIS_RESULTADO"=>$value["ID_ANALISIS_RESULTADO"],
                    "NOMBRE_ANALISIS"=>$value["NOMBRE_ANALISIS"],
                    "TIENE_PARAMETROS"=>$value["TIENE_PARAMETROS"],
                    "PARAMETROS"=>[["nombre"=>$value["NOMBRE_PARAMETRO"],"valor"=>$value["VALOR"]]],
                    "COMENTARIO"=>$value["COMENTARIO"]
                ];
            }else{
                if(!$this->in_multi_array($value["ID_ANALISIS_RESULTADO"],$formulario)){
                    
                    $parametros=($value["TIENE_PARAMETROS"])?[["nombre"=>$value["NOMBRE_PARAMETRO"],"valor"=>$value["VALOR"],"medida"=>$value["MEDIDA"],"referencia"=>$value["REFERENCIA"]]]:[["nombre"=>$value["NOMBRE_PARAMETRO"],"valor"=>$value["VALOR"]]];
                    $formulario[]=[
                        "ID_ANALISIS_RESULTADO"=>$value["ID_ANALISIS_RESULTADO"],
                        "NOMBRE_ANALISIS"=>$value["NOMBRE_ANALISIS"],
                        "TIENE_PARAMETROS"=>$value["TIENE_PARAMETROS"],
                        "PARAMETROS"=>$parametros,
                        "COMENTARIO"=>$value["COMENTARIO"]
                    ];
                }else{
                    $clave=$this->bucarKey($value["ID_ANALISIS_RESULTADO"],$formulario);
                    $formulario[$clave]["PARAMETROS"][]=["nombre"=>$value["NOMBRE_PARAMETRO"],"valor"=>$value["VALOR"],"medida"=>$value["MEDIDA"],"referencia"=>$value["REFERENCIA"]];
                    
                }
                
            }
        }

       
       
   
         /*echo "<pre>";
         print_r($formulario);
         echo "<pre>";
         die();
        
       
        //die("s");*/

        $data["resultado"] = $formulario;
        $data["datos_organizacion"] = $this->session->get_userdata();
        

        $this->load->view("reporte_resultado/modal/reporte_resultado_imprimir", $data);
    }


    public function getModalResultado($lista_analisis,$id_orden)
    {
        $lista_analisis = str_replace("|", ",", base64_decode($lista_analisis));

        $parametros = $this->Ordenes_model->buscarParametrosResulatdo($lista_analisis);

       // echo($this->in_multi_array("60",$parametros))?"loencontro":"no lo encontro";
        
        $formulario= array();

        foreach($parametros as $key => $value){
            if(empty($formulario)){
                $formulario[]=array(
                        "ID_ANALISIS"=>$value["ID_ANALISIS"],
                        "NOMBRE_ANALISIS"=>$value["NOMBRE_ANALISIS"],
                        "PARAMETROS"=>$value["PARAMETROS"],
                        "NOMBRE_PARAMETRO"=>[$value["NOMBRE_PARAMETRO"]]
                    );
            }else{
                if(!$this->in_multi_array($value["ID_ANALISIS"],$formulario)){
                    $formulario[]=array(
                        "ID_ANALISIS"=>$value["ID_ANALISIS"],
                        "NOMBRE_ANALISIS"=>$value["NOMBRE_ANALISIS"],
                        "PARAMETROS"=>$value["PARAMETROS"],
                        "NOMBRE_PARAMETRO"=>[$value["NOMBRE_PARAMETRO"]]
                    );
                }else{
                    $clave=$this->bucarKey($value["ID_ANALISIS"],$formulario);
                    $formulario[$clave]["NOMBRE_PARAMETRO"][]=$value["NOMBRE_PARAMETRO"];
                        
                        
                    
                } 
            }
        }
        
        $data["formulario"]=$formulario;
        $data["id_orden"]=$id_orden;


        
        
        
       

        $this->load->view("ordenes/modal/resultados_crear_modificar", $data);
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

    public function bucarKey($id, $array) {
        foreach ($array as $key => $val) {
            if ($val['ID_ANALISIS_RESULTADO'] == $id) {
                return $key;
            }
        }

        return null;
     }
}
