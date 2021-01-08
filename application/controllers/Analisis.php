<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Analisis extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("Analisis_model");
    }


    public function analisis()
    {

        $this->load->view("analisis/analisis");
    }

    public function cargarDatosAnalisis()
    {
        $resultado["data"] = $this->Analisis_model->cargarDatosTablaAreaAnalisis();
        echo json_encode($resultado);
    }

    public function getModalanalisis($id = 0)
    {
        $this->load->model("Area_analitica_model");

        if ($id !== 0) {
            $id = base64_decode(base64_decode(base64_decode($id)));
            $data["info"] = $this->Analisis_model->getModalAnalisis($id);
        }

        $data["areas"] = $this->Area_analitica_model->areasAnaliticas();

        $this->load->view("analisis/modal/analisis_crear_modificar", $data);
    }





    public function guardar_analisis()
    {
        $this->load->library('form_validation');

        $codigo = 500;
        $mensaje = 'error';


        $config = array(
            array(
                "field" => "area",
                "label" => "Area analitica",
                "rules" => "required"
            ),
            array(
                "field" => "analisis",
                "label" => "Nombre",
                "rules" => "required"
            )

        );


        $this->form_validation->set_rules($config);

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            if ($this->form_validation->run() == TRUE) {



                $obj = new stdClass();

                foreach ($this->input->post() as $key => $value) {
                    $obj->$key = $value;
                }


                /*   print_r($obj);
                die();*/



                if ($obj->id_analisis > 0) {

                    $resultado = $this->Analisis_model->modificar_analisis($obj);
                } else {
                    $resultado = $this->Analisis_model->insertar_analisis($obj);
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
    }
    

    public function autocompletadoAnalisis()
    {
        $this->load->model('Autocompletado_model');

        $termino = trim(strtolower($_GET['term']));

        $resultado = $this->Autocompletado_model->getAnalisis($termino);


        echo json_encode($resultado);
    }
}
