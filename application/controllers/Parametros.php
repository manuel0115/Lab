<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Parametros extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("Parametros_model");
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
                "field" => "parametro[]",
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

    }


    
}
