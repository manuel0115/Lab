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
class Reporte_resultado_model extends CI_Model
{

    public function getTablaReporteResultado()
    {
        $query = "SELECT R.ID AS ID_RESULTADO, R.ID_ORDEN,
        P.ID AS ID_PACIENTE,
        CONCAT(P.NOMBRE,' ',P.APELLIDOS) AS NOMBRE,
        O.ID,
        P.CEDULA AS CEDULA,
        R.CREADO_EN
        FROM RESULTADO AS R 
        JOIN ORDEN AS O ON R.ID_ORDEN = O.ID
        JOIN PACIENTES AS P ON O.ID_PACIENTE = P.ID";

        $resultado = $this->db->query($query);

        $resultado = $resultado->result_array();

        log_message('ERROR','cargar_menus \n'. $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }



    

    public function getModalresultados($resultado)
    {
        $query = "select ptr.ID AS ID_PARAMETRO_TEMPORAL_RESULTADO,
        ptr.VALOR as VALOR,
        ptr.MEDIDA as MEDIDA,
        ptr.REFERENCIA AS REFERENCIA,
        ptr.ID_ANALSIS_RESULTADO AS ID_ANALISIS_RESULTADO,
        p.NOMBRE AS NOMBRE_PARAMETRO,
        ar.COMENTARIO,
        r.ID as ID_RESULTADO,
        a.PARAMETROS AS TIENE_PARAMETROS ,
        a.NOMBRE AS NOMBRE_ANALISIS
        from PARAMEROS_TEMPORAL_RESULATDO as ptr 
        join ANALISIS_RESULTADO as ar on ptr.ID_ANALSIS_RESULTADO = ar.ID
        JOIN RESULTADO AS r on ar.ID_RESULTADO = r.ID 
        JOIN ANALISIS AS a ON ar.ID_ANALISIS= a.id
        JOIN PARAMETROS AS p on ptr.ID_PARAMETRO=p.ID
        WHERE r.ID ='$resultado'
        ";

        $resultado = $this->db->query($query);

        $resultado = $resultado->result_array();

        log_message('ERROR','modificar_analisis \n'. $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }
    

    public function insertar_analisis($obj)
    {
        $query = "INSERT INTO ANALISIS (NOMBRE,ID_AREA_ANALITICA,CREADO_POR,MODIFICADO_POR,CREADO_EN,MODIFICADO_EN,ACTIVO)VALUES('$obj->analisis','$obj->area','$this->user_id','$this->user_id',NOW(),NOW(),TRUE);";

        $resultado = $this->db->query($query);

        

        log_message('ERROR','insertar_analisis \n'. $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

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

        

        log_message('ERROR','modificar_analisis \n'. $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }


   
    
}
