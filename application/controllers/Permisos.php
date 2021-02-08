<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Permisos extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("Permisos_model");
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
       
        $this->load->view("permisos/permisos");
    }

    public function cargarDatosPermisos()
    {
        $resultado["data"] = $this->Permisos_model->cargarDatosTablaPermisos();
        echo json_encode($resultado);
    }

    public function getModalPermisos($id = 0)
    {
       

        if ($id !== 0) {
            $id = base64_decode(base64_decode(base64_decode($id)));
            $data["info"] = $this->Permisos_model->getModalPermisos($id);
        }

        $data["menus"] = $this->Permisos_model->getMenusSinConfigurar();
        $data["roles"] = $this->Permisos_model->getRoles();

        $this->load->view("permisos/modal/permisos", $data);
    }

    




    public function guardar_permiso()
    {
        $this->load->library('form_validation');

        $codigo = 500;
        $mensaje = 'error';

        /*if($this->input->post("id_permisos")>0){
            $config = array(
                array(
                    "field" => "id_permisos",
                    "label" => "ID PERMISOS",
                    "rules" => "required"
                )
    
            );
        }else{
            
        }*/


        

        $config = array(
            array(
                "field" => "roles",
                "label" => "Rol",
                "rules" => "required"
            ),
            array(
                "field" => "restrinciones[]",
                "label" => "Restrinciones",
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

                
               /* $obj->borrar=($obj->borrar == "on")?"TRUE":"FALSE";
                $obj->ver=($obj->ver == "on")?"TRUE":"FALSE";
                $obj->actualizar=($obj->actualizar == "on")?"TRUE":"FALSE";
                $obj->crear=($obj->crear == "on")?"TRUE":"FALSE";*/

                $obj->restrinciones=implode(",",$obj->restrinciones);
                /*echo "<pre>";
                print_r($obj);
                echo "</pre>";
                die();*/

                if ($obj->id_permisos> 0) {

                    $resultado = $this->Permisos_model->modificar_permisos($obj);
                } else {
                    
                    $resultado = $this->Permisos_model->insertar_permisos($obj);
                }


                if ($resultado["status"]) {
                    $codigo = 0;
                    $mensaje = "Permisos guardardo con exito";
                }else{
                    $mensaje = $resultado["mensaje"];
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
