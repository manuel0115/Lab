<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Pruebas extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library("Ion_auth");
        $this->load->model("Pruebas_model");
       
    }

    
            
        

    public function index(){
        
        echo "<pre>";
        print_r($this->Pruebas_model->funcionPrueba());
        echo "<pre>";
        die();
        /*$id = 2;
        $data = array(
              'first_name' => 'emmanuel',
              'last_name' => 'guzman',
              'password' => '123456',
               );
        $this->ion_auth->update($id, $data);*/

    }

    public function actualizar_usuarios(){
        $id = 10;
        $data = array(
              'first_name' => 'emmanuel',
              'last_name' => 'guzman',
              'password' => '123456',
               );
        $this->ion_auth->update($id, $data);

    }

    
}
