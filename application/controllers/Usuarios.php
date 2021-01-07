<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller {

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
        $this->load->model("Usuarios_model");
    }

    public function administrar_usuario() {

        $this->load->view('usuarios/usuarios');
    }

    public function datosTablaUsuarios() {

        $resultados['data'] = $this->Usuarios_model->cargarDatosTablaUsuario();
        echo json_encode($resultados);
    }

    public function getModalUsuarios($id = 0) {


        $data['cargos'] = $this->Usuarios_model->cargarDatosCargo();
        $data['datos_usuarios'] = '';
        if ($id !== 0) {
            $id = base64_decode(base64_decode(base64_decode($id)));
            $data['datos_usuarios'] = $this->Usuarios_model->cargarDatosModalUsuario($id);
        }

        $this->load->view('usuarios/modal/modal_modificar_agregar_usuario', $data);
    }

    public function getModalCargarFoto($usuario_id, $categoria) {

        $usuario_id = base64_decode(base64_decode(base64_decode($usuario_id)));

        $data["usuario_id"] = $usuario_id;
        $data["categoria"] = $categoria;


        $this->load->view('usuarios/modal/agregar_foto_modal', $data);
    }

    public function cargarArchivoAjax() {

        $codigo = 500;
        $mensaje = 'error';

        $obj = new stdClass();

        foreach ($this->input->post() as $key => $value) {
            $obj->$key = $value;
        }

        $obj->dir = "data/img/" . $obj->categoria . "/";


        

        if (!file_exists($obj->dir)) {
            if (mkdir($obj->dir, 0777)) {
                if (chmod($obj->dir, 0777)) {

                    $fichero = $this->procesar_imgen($obj);
                }
            }
        } else {
            $fichero = $this->procesar_imgen($obj);
        }

       

        

        if ($fichero === true) {
            $codigo = 0;
            $mensaje = "Imagen guardarda con exito";
        }
//      
        echo json_encode(array('mensaje' => $mensaje, 'codigo' => $codigo));
    }


    public function procesar_imgen($obj) {
        $img = $obj->imge_B64;
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $file = $obj->dir . $obj->usuario_id . '.png';

        if(!file_exists($file)){
            $obj->nombre_fichero = $obj->usuario_id;
            $obj->categoria = numero_categoria($obj->categoria);
            $resultado = $this->Usuarios_model->agregar_info_imagen($obj);
            
        }else{
            $resultado= true;
        }
            
        


        $success = file_put_contents($file, $data);
        if ($success) {
            if (chmod($file, 0777)) {
                return true;
            }
        } else {
            return false;
        }
    }

    public function guardar_usuario() {
        $this->load->library('form_validation');

        $codigo = 500;
        $mensaje = 'error';






        $config = array(
            array(
                "field" => "nombre",
                "label" => "Nombre",
                "rules" => "required"
            ),
            array(
                "field" => "apellido",
                "label" => "Apellido",
                "rules" => "required"
            ),
            array(
                "field" => "genero",
                "label" => "Genero",
                "rules" => "required"
            ),
            array(
                "field" => "cedula",
                "label" => "Cedula",
                "rules" => "required"
            ),
            array(
                "field" => "email",
                "label" => "Correo",
                "rules" => "required"
            ),
            array(
                "field" => "telefono",
                "label" => "Telefono",
                "rules" => "required"
            ),
            array(
                "field" => "titulo",
                "label" => "Titulo",
                "rules" => "required"
            ),
            array(
                "field" => "cargo",
                "label" => "Nombre",
                "rules" => "required"
            ),
            array(
                "field" => "ocupacion",
                "label" => "Ocupacion",
                "rules" => "required"
            ),
            array(
                "filed" => "estado",
                "label" => "Estado",
                "rules" => "required"
            )
        );

        $array_passs_rules = array(
            array(
                "field" => "pass",
                "label" => "Confirmar contraseña",
                "rules" => "required"
            ),
            array(
                "field" => "pass_confirmacion",
                "label" => "Confirmar contraseña",
                "rules" => "required|matches[pass]"
            )
        );

        if ((int) $this->input->post("id") == 0) {

            $config = array_merge($config, $array_passs_rules);
        }


        $this->form_validation->set_rules($config);

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            if ($this->form_validation->run() == TRUE) {



                $obj = new stdClass();

                foreach ($this->input->post() as $key => $value) {
                    $obj->$key = $value;
                }

                $obj->estado = ($obj->estado == "S") ? "TRUE" : "FALSE";
                $obj->pass_confirmacion = password_hash($obj->pass_confirmacion, PASSWORD_DEFAULT);


                if ($obj->id > 0) {
                    $resultado = $this->Usuarios_model->editarUsuario($obj);
                } else {
                    $resultado = $this->Usuarios_model->agregarUsuario($obj);
                }


                if ($resultado) {
                    $codigo = 0;
                    $mensaje = "Usuario guardarda con exito";
                }
            } else {
                $mensaje = $this->form_validation->error_string();
            }
        }


        echo json_encode(array('mensaje' => $mensaje, 'codigo' => $codigo));
    }

}
