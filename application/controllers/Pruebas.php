<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Pruebas extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library("Ion_auth");
       
    }

    
            
        

    public function index(){
        $id = 2;
        $data = array(
              'first_name' => 'emmanuel',
              'last_name' => 'guzman',
              'password' => '123456',
               );
        $this->ion_auth->update($id, $data);

    }

    
}
