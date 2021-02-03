<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Inicio_admin extends CI_Controller
{

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

    public function __construct()
    {
        parent::__construct();
        $this->load->model("Inicio_admin_model");
    }


    public function index()
    {

            $data["menu"]=$this->Inicio_admin_model->cargarmenus();


            $this->load->view('inicio/inicio_admin',$data);
       


    }
    
}
