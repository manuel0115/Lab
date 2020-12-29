<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Eventos extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("Eventos_model");
    }

    public function admin_crud()
    {
        $this->load->view("eventos/eventos");
    }

    public function datosTablaEvento()
    {
        $resultado["data"] = $this->Eventos_model->cargarDatosTablaEventos();
        echo json_encode($resultado);
    }

    public function getModalEvento($id = 0)
    {

        if ($id !== 0) {
            $id = base64_decode(base64_decode(base64_decode($id)));
            $data["datos_evento"] = $this->Eventos_model->getDataEvento($id);
        }

        $data["categorias_eventos"] = $this->Eventos_model->getCategoriasEvento();

        $this->load->view("eventos/modal/eventos_crear_modificar", $data);
    }

    public function autocompletadoUsuario()
    {

        $termino = trim(strtolower($_GET['term']));

        $resultado = $this->Eventos_model->autocompletadoUsuario($termino);


        echo json_encode($resultado);
    }

    public function guardar_evento()
    {
        $this->load->library('form_validation');

        $codigo = 500;
        $mensaje = 'error';






        $config = array(
            array(
                "field" => "titulo",
                "label" => "Tituo",
                "rules" => "required"
            ),
            array(
                "field" => "subtitulo",
                "label" => "Subtitulo",
                "rules" => "required"
            ),
            array(
                "field" => "categoria",
                "label" => "Categoria",
                "rules" => "required"
            ),
            array(
                "field" => "id_encargado",
                "label" => "Encargado",
                "rules" => "required"
            ),
            array(
                "field" => "fecha_evento",
                "label" => "Fecha del evento",
                "rules" => "required"
            ),
            array(
                "field" => "fecha_limite",
                "label" => "Tiempo limite de inscripcion",
                "rules" => "required"
            ),
            array(
                "field" => "hora",
                "label" => "Hora",
                "rules" => "required"
            ),
            array(
                "field" => "cantidad_personas",
                "label" => "Cantidad de personas",
                "rules" => "required"
            ),
            array(
                "field" => "descripcion",
                "label" => "descripcion",
                "rules" => "required"
            )
        );

        $this->form_validation->set_rules($config);

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            if ($this->form_validation->run() == TRUE) {

                // die("llego");

                $obj = new stdClass();

                foreach ($this->input->post() as $key => $value) {
                    $obj->$key = $value;
                }

                $obj->activo = ($obj->activo == "on") ? "TRUE" : "FALSE";


                if ($obj->id > 0) {
                    $resultado = $this->Eventos_model->modificar_evento($obj);
                } else {
                    $resultado = $this->Eventos_model->insertar_evento($obj);
                }


                if ($resultado) {
                    $codigo = 0;
                    $mensaje = "Evento guardarda con exito";
                }
            } else {
                $mensaje = $this->form_validation->error_string();
            }
        }


        echo json_encode(array('mensaje' => $mensaje, 'codigo' => $codigo));

        /* echo "<pre>";
        print_r($this->input->post());
        echo "<pre>";
        die();*/
    }


    public function index()
    {

        $data["eventos"] = $this->Eventos_model->cargarDatosTablaEventos();

        $this->load->view("eventos_frontend/eventos", $data);
    }
}
