<?php

defined('BASEPATH') or exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{   
    
    protected $menus_restringidos;
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Ion_auth");
        $this->load->model("Permisos_model");
        $this->load->model("Permisos_model");
        $this->load->model("Inicio_admin_model");
        

        




        if ($this->ion_auth->logged_in()) {
            $user_groups = $this->ion_auth->get_users_groups()->result();
            $this->menus_restringidos = $this->Permisos_model->getRestrinciones($user_groups[0]->id);
            
          
            
        }
    }
}
