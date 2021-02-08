<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Sucursales extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->model("Sucursales_model");
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
        
        $this->load->view("sucursales/sucursales");
    }

    public function cargarDatosSucursales()
    {
        $resultado["data"] = $this->Sucursales_model->cargarDatosTablaSucursales();
        echo json_encode($resultado);
    }

    public function getModalsucursal($id = 0)
    {
        $this->load->model("Laboratorio_model");

        if ($id !== 0) {
            $id = base64_decode(base64_decode(base64_decode($id)));
            $data["info"] = $this->Sucursales_model->modalSucursales($id);
        }

        $data["laboratorio"] = $this->Laboratorio_model->cargarDatosTablalaboratorio();

        $this->load->view("sucursales/modal/sucursales", $data);
    }





    public function guardar_sucursal()
    {


  
        $this->load->library('form_validation');

        $codigo = 500;
        $mensaje = 'error';


        $config = array(
            array(
                "field" => "nombre",
                "label" => "Nombre",
                "rules" => "trim|required"
            ),
            array(
                "field" => "laboratorio",
                "label" => "Laboratorio",
                "rules" => "trim|required"
            ),
            array(
                "field" => "direcion",
                "label" => "Direcion",
                "rules" => "trim|required"
            ),
            array(
                "field" => "telefono",
                "label" => "Telefono",
                "rules" => "trim|required"
            )

        );


        $this->form_validation->set_rules($config);

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            if ($this->form_validation->run() == TRUE) {

               

                $obj = new stdClass();

                foreach ($this->input->post() as $key => $value) {
                    $obj->$key = $value;
                }

                $obj->activo=($obj->activo == "on")?"TRUE":"FALSE";

                

                if ($obj->id_sucursal > 0) {

                    $resultado = $this->Sucursales_model-> modificar_Sucursales($obj);
                } else {
                    $resultado = $this->Sucursales_model->insertar_Sucursales($obj);
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

    public function getModaTablaSucursales()
    {
        

        $this->load->view("tablas/sucursales");
    }
}
