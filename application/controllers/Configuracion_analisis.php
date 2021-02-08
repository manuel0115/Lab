<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Configuracion_analisis extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("Configuracion_analisis_model");
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
        $this->load->view("configuracion_analisis/configuracion_analisis");
    }

    public function cargarDatosConfiguracion_analisis()
    {
        $resultado["data"] = $this->Configuracion_analisis_model->cargarDatosTablaConfiguracion_analisis();
        echo json_encode($resultado);
    }

    public function getModalConfiguracionanalisis($id = 0,$modo=0)
    {
        $this->load->model("Parametros_model");
        $this->load->model("Medidas_model");

        $data["lista_parametros"]=$this->Parametros_model->tablaParametros();
        $data["lista_medidad"]=$this->Medidas_model->cargarDatosTablaMedida();
        

        if ($id !== 0) {
            $modo=base64_decode($modo);
            
            $id = base64_decode(base64_decode(base64_decode($id)));
            $data["info"] = $this->Configuracion_analisis_model->getConfiguracionesModal($id);
            $data["modo"] = $modo;

          

            
        }

        

        $this->load->view("configuracion_analisis/modal/configuracion_analisis", $data);
    }

    public function autocompletadoParametros()
    {
        $this->load->model("Autocompletado_model");
        

        $parametros = trim(strtolower($_GET['term']));

        $resultado = $this->Autocompletado_model->getParametros($parametros);


        echo json_encode($resultado);
    }





    public function guardar_configuracion()
    {
        $this->load->library('form_validation');

        $codigo = 500;
        $mensaje = 'error';
       
        $config = array(
            
            array(
                "field" => "id_analisis",
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

               


                if ($obj->id_analisis_confifuracion == "E") {

                    $resultado = $this->Configuracion_analisis_model->modificar_configuracion($obj);
                } else {
                    $resultado = $this->Configuracion_analisis_model->insertar_configuracion($obj);
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

    public function eliminarConfiguracion($id=0)
    {
        $codigo=500;

        $mensaje="";
        
        if ($id !== 0) {
            $id = base64_decode(base64_decode(base64_decode($id)));

            
            
            $resultado=$this->Configuracion_analisis_model->eliminarConfiguracion($id);

            if($resultado){
                $codigo=0;
                $mensaje=" configuracion elimianda con exito";
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
