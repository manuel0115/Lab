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
        $this->load->library("Ion_auth");
    }

    public function page_login() {

        
        if ($this->ion_auth->logged_in()) {

            redirect("inicio_admin","refresh");
        }else{
            $this->load->view("login/login");
        }

        
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

                $remember = (bool)$this->input->post('remember');

                

			if ($this->ion_auth->login($obj->email, $obj->pass, $remember))
			{
				
                $user = $this->ion_auth->user()->row();
                $user_groups = $this->ion_auth->get_users_groups()->result();

                

               

                $codigo=0;
			}
			
               
               
              



                echo json_encode(array("mensaje"=>$codigo));
                
            }
        }
    }

    public function logout() {

        $this->ion_auth->logout();

        redirect(base_url(), 'refresh');
    }

}
