<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Eventos_model
 *
 * @author manuel
 */
class Perfil_precios_model extends CI_Model
{

    public $user_id;
    public $id_laboratorio;
    public $user;
    function __construct()
    {
        $this->load->model('login_model');
        $user = $this->ion_auth->user()->row();
        $user = $user->id;

        $this->user = $this->login_model->getDataUsuario($user);
    }

    public function cargarDatosTablaConfiguracion_analisis()
    {
        $query = "SELECT DISTINCT CP.ID_ANALISISIS,A.NOMBRE,L.NOMBRE NOMBRE_LABORATORIO FROM CONFIGURACION_PAREMETROS AS CP
        JOIN ANALISIS AS A ON CP.ID_ANALISISIS = A.ID JOIN LABORATORIO AS L ON CP.LABORATORIO = L.ID";

        $resultado = $this->db->query($query);

        $resultado = $resultado->result_array();

        log_message('ERROR', 'cargar_menus \n' . $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }





    public function listaAnalisisPrecioPorReferencia($obj)
    {
        $query = "SELECT PP.ID_ANALISIS, A.NOMBRE AS NOMBRE_ANALISIS, PP.PRECIO AS PRECIO 
        FROM  PERFIL_PRECIOS AS PP JOIN ANALISIS AS A ON A.ID = PP.ID_ANALISIS
        WHERE PP.ID_ANALISIS IN ($obj->listaAnalisis) AND PP.ID_REFERENCIA = '$obj->id_referencia' and PP.ID_LABORATORIO ='". $this->user[0]["ID_LABORATORIO"] ."'";

        $resultado = $this->db->query($query);

        $resultado = $resultado->result_array();

        log_message('ERROR', 'listaAnalisisPrecioPorReferencia \n' . $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }


    
    
}
