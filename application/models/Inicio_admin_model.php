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
class Inicio_admin_model extends CI_Model
{

    public $user_id;
    public $id_laboratorio;
    function __construct(){
        $this->user_id = $this->session->userdata("ID_USUARIO");
        $this->id_laboratorio = $this->session->userdata("LABORATORIO");
    }

    public function cargarmenus()
    {
        $query = "SELECT 
        GROUP_CONCAT(CONCAT(SUB.ID,'|',SUB.ICONO,'-|,SUB.NOMBRE,'|',SUB.URL)) AS SUBMENUS,
        M.ID AS ID_MENU_PADRE,
        M.NOMBRE AS NOMBRE_MENU_PADRE,
        M.ICON AS ICONO_PADRE
        FROM SUBMENU AS SUB
        JOIN MENU AS M ON SUB.MENU_PADRE = M.ID
        group by M.ID;";

        $resultado = $this->db->query($query);

        $resultado = $resultado->result_array();

        log_message('ERROR', 'cargar_menus \n' . $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }





    public function getModalAnalisis($id)
    {
        $query = "SELECT ID,NOMBRE,ID_AREA_ANALITICA FROM ANALISIS WHERE ID= '$id'";

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

    public function modificar_analisis($obj)
    {
        $query = "UPDATE `ANALISIS`
        SET
        `NOMBRE` = '$obj->analisis',
        `ID_AREA_ANALITICA` = '$obj->area',
        `MODIFICADO_POR` = '$this->user_id',
        `MODIFICADO_EN` = NOW(),
        `ACTIVO` = TRUE
        WHERE `ID` = '$obj->id_analisis';";

        $resultado = $this->db->query($query);



        log_message('ERROR', 'modificar_analisis \n' . $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }
}
