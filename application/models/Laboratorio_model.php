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
class Laboratorio_model extends CI_Model
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
        $this->user_id=$this->user[0]["Id"];

    }

    public function cargarDatosTablalaboratorio()
    {
        $query = "SELECT ID,NOMBRE,CORREO,RNC ,ACTIVO FROM LABORATORIO";

        $resultado = $this->db->query($query);

        $resultado = $resultado->result_array();

        log_message('ERROR', 'cargar_menus \n' . $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }





    public function getModallaboratorio($id)
    {
        $query = "SELECT ID,NOMBRE,CORREO,RNC ,ACTIVO FROM LABORATORIO WHERE ID= '$id'";

        $resultado = $this->db->query($query);

        $resultado = $resultado->result_array();

        log_message('ERROR', 'modificar_analisis \n' . $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }


    public function insertar_laboratorio($obj)
    {
        $query = "INSERT INTO LABORATORIO
        (
        NOMBRE,
        RNC,
        CORREO,
        CREADO_POR,
        CREADO_EN,
        MODIFICADO_POR,
        MODIFICADO_EN,
        ACTIVO)
        VALUES
        (
        '$obj->nombre',
        '$obj->rnc',
        '$obj->correo',
        '$this->user_id',
        now(),
        '$this->user_id',
        now(),
        '$obj->activo');";


        $resultado = $this->db->query($query);

        log_message('ERROR', 'insertar_laboratorio \n' . $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }

    public function modificar_laboratorio($obj)
    {
        $query = "UPDATE LABORATORIO set NOMBRE='$obj->nombre', RNC = '$obj->rnc',CORREO='$obj->correo',MODIFICADO_POR = '$this->user_id',
        MODIFICADO_EN=now(),ACTIVO=$obj->activo WHERE ID = '$obj->id_laboratorio'";

       

        $resultado = $this->db->query($query);



        log_message('ERROR', 'modificar_laboratorio \n' . $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }
}
