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
class Pacientes_model extends CI_Model
{

    public function cargarDatosTablaPacientes()
    {
        $query = "SELECT A.ID,A.NOMBRE,AA.NOMBRE AS AREA FROM ANALISIS AS A INNER JOIN AREA_ANALITICA AS AA ON (A.ID_AREA_ANALITICA= AA.ID);";

        $resultado = $this->db->query($query);

        $resultado = $resultado->result_array();

        log_message('ERROR','cargar_menus \n'. $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }



    

    public function getModalPacientes($id)
    {
        $query = "SELECT ID,NOMBRE,ID_AREA_ANALITICA FROM ANALISIS WHERE ID= '$id'";

        $resultado = $this->db->query($query);

        $resultado = $resultado->result_array();

        log_message('ERROR','modificar_analisis \n'. $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }
    

    public function insertar_pacientes($obj)
    {
        $query = "INSERT INTO ANALISIS (NOMBRE,ID_AREA_ANALITICA,CREADO_POR,MODIFICADO_POR,CREADO_EN,MODIFICADO_EN,ACTIVO)VALUES('$obj->analisis','$obj->area','$this->user_id','$this->user_id',NOW(),NOW(),TRUE);";

        $resultado = $this->db->query($query);

        

        log_message('ERROR','insertar_analisis \n'. $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }

    public function modificar_pacientes($obj)
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

        

        log_message('ERROR','modificar_analisis \n'. $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }

    public function getDatosPorCedula($cedula)
    {
        $query = "SELECT * FROM PACIENTES WHERE CEDULA ='$cedula'";

        $resultado = $this->db->query($query);

        $resultado = $resultado->result_array();

        log_message('ERROR','getDatosPorCedula \n'. $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }

    public function getDatosPorOrden($orden)
    {
        $query = "SELECT P.ID AS ID_PACIENTE, CONCAT(P.NOMBRE,' ',P.APELLIDOS) AS NOMBRE,
        P.CEDULA AS CEDULA,O.ID AS NUMERO_ORDEN
        FROM PACIENTES AS P 
        JOIN ORDEN AS O ON (O.ID_PACIENTE = P.ID) WHERE O.ID = '$orden';";

        $resultado = $this->db->query($query);

        $resultado = $resultado->result_array();

        log_message('ERROR','getDatosPorCedula \n'. $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }
    

   
    
}

