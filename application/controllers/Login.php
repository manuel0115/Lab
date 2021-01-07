<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct() {
        parent::__construct();

        $this->load->model('login_model');
    }

    public function page_login() {

        $this->load->view('login/login');
    }

    public function login_user() {

        $codigo= 13;

        $this->load->library('form_validation');

        $config = array(
            array(
                "field" => "email",
                "label" => "Correo",
                "rules" => "trim|required"
            )
            , array(
                "field" => "pass",
                "label" => "contraseña",
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



               
               
               $resultado = $this->login_model->loginUsuario($obj);
                
               

                if ($resultado) {
                    $

                    $datos_usuarios = array();

                    foreach ($resultado[0] as $key => $value) {
                        $datos_usuarios[$key] = $value;
                    }

                    

                    $this->session->set_userdata($datos_usuarios);
                    $codigo= 0;
                }



                echo json_encode(array("mensaje"=>$codigo));
                
            }
        }
    }

    public function logout() {

        $this->session->sess_destroy();

        $this->load->view('login/login');
        
    }

}
