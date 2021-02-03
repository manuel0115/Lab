<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Usuarios extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("Usuarios_model");
    }


    public function index()
    {
        
        $this->load->view("usuarios/usuarios");
    }

    public function cargarDatosUSUARIOS()
    {
        $resultado["data"] = $this->Usuarios_model->getCargarDatosUSUARIOS();
        echo json_encode($resultado);
    }

    public function getModalUsuarios($id = 0)
    {
       /* $this->load->model("Area_analitica_model");

        if ($id !== 0) {
            $id = base64_decode(base64_decode(base64_decode($id)));
            $data["info"] = $this->Analisis_model->getModalAnalisis($id);
        }*/
        $grupos=$this->ion_auth->groups()->result();

        $data["grupos"] =json_decode(json_encode($grupos),true); 

        $this->load->view("usuarios/modal/usuarios", $data);
    }

    /*public function guardarUsuarios()
    {
        $username = 'emguzman';
        $password = '123456';
        $email = 'emmanuel.011593@gmail.com';
        $additional_data = array(
                'first_name' => 'emmanuel',
                'last_name' => 'guzman',
                );
        $group = array('1'); // Sets user to admin.

        $this->ion_auth->register($username, $password, $email, $additional_data, $group);

       
    }*/




    public function guardarUsuarios()
    {
        $this->load->library('form_validation');

        $codigo = 500;
        $mensaje = 'error';

       
        $config = array(
            array(
                "field" => "nombre",
                "label" => "Nombre",
                "rules" => "required|trim"
            ),
            array(
                "field" => "apellido",
                "label" => "Apellido",
                "rules" => "required|trim"
            ),
            array(
                "field" => "email",
                "label" => "Correo",
                "rules" => "required|trim"
            ),
            array(
                "field" => "conf_email",
                "label" => "Confirmar correo",
                "rules" => "required|trim"
            ),
            array(
                "field" => "pass",
                "label" => "Contraseña",
                "rules" => "required|trim"
            ),
            array(
                "field" => "conf_pass",
                "label" => "Confirmar contraseña",
                "rules" => "required|trim"
            ),
            array(
                "field" => "cedula",
                "label" => "Cedula",
                "rules" => "required|trim"
            ),
            array(
                "field" => "genero",
                "label" => "Genero",
                "rules" => "required|trim"
            ),
            array(
                "field" => "grupo",
                "label" => "Rol",
                "rules" => "required"
            )

        );


        $this->form_validation->set_rules($config);

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            if ($this->form_validation->run() == TRUE) {

                 /*
            id_usuario: 
            nombre: manuel
            apellido: guzman
            email: emmanuel.011593@gmail.com
            conf_email: emmanuel.011593@gmail.com
            pass: 123456
            conf_pass: 123456
            cedula: 00119194306
            genero: 1
            genero: M
        
        
        
        */

               

                $obj = new stdClass();

                foreach ($this->input->post() as $key => $value) {
                    $obj->$key = $value;
                }



                if (!$obj->id_usuario > 0) {

                    $additional_data = array(
                        'first_name' => "$obj->nombre",
                        'last_name' => "$obj->apellido",
                    );

                    $group = array("$obj->grupo"); 
                    $id_usuario_creado=$this->ion_auth->register( $obj->nombre." ". $obj->apellido, $obj->pass, $obj->email, $additional_data, $group);

                    /*if($id_usuario_creado ){

                        //$obj->id_usuario_creado=

                        //$resultado = $this->Usuarios_model->InsertaUsarios($obj);
                    }*/

                } else {
                    $resultado = $this->Analisis_model->modificar_analisis($obj);
                }


                if ($id_usuario_creado) {
                    $codigo = 0;
                    $mensaje = "Evento guardardo con exito";
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

    public function emailCheck($email)
    {   
        $resultado=$this->ion_auth->email_check($email);
        
        return $resultado;
    }

   
}
