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
class Sucursales_model extends CI_Model
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

    public function cargarDatosTablaSucursales()
    {
        $query = "SELECT
        S.ID, 
        S.NOMBRE,
        S.LABORATORIO AS ID_LABORATORIO,
        L.NOMBRE LABORATORIO_NOMBRE,
        L.CORREO,
        S.DIRECCION,
        S.TELEFONOS,
        S.ACTIVO
        FROM SUCURSALES AS S
        LEFT JOIN LABORATORIO AS L ON L.ID = S.LABORATORIO
        ;";

        $resultado = $this->db->query($query);

        $resultado = $resultado->result_array();

        log_message('ERROR', 'cargar_menus \n' . $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }

    



    public function modalSucursales($id)
    {
       
        $query = "SELECT
        S.ID, 
        S.NOMBRE,
        L.NOMBRE LABORATORIO_NOMBRE,
        S.LABORATORIO ID_LABORATORIO,
        L.CORREO,
        S.DIRECCION,
        S.TELEFONOS,
        S.ACTIVO
        FROM SUCURSALES AS S
        LEFT JOIN LABORATORIO AS L ON L.ID = S.LABORATORIO
        WHERE S.ID= '$id';";

        $resultado = $this->db->query($query);

        $resultado = $resultado->result_array();

        log_message('ERROR', 'modificar_analisis \n' . $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }


    public function insertar_Sucursales($obj)
    {
        $query = "INSERT INTO SUCURSALES
        (
        NOMBRE,
        LABORATORIO,
        DIRECCION,
        TELEFONOS,
        CREADO_EN,
        CREADO_POR,
        MODIFICADA_EN,
        MODIFICADA_POR,
        ACTIVO)
        VALUES
        (
        '$obj->nombre',
        '$obj->laboratorio',
        '$obj->direcion',
        '$obj->telefono',
        now(),
        '$this->user_id',
        now(),
        '$this->user_id',
        $obj->activo);";

        

        $resultado = $this->db->query($query);



        log_message('ERROR', 'insertar_analisis \n' . $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }

    public function modificar_Sucursales($obj)
    {

       
        $query = "UPDATE SUCURSALES
        SET
        NOMBRE = '$obj->nombre',
        LABORATORIO = '$obj->laboratorio',
        DIRECCION = '$obj->direcion',
        TELEFONOS = '$obj->telefono',
        CREADO_EN = now(),
        CREADO_POR = '$this->user_id',
        MODIFICADA_EN = now(),
        MODIFICADA_POR = '$this->user_id',
        ACTIVO = $obj->activo
        WHERE ID = '$obj->id_sucursal';";

        $resultado = $this->db->query($query);



        log_message('ERROR', 'modificar_analisis \n' . $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }

    public function cargarDatosTablaSucursalesPorLaboratorio()
    {
        $query = "SELECT
        S.ID, 
        S.NOMBRE,
        S.LABORATORIO AS ID_LABORATORIO
        FROM SUCURSALES AS S";

        if ($this->ion_auth->in_group(array(3))){
            $query .= " WHERE  S.LABORATORIO ='". $this->user[0]["ID_LABORATORIO"]."'";
        }

       

        $resultado = $this->db->query($query);

        $resultado = $resultado->result_array();

        log_message('ERROR', 'cargar_menus \n' . $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }
}
