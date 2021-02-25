<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Ordenes extends CI_Controller
{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Ordenes_model");
        $this->load->model("Inicio_admin_model");
        $this->load->model("Permisos_model");
        

        if (!$this->ion_auth->logged_in()) {
            redirect("Login_page");
        } else {

            $user_groups = $this->ion_auth->get_users_groups()->result();
            $restrunciones=$this->Permisos_model->getRestrinciones($user_groups[0]->id);
            $restrunciones=explode(",",$restrunciones[0]["Menus"]);
            $controlador = $this->router->class;
            $id_menu = $this->Inicio_admin_model->cargarmenusPorControlador($controlador);
            $id_menu = $id_menu[0]["ID"];
            //print_r($restrunciones);
            
            
            
            if(in_array($id_menu,$restrunciones)){
                redirect("inicio_admin","refresh");
            }
        }
    }


    public function index()
    {
        $data["datos_tabla"] = $this->Ordenes_model->cargarDatosOrdenes();
        
       
        $this->load->view("ordenes/ordenes",$data);
    }

    public function cargarDatosOrdenes()
    {
        $resultado["data"] = $this->Ordenes_model->cargarDatosOrdenes();
        echo json_encode($resultado);
    }

    public function getModalResultado( $id_orden)
    {
        

        $analisis = $this->Ordenes_model->buscarParametrosResulatdo($id_orden);

        $data["formulario"] = $analisis;
        $data["id_orden"] = $id_orden;

        

        $this->load->view("ordenes/modal/resultados_crear_modificar", $data);
    }



    public function guardar_orden()
    {
        $this->load->library('form_validation');

        $codigo = 500;
        $mensaje = 'error';

        $config = array(
            array(
                "field" => "",
                "label" => "Id Paciente",
                "rules" => "required"
            ),
            array(
                "field" => "referencia",
                "label" => "Referencia",
                "rules" => "required"
            ),
            array(
                "field" => "lista_analisis",
                "label" => "Lista de analisis vacia analisis",
                "rules" => "required"
            )


        );

        $this->form_validation->set_rules($config);

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            if ($this->form_validation->run() == TRUE) {




                $obj = new stdClass();

                foreach ($this->input->post() as $key => $value) {
                    
                    $obj->$key = $value;
                }

                $obj->lista_analisis = explode(",", $obj->lista_analisis);

                $obj->lista_analisis_old =explode(",", $obj->lista_analisis_old);

                $obj->valores_agregar=array_diff($obj->lista_analisis,$obj->lista_analisis_old);
                $obj->valores_eliminar=array_diff($obj->lista_analisis_old,$obj->lista_analisis);
               
            


                if ($obj->id_orden > 0) {
                    $resultado = $this->Ordenes_model->modificar_orden($obj);
                } else {

                    $resultado = $this->Ordenes_model->insertar_orden($obj);
                }

                if ($resultado["RESULTADO"]) {
                    $codigo = 0;
                    $mensaje = "orden ". $resultado["ID_ORDEN"] ." guardarda con exito";
                }
            } else {
                $mensaje = $this->form_validation->error_string();
            }
        }


        echo json_encode(array('mensaje' => $mensaje, 'codigo' => $codigo));
    }




    public function getModalOrden($id = 0)
    {


        $this->load->model("Referencias_model");
        $this->load->model("Analisis_model");

        $data["referencias"] = $this->Referencias_model->getDatosReferencias();
    
        if ($id !== 0) {
            $id = base64_decode(base64_decode(base64_decode($id)));
            $data["datos_orden"] = $this->Ordenes_model->getDataOrden($id);
        }

        $grupo = array(1,2,3);
        /*if ($this->ion_auth->in_group($grupo)) {
            
            $this->load->model("Laboratorio_model");
            $data["laboratrios"] = $this->Laboratorio_model->cargarDatosTablalaboratorio();

          
            
        }*/

       
        if ($this->ion_auth->in_group($grupo)) {
            
            $this->load->model("Sucursales_model");
            $data["sucursales"] = $this->Sucursales_model->cargarDatosTablaSucursalesPorLaboratorio();
 
        }


        $this->load->view("ordenes/modal/orden_crear_modificar", $data);
    }

    public function in_multi_array($needle, $haystack, $strict = false)
    {
        foreach ($haystack as $item) {
            if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && $this->in_multi_array($needle, $item, $strict))) {
                return true;
            }
        }
        return false;
    }
    public function bucarKey($id, $array)
    {
        foreach ($array as $key => $val) {
            if ($val['ID_ANALISIS'] == $id) {
                return $key;
            }
        }

        return null;
    }

    public function guardar_resultado()
    {


        $codigo = 500;
        $mensaje = 'error';

        $obj = new stdClass();

        foreach ($this->input->post() as $key => $value) {

            $obj->$key = $value;
        }

       

        $resultado = $this->Ordenes_model->insertar_resulatdo($obj);



        if ($resultado) {
            $codigo = 0;
            $mensaje = "orden guardarda con exito";
        }

        echo json_encode(array('mensaje' => $mensaje, 'codigo' => $codigo));
    }

    public function getModalPacientes()
    {

        $this->load->view("tablas/pacientes");
    }

    public function getOrdenesPrecio()
    {
        $this->load->model("Perfil_precios_model");

        $obj = new stdClass();

        foreach ($this->input->post() as $key => $value) {
            $obj->$key = $value;
        }

        $datos = $this->Perfil_precios_model->listaAnalisisPrecioPorReferencia($obj);

        echo json_encode($datos);
    }

   public function eliminarOrdenes($id){
        $id = base64_decode(base64_decode(base64_decode($id)));

        $resultado=$this->Ordenes_model->eliminar_Ordenes($id);


        $codigo = 500;
        $mensaje = 'error';

        if ($resultado) {
            $codigo = 0;
            $mensaje = "orden eliminada con exito";
        }

         echo json_encode(array('mensaje' => $mensaje, 'codigo' => $codigo));
        
   }


   public function actulizarLista_Precios(){
        
        $obj= new stdClass();

        foreach ($this->input->post() as $key => $value) {
            $obj->$key =$value;
        }

        $obj->lista_analisis =(!isset($obj->lista_analisis))? 0:implode(",",$obj->lista_analisis);

        
        $datos =$this->Ordenes_model->actulizarListaPrecios($obj);

        echo json_encode($datos);


   }
}
