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
class Autocompletado_model extends CI_Model
{





    public function getAnalisis($param)
    {
        $query = "SELECT ID,NOMBRE,PARAMETROS FROM ANALISIS WHERE NOMBRE like '%$param%';";

        $resultado = $this->db->query($query);

        $resultado = $resultado->result_array();

        log_message('ERROR', "completadoRecetas\n " . $query . "\n<pre>" . print_r($resultado, TRUE) . "</pre>");

        foreach ($resultado as $value) {
            $fila["label"] = $value['NOMBRE'];
            $fila["value"] = $value['NOMBRE'];
            $fila["ID"] = $value['ID'];
            $fila["parametros"] = $value['PARAMETROS'];

            $filas[] = $fila;
        }


        return $filas;
    }

    public function getAnalisisConfiguracionParametros($param)
    {
       
        
        $query = "SELECT  A.ID,A.NOMBRE FROM ANALISIS AS A
        LEFT JOIN  CONFIGURACION_PAREMETROS AS CP ON CP.ID_ANALISISIS = A.ID
        WHERE CP.ID_ANALISISIS  IS NULL AND 
        A.NOMBRE like '%$param%';";

        $resultado = $this->db->query($query);

        $resultado = $resultado->result_array();

        log_message('ERROR', "getAnalisisConfiguracionParametros\n " . $query . "\n<pre>" . print_r($resultado, TRUE) . "</pre>");

        foreach ($resultado as $value) {
            $fila["label"] = $value['NOMBRE'];
            $fila["value"] = $value['NOMBRE'];
            $fila["ID"] = $value['ID'];
            $fila["parametros"] = $value['PARAMETROS'];

            $filas[] = $fila;
        }


        return $filas;
    }

    public function getParametros($param)
    {
        $query = "SELECT ID,NOMBRE AS PARAMETRO FROM PARAMETROS WHERE NOMBRE LIKE '%$param%';";

        $resultado = $this->db->query($query);

        $resultado = $resultado->result_array();

        log_message('ERROR', "completadoRecetas\n " . $query . "\n<pre>" . print_r($resultado, TRUE) . "</pre>");

        foreach ($resultado as $value) {
            $fila["label"] = $value['NOMBRE'];
            $fila["value"] = $value['PARAMETRO'];
            $fila["ID"] = $value['ID'];
           

            $filas[] = $fila;
        }


        return $filas;
    }
   
}
