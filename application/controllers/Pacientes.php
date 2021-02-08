<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Pacientes extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("Pacientes_model");
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

        $this->load->view("pacientes/pacientes");
    }

    public function cargarDatosPacientes()
    {
        $resultado["data"] = $this->Pacientes_model->cargarDatosPacientes();
        echo json_encode($resultado);
    }

    public function getModalPacientes($id = 0)
    {
        $this->load->model("Coberturas_model");
        $this->load->model("Referencias_model");

        if ($id !== 0) {
            $id = base64_decode(base64_decode(base64_decode($id)));
            $data["info"] = $this->Pacientes_model->getModalPacientes($id);
            $data["info"][0]["FECHA_NACIMIENTO"]= date("d-m-Y", strtotime($data["info"][0]["FECHA_NACIMIENTO"]));
        }

        $data["coberturas"] = $this->Coberturas_model->cargarDatosTablaCobertura();
        $data["referencias"] = $this->Referencias_model->getDatosReferencias();

        $this->load->view("pacientes/modal/paciente_crear_editar", $data);
    }





    public function guardar_pacientes()
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
                "field" => "apellido",
                "label" => "Apellido",
                "rules" => "required"
            ),
           
            array(
                "field" => "fecha",
                "label" => "Fecha de nacimiento",
                "rules" => "required"
            ),
            
            array(
                "field" => "genero",
                "label" => "Genero",
                "rules" => "required"
            ),
            array(
                "field" => "referencia",
                "label" => "Referencia",
                "rules" => "required"
            ),
            array(
                "field" => "cobertura",
                "label" => "Cobertura",
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


                if($obj->cedula == ""){
                    $obj->cedula="NO";
                }

                
                $obj->fecha = str_replace('/', '-', $obj->fecha);
                $obj->fecha= date("Y-m-d", strtotime($obj->fecha));
               


                if ($obj->id_paciente > 0) {

                    $resultado = $this->Pacientes_model->modificar_pacientes($obj);
                } else {
                    $resultado = $this->Pacientes_model->insertar_pacientes($obj);
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

        $cedula = base64_decode($cedula);

        $termino = trim(strtolower($_GET['term']));

        $resultado = $this->Pacientes_model->getDatosPorCedula($cedula);


        echo json_encode($resultado);
    }
}
