<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Area_analitica extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("Area_analitica_model");
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
            /*print_r($id_menu);
            
            print_r($restrunciones);*/
            
            
            
           if(in_array($id_menu,$restrunciones)){
                redirect("inicio_admin","refresh");
           }
        }
    }

    public function index()
    {
        
        $this->load->view("area_analitica/area_analitica");
    }


  

    public function datosTablaArea_analitica()
    {
        $resultado["data"] = $this->Area_analitica_model->cargarDatosTablaAreaAnalitica();
        echo json_encode($resultado);

       
    }

    public function getModalarea_analitica($id = 0)
    {

        $data["area"]="";

       if ($id !== 0) {
            $id = base64_decode(base64_decode(base64_decode($id)));
            $data["area"] = $this->Area_analitica_model->getAreaAnalitica($id);
        }

     

        $this->load->view("area_analitica/modal/area_analitica_crear_modificar",$data);
    }

    

    public function guardar_area_analitica()
    {
        $this->load->library('form_validation');

        $codigo = 500;
        $mensaje = 'error';


        $config = array(
            array(
                "field" => "area[]",
                "label" => "Area analitica",
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

                
               
                /*echo "<pre>";
                print_r($obj);
                echo "</pre>";
                die();*/

                if ($obj->id_area > 0) {
                    $resultado = $this->Area_analitica_model->modificar_area($obj);
                } else {
                    $resultado = $this->Area_analitica_model->insertar_area($obj);
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


    
}
