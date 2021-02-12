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
class Permisos_model extends CI_Model
{

    public $user_id;
    public $id_laboratorio;
    function __construct(){
        $this->user_id = $this->session->userdata("ID_USUARIO");
        $this->id_laboratorio = $this->session->userdata("LABORATORIO");
    }

    public function cargarDatosTablaPermisos()
    {
        $query = "SELECT R.ID,
        G.name as NOMBRE_ROL,
        G.description as DESCRIPCION,
        R.LISTA AS LISTA_RESTRICIONES
        FROM RESTRINCIONES AS R 
        LEFT JOIN groups AS G ON G.id = R.ID_ROL";

        $resultado = $this->db->query($query);

        $resultado = $resultado->result_array();

        log_message('ERROR', 'cargar_menus \n' . $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }

    public function getMenusSinConfigurar()
    {
        $query = "SELECT SUBM.ID,
        SUBM.NOMBRE
        FROM SUBMENU AS SUBM ";

        $resultado = $this->db->query($query);

        $resultado = $resultado->result_array();

        log_message('ERROR', 'getMenusSinConfigurar \n' . $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }

    public function getRoles()
    {
        $query = "SELECT id,name from groups";

        $resultado = $this->db->query($query);

        $resultado = $resultado->result_array();

        log_message('ERROR', 'getRoles \n' . $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }

    public function getRestrinciones($id)
    {
        $query = "SELECT ID_ROL,LISTA as Menus FROM RESTRINCIONES where  ID_ROL=$id;";

        $resultado = $this->db->query($query);

        $resultado = $resultado->result_array();

        log_message('ERROR', 'getRoles \n' . $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }

    public function getRestrincionesPor($id)
    {
        $query = "SELECT ID_ROL,LISTA as Menus FROM RESTRINCIONES where  ID_ROL=$id;";

        $resultado = $this->db->query($query);

        $resultado = $resultado->result_array();

        log_message('ERROR', 'getRoles \n' . $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }


    public function existe_permisos($obj)
    {   
        $query = "SELECT ID FROM PERMISOS WHERE ROL='$obj->roles' AND MENU='$obj->menu'";

        $resultado = $this->db->query($query);

        $resultado = $resultado->result_array();
        $resultado=count($resultado);

       



        log_message('ERROR', 'existe_permisos \n' . $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        if($resultado > 0){
            return false;
        }
        
        return true;

        
    }

    public function insertar_permisos($obj)
    {

       /* if(!$this->existe_permisos($obj)){
            return array("status"=>false,"mensaje"=>"ya existen esos permiso");
        }*/

        
         
        
        
        /*$query = "INSERT INTO PERMISOS
        (
        ROL,
        MENU,
        LEER,
        ACTUALIZAR,
        ELIMINAR,
        CREADO_POR,
        CREADO_EN,
        MODIFICADO_POR,
        MODIFICADO_EN,
        ACTIVO,
        CREAR)
        VALUES
        (
        
        '$obj->roles',
        '$obj->menu',
        $obj->ver,
        $obj->actualizar,
        $obj->borrar,
        '$this->user_id',
        NOW(),
       '$this->user_id',
        NOW(),
        TRUE,
        $obj->crear);";*/

        $query="INSERT INTO RESTRINCIONES
        (
        ID_ROL,
        LISTA)
        VALUES
        (
        '$obj->roles',
        '$obj->restrinciones');";



        $resultado = $this->db->query($query);

        

        log_message('ERROR', 'insertar_permisos \n' . $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return array("status"=>$resultado);
    }

    public function modificar_permisos($obj)
    {
        $query = "UPDATE RESTRINCIONES
        SET
        LISTA = '$obj->restrinciones'
        WHERE ID = $obj->id_permisos;";




        $resultado = $this->db->query($query);



        log_message('ERROR', 'modificar_permisos \n' . $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return  array("status"=>$resultado);
    }





    public function getModalPermisos($id)
    {
        $query = "SELECT 
        R.ID,
        G.name AS NOMBRE_ROL,
        G.description AS DESCRIPCION,
        R.LISTA AS LISTA_RESTRICIONES
    FROM
        RESTRINCIONES AS R
            LEFT JOIN
        groups AS G ON G.id = R.ID_ROL WHERE R.ID='$id'";

        $resultado = $this->db->query($query);

        $resultado = $resultado->result_array();

        log_message('ERROR', 'modificar_analisis \n' . $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }


    public function insertar_analisis($obj)
    {
        $query = "INSERT INTO ANALISIS (NOMBRE,ID_AREA_ANALITICA,CREADO_POR,MODIFICADO_POR,CREADO_EN,MODIFICADO_EN,ACTIVO)VALUES";

        foreach ($obj->analisis as $value) {

            $query .= "('$value','$obj->area','$this->user_id','$this->user_id',NOW(),NOW(),TRUE),";
        }

        $query .= ";";
        $query = str_replace("),;", ");", $query);

        $resultado = $this->db->query($query);



        log_message('ERROR', 'insertar_analisis \n' . $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }

    
}
