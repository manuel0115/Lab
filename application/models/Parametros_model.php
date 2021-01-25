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
class Parametros_model extends CI_Model
{

    public $user_id;
    public $id_laboratorio;
    function __construct(){
        $this->user_id = $this->session->userdata("ID_USUARIO");
        $this->id_laboratorio = $this->session->userdata("LABORATORIO");
    }



    public function tablaParametros()
    {
        $query = "SELECT P.ID,P.NOMBRE as NOMBRE FROM PARAMETROS AS P;";

        $resultado = $this->db->query($query);

        $resultado = $resultado->result_array();

        log_message('ERROR', 'cargar_menus \n' . $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }

    public function getModalParametros($id)
    {
        $query = "SELECT P.ID,P.NOMBRE as NOMBRE FROM PARAMETROS AS P  WHERE P.ID='$id';";

        $resultado = $this->db->query($query);

        $resultado = $resultado->result_array();

        log_message('ERROR', 'cargar_menus \n' . $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }



    public function guardarParametro($obj)
    {
       

        $query = "INSERT INTO PARAMETROS (
        `NOMBRE`,
        `CREADO_POR`,
        `MODIFICADO_POR`,
        `ACTIVO`,
        `CREADO_EN`,
        `MODIFICADO_EN`) VALUE";

        foreach ($obj->parametro as $value) {
            $query .= "('$value','$this->user_id','$this->user_id',TRUE,NOW(),NOW()),";
        }

        $query .=";";
        
        $query = str_replace("),;",");",$query);

        $resultado = $this->db->query($query);



        log_message('ERROR', 'cargar_menus \n' . $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }

    public function actualizarParametro($obj)
    {
        $user_id = 1;
        $query = "UPDATE `PARAMETROS`
        SET
        
        `NOMBRE` = '$obj->parametro',
        `ID_ANALISIS` = '$obj->ID_ANALISIS',
        `MODIFICADO_POR` = '$this->user_id',
        `MODIFICADO_EN` = NOW()
        WHERE `ID` =  '$obj->id';";

        $resultado = $this->db->query($query);



        log_message('ERROR', 'cargar_menus \n' . $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }

    
}
