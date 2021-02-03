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
class Usuarios_model extends CI_Model
{

    public $user_id=1;

    public function InsertaUsarios()
    {   

       /* $data = [
            'ID' => '2018-12-19',
            'ID_SUCURSAL' => 'Joe Thomas',
           
           
            
        ];*/

        /*
        
        ID	int(11) AI PK
	ID_SUCURSAL	int(11)
	NOMBRE	varchar(45)
	APELLIDO	varchar(45)
	CORREO	tinytext
	
	
	CREADO_EN	datetime
	CREADO_POR	int(11)
	MODIFICADO_EN	datetime
	MODIFCADO_POR	int(11)
	ACTIVO	bit(1)
        
        
        */ 
        $query = "SELECT A.ID,A.NOMBRE,AA.NOMBRE AS AREA FROM ANALISIS AS A INNER JOIN AREA_ANALITICA AS AA ON (A.ID_AREA_ANALITICA= AA.ID);";

        $resultado = $this->db->query($query);

        $resultado = $resultado->result_array();

        log_message('ERROR', 'cargar_menus \n' . $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }

    public function getCargarDatosUSUARIOS()
    {   

      
        $query = "SELECT U.id id_usuario,email,concat(U.first_name,' ',U.last_name) nombre from users
        as U left join USUARIO AS UM ON U.ID= UM.ID;";

        $resultado = $this->db->query($query);

        $resultado = $resultado->result_array();

        log_message('ERROR', 'cargar_menus \n' . $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }


    



}
