<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Pacientes extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("Pacientes_model");
    }


    public function pacientes()
    {

        $this->load->view("analisis/analisis");
    }

    public function cargarDatosPacientes()
    {
        $resultado["data"] = $this->Analisis_model->cargarDatosTablaAreaAnalisis();
        echo json_encode($resultado);
    }

    public function getModalPacientes($id = 0)
    {
        $this->load->model("Area_analitica_model");

        if ($id !== 0) {
            $id = base64_decode(base64_decode(base64_decode($id)));
            $data["info"] = $this->Analisis_model->getModalAnalisis($id);
        }

        $data["areas"] = $this->Area_analitica_model->areasAnaliticas();

        $this->load->view("analisis/modal/analisis_crear_modificar", $data);
    }





    public function guardar_pacientes()
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
    

    public function datosPorCedula($cedula)
    {   
        
        $cedula= base64_decode($cedula);
        
        $termino = trim(strtolower($_GET['term']));

        $resultado = $this->Pacientes_model->getDatosPorCedula($cedula);


        echo json_encode($resultado);
    }
}
