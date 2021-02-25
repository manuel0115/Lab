<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Analisis extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("Analisis_model");
        $this->load->model("Inicio_admin_model");
        $this->load->model("Permisos_model");
        

        if (!$this->ion_auth->logged_in()) {
            redirect("Login_page");
        } else {

            $user_groups = $this->ion_auth->get_users_groups()->result();
            $restrunciones=$this->Permisos_model->getRestrinciones($user_groups[0]->id);
            $restrunciones=explode(",",$restrunciones[0]["Menus"]);
            $controlador = $this->router->class;
            $id_menu = $this->Inicio_admin_model->cargarmenusPorControlador($controlador);
            $id_menu = $id_menu[0]["ID"];
            //print_r($restrunciones);
            
            
            
            if(in_array($id_menu,$restrunciones)){
                redirect("inicio_admin","refresh");
            }
        }
    }


    public function index()
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
                "field" => "analisis[]",
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


    public function autocompletadoAnalisisConReferecia()
    {
        $this->load->model('Autocompletado_model');

        $termino = trim(strtolower($_GET['term']));

        $referencia=$this->input->get("referencia");

        $resultado = $this->Autocompletado_model->getAnalisisConReferecia($termino,$referencia);


        echo json_encode($resultado);
    }


    public function autocompletadoAnalisisConfiguracionParametros()
    {
        $this->load->model('Autocompletado_model');

        $termino = trim(strtolower($_GET['term']));

        $resultado = $this->Autocompletado_model->getAnalisisConfiguracionParametros($termino);


        echo json_encode($resultado);
    }

    
}
