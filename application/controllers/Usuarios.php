<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Usuarios extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("Usuarios_model");
        $this->load->model("Inicio_admin_model");
        $this->load->model("Permisos_model");


        if (!$this->ion_auth->logged_in()) {
            redirect("Login_page");
        } else {

            $user_groups = $this->ion_auth->get_users_groups()->result();
            $restrunciones = $this->Permisos_model->getRestrinciones($user_groups[0]->id);
            $restrunciones = explode(",", $restrunciones[0]["Menus"]);
            $controlador = $this->router->class;
            $id_menu = $this->Inicio_admin_model->cargarmenusPorControlador($controlador);
            $id_menu = $id_menu[0]["ID"];
            //print_r($restrunciones);



            if (in_array($id_menu, $restrunciones)) {
                redirect("inicio_admin", "refresh");
            }
        }
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

        $grupos = $this->ion_auth->groups()->result();

        $data["grupos"] = json_decode(json_encode($grupos), true);

        if ($id !== 0) {

            $id = base64_decode(base64_decode(base64_decode($id)));
            $data["info"] = $this->Usuarios_model->getModalUsuarios($id);
        }


        $this->load->view("usuarios/modal/usuarios", $data);
    }


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
                "field" => "telefono",
                "label" => "Telefono",
                "rules" => "required|trim"
            ),
            array(
                "field" => "grupo",
                "label" => "Rol",
                "rules" => "required"
            )

        );

        if (!($this->input->post("grupo") == 1 || $this->input->post("grupo") == 2)) {
            array_push($config, array("field" => "id_sucursal", "label" => "Sucursal", "rules" => "required|trim"), array("field" => "idlaboratorio", "label" => "Laboratroio", "rules" => "required|trim"));
        }



        if (!($this->input->post("id_usuario") > 0)) {
            array_push(
                $config,
                array(
                    "field" => "pass",
                    "label" => "Contraseña",
                    "rules" => "required|trim"
                ),
                array(
                    "field" => "conf_pass",
                    "label" => "Confirmar contraseña",
                    "rules" => "required|trim"
                )
            );
        }



        $this->form_validation->set_rules($config);

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            if ($this->form_validation->run() == TRUE) {





                $obj = new stdClass();

                foreach ($this->input->post() as $key => $value) {
                    $obj->$key = $value;
                }

                $obj->activo = ($obj->activo == "on") ? 'TRUE' : 'FALSE';



                if (!$obj->id_usuario > 0) {

                    $additional_data = array(
                        'first_name' => "$obj->nombre",
                        'last_name' => "$obj->apellido",
                        'phone' => "$obj->telefono",
                    );

                    $group = array("$obj->grupo");

                    $id_usuario_creado = $this->ion_auth->register($obj->nombre . " " . $obj->apellido, $obj->pass, $obj->email, $additional_data, $group);

                    if ($id_usuario_creado) {

                        $obj->id_usuario_creado = $id_usuario_creado;

                        $resultado = $this->Usuarios_model->InsertaUsarios($obj);
                    }
                } else {
                    $id = $obj->id_usuario;
                    $data = array(
                        'first_name' => "$obj->nombre",
                        'last_name' => "$obj->apellido",
                        'phone' => "$obj->telefono",

                    );
                    if ($this->ion_auth->update($id, $data)) {

                        $resultado = $this->Usuarios_model->modificarUsuarios($obj);
                    }
                }


                if ($resultado) {
                    $codigo = 0;
                    $mensaje = "Usuario guardardo con exito";
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
        $resultado = $this->ion_auth->email_check($email);

        return $resultado;
    }
}
