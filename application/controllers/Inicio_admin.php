<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Inicio_admin extends MY_Controller
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
        $this->load->model('login_model');
        $this->load->library('session');
        if (!$this->ion_auth->logged_in()) {
            redirect("Login_page");
        }
    }


    public function index()
    {

        $user = $this->ion_auth->user()->row();
        $user=$user->id;

        $data["user"]=$this->login_model->getDataUsuario($user);

        $data["menus"] = $this->Inicio_admin_model->cargarmenus();
        $data["menus"] = array_map("self::remapaerar_menu", $data["menus"]);

        



        $this->load->view('inicio/inicio_admin', $data);
    }

    public function remapaerar_menu($array)
    {

        $menu = array();


        $restrunciones = explode(",", $this->menus_restringidos[0]["Menus"]);
        $sub_menu = explode(",", $array["SUB_MENUS"]);

        if ($array["MENU_PADRE"] !== "0") {

            $newsub_menu = array();


            foreach ($sub_menu as $value) {
                $item = explode("|", $value);

                if (!in_array($item[0], $restrunciones)) {
                    $newsub_menu[] = [
                        "ID_SUB_MENU" => $item[0],
                        "NOMBRE" => $item[1],
                        "ICONO" => $item[2],
                        "URL" => $item[3]
                    ];
                }
            }
            if (count($newsub_menu) > 0) {
                $menu[] = [
                    "MENU_PADRE" => $array["MENU_PADRE"],
                    "ICONO" => $array["ICON"],
                    "SUBMENU" => $newsub_menu
                    
                ];
                return array("SUBMENU"=>TRUE,$menu);
            }
            return;
        } else {



            foreach ($sub_menu as $value) {
                $item = explode("|", $value);

                if (!in_array($item[0], $restrunciones)) {
                    $menu[] = [
                        "MENU" => $item[0],
                        "NOMBRE" => $item[1],
                        "ICONO" => $item[2],
                        "URL" => $item[3]
                       
                    ];
                }

              
            }

            if(count($menu)>0){
                
                return array("SUBMENU"=>FALSE,$menu);
            }
            return;
        }

            
    }
}
