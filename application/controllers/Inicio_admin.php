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
    public function index()
    {

        /**
         * 
         * 
         * 
         * 
         *   [__ci_last_regenerate] => 1610858851
    [ID_USUARIO] => 1
    [NOMBRE_USUARIO] => emmanuel guzman
    [CORREO] => emmanuel.011593@gmail.com
    [PASSWORD] => $2y$10$pl3tMWwd8fwYDOi998Gwlevkh39uzDn52UOa.0KNxiBisJjGibUWG
    [ROL] => 1
    [ID_SUSCURSAL] => 1
    [NOMBRE_SUCURSAL] => LA ROMANA
    [TELEFONOS_SUCURSALES] => 8093493151
    [NOMBRE_LABORATORIO] => Laboratorios Lara
    [RNC] => 131-364187
    [CORREO_LABORATORIO] => laralaboratorioclinico@gmail.com
    [LABORATORIO] => 1
    [CALLE] => AMIN ABEL HASBUN 
    [NUMERO] => 36
    [SECTOR] => VILLA HERMOSA
    [PROVINCIA] => LA ROAMAN
    [PAIS] => REPUBLICA DOMINICANA
         * 
         if(){
             echo $this->session->ID_USUARIO;
             die("haysession");
            }else{
                echo "mp hay";
            }
            */

        if ($this->session->ID_USUARIO > 0) {


            






           
            $this->load->view('inicio/inicio_admin');
        }else{
            header("location:".base_url());
        }


    }
    
}
