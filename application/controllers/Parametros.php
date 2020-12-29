<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Parametros extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("Parametros_model");
    }


    public function listaParametros()
    {
        $this->load->view("parametros/parametros");
    }



    public function tablaParametros()
    {
        $resultado["data"] = $this->Parametros_model->tablaParametros();
        echo json_encode($resultado);
    }


    public function getModalparametro($id = 0)
    {   
        

        if ($id !== 0) {

            $id = base64_decode(base64_decode(base64_decode($id)));

            $data['info'] = $this->Parametros_model->getModalParametros($id);

            
        }
         
        
        $this->load->view("parametros/modal/modal_actualizar",$data);
    }


    



    public function actualizarParametros()
    {
        $this->load->library('form_validation');

        $codigo = 500;
        $mensaje = 'error';


        $config = array(
            array(
                "field" => "analisis",
                "label" => "Analisis",
                "rules" => "required"
            ),
            array(
                "field" => "parametro",
                "label" => "parametro",
                "rules" => "required"
            )
        );

        $this->form_validation->set_rules($config);

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            if ($this->form_validation->run() == TRUE) {
                

                // die("llego");

                $obj = new stdClass();

                foreach ($this->input->post() as $key => $value) {
                    $obj->$key = $value;
                }




                


                if ($obj->id > 0) {
                    $resultado = $this->Parametros_model->actualizarParametro($obj);
                } else {
                    $resultado = $this->Parametros_model->guardarParametro($obj);
                }


                if ($resultado) {
                    $codigo = 0;
                    $mensaje = "Evento guardarda con exito";
                }
            } else {
                $mensaje = $this->form_validation->error_string();
            }
        }


        echo json_encode(array('mensaje' => $mensaje, 'codigo' => $codigo));

        /* echo "<pre>";
        print_r($this->input->post());
        echo "<pre>";
        die();*/
    }


    public function index()
    {

        $data["eventos"] = $this->Eventos_model->cargarDatosTablaEventos();

        $this->load->view("eventos_frontend/eventos", $data);
    }
}
