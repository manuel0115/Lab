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
        IF(M.NOMBRE IS NULL,FALSE,M.NOMBRE) MENU_PADRE,
        M.ICON,
        M.ID,
        group_concat(CONCAT(SM.ID,'|',SM.NOMBRE,'|',SM.ICONO,'|',SM.URL)) AS SUB_MENUS
        FROM SUBMENU AS SM
        LEFT JOIN MENU AS M ON SM.MENU_PADRE = M.ID
        GROUP BY MENU_PADRE";

        $resultado = $this->db->query($query);

        $resultado = $resultado->result_array();

        log_message('ERROR', 'cargar_menus \n' . $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }

    public function cargarmenusPorControlador($controller)
    {
        $query = "SELECT 	ID FROM SUBMENU WHERE URL = '$controller';";

        $resultado = $this->db->query($query);

        $resultado = $resultado->result_array();

        log_message('ERROR', 'cargar_menus \n' . $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }

    





   
}
