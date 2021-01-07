<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Ordenes extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("Ordenes_model");
    }


    public function ordenes()
    {

        $this->load->view("ordenes/ordenes");
    }

    public function cargarDatosOrdenes()
    {
        $resultado["data"] = $this->Ordenes_model->cargarDatosOrdenes();
        echo json_encode($resultado);
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



    public function guardar_orden()
    {
        $this->load->library('form_validation');

        $codigo = 500;
        $mensaje = 'error';

        $config = array(
            array(
                "field" => "",
                "label" => "Id Paciente",
                "rules" => "required"
            ),
            array(
                "field" => "referencia",
                "label" => "Referencia",
                "rules" => "required"
            ),
            array(
                "field" => "listado_analisis[]",
                "label" => "Lista analisis",
                "rules" => "required"
            )


        );

        $this->form_validation->set_rules($config);

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            if ($this->form_validation->run() == TRUE) {




                $obj = new stdClass();

                foreach ($this->input->post() as $key => $value) {
                    if ($key === "listado_analisis") {

                        $value = implode("|", $value);
                    }
                    $obj->$key = $value;
                }

                /* echo"<pre>";
                print_r($obj);
                echo"</pre>";
                die();*/

                $obj->activo = ($obj->activo == "on") ? "TRUE" : "FALSE";


                if ($obj->id_orden > 0) {
                    $resultado = $this->Ordenes_model->modificar_orden($obj);
                } else {


                    $resultado = $this->Ordenes_model->insertar_orden($obj);
                }

                if ($resultado) {
                    $codigo = 0;
                    $mensaje = "orden guardarda con exito";
                }
            } else {
                $mensaje = $this->form_validation->error_string();
            }
        }


        echo json_encode(array('mensaje' => $mensaje, 'codigo' => $codigo));
    }




    public function getModalOrden($id = 0)
    {


        $this->load->model("Referencias_model");
        $this->load->model("Analisis_model");

        $data["referencias"] = $this->Referencias_model->getDatosReferencias();
        $data["lista_analisis"] = $this->Analisis_model->cargarDatosTablaAreaAnalisis();


        if ($id !== 0) {
            $id = base64_decode(base64_decode(base64_decode($id)));
            $data["datos_orden"] = $this->Ordenes_model->getDataOrden($id);
        }


        $this->load->view("ordenes/modal/orden_crear_modificar", $data);
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
            if ($val['ID_ANALISIS'] == $id) {
                return $key;
            }
        }

        return null;
     }

     public function guardar_resultado() {


        $codigo = 500;
        $mensaje = 'error';

        $obj = new stdClass();

                foreach ($this->input->post() as $key => $value) {
                   
                    $obj->$key = $value;
                }

                $resultado = $this->Ordenes_model->insertar_resulatdo($obj);

                

                if ($resultado) {
                    $codigo = 0;
                    $mensaje = "orden guardarda con exito";
                }

                echo json_encode(array('mensaje' => $mensaje, 'codigo' => $codigo));
                
     }
}
