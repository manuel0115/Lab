<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Inicio extends CI_Controller {

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
    public function index() {



        if ($this->session->id > 0) {


            $datos_usuarios = new stdClass();


            foreach ($this->session->userdata() as $key => $value) {
                $datos_usuarios->$key = $value;
            }


            $data['datos_sesion_usuario'] = (array) $datos_usuarios;
        }


        $this->load->view("inicio/head", $data);
        $this->load->view("inicio/menu", $data);
        $this->load->view("inicio/inicio_frontend", $data);
        $this->load->view("inicio/footer", $data);
    }

    public function cargar_pagina_menu($menu) {
        $menu = base64_decode($menu);
        

        $this->load->view($menu."_frontend/" . $menu, $data);
    }


    

}
