<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Laboratorio extends CI_Controller
{

    public function __construct()
    {   
        parent::__construct();
        $this->load->model("Laboratorio_model");
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
        
        $this->load->view("laboratorio/laboratorio");
    }

    public function cargarDatoslaboratorio()
    {
        $resultado["data"] = $this->Laboratorio_model->cargarDatosTablalaboratorio();
        echo json_encode($resultado);
    }

    public function getModaLaboratorio($id = 0)
    {
       

        if ($id !== 0) {
            $id = base64_decode(base64_decode(base64_decode($id)));
            $data["info"] = $this->Laboratorio_model->getModallaboratorio($id);
        }

        

        $this->load->view("laboratorio/modal/laboratorio", $data);
    }





    public function guardar_laboratorio()
    {
        $this->load->library('form_validation');

        $codigo = 500;
        $mensaje = 'error';


        $config = array(
            array(
                "field" => "nombre",
                "label" => "Nombre",
                "rules" => "required"
            ),
            array(
                "field" => "correo",
                "label" => "Correo",
                "rules" => "required"
            ),
            array(
                "field" => "rnc",
                "label" => "RNC",
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

                $obj->activo=($obj->activo == "on")?'TRUE':'FALSE';

                if ($obj->id_laboratorio > 0) {

                    $resultado = $this->Laboratorio_model->modificar_laboratorio($obj);
                } else {
                    $resultado = $this->Laboratorio_model->insertar_laboratorio($obj);
                }


                if ($resultado) {
                    $codigo = 0;
                    $mensaje = "Laboratorio guardardo con exito";
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
