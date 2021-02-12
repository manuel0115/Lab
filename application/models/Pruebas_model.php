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
class Pruebas_model extends CI_Model
{

    public $user_id=1;

    public function funcionPrueba()
    {
        /*$query = "SELECT A.ID,A.NOMBRE,AA.NOMBRE AS AREA FROM ANALISIS AS A INNER JOIN AREA_ANALITICA AS AA ON (A.ID_AREA_ANALITICA= AA.ID);";*/

       

        $resultado = $this->db->get("ANALISIS");

        $resultado = $resultado->result_array();

       /* log_message('ERROR', 'cargar_menus \n' . $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');*/

        return $resultado;
    }





    
}
