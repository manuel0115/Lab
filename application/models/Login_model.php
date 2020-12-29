<?php

class Login_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function loginUsuario($obj) {

        $query = "SELECT M.id,
    M.nombre_completo,
    M.apellido,
    M.contrasena,
    M.cargo,
    M.activo,
    CONCAT(F.UBUCACION_ASOCIATIVO,F.NOMBRE_ARCHIVO,'.png') as img
    
     FROM UFEJI_DB.tbl_miembros AS M LEFT JOIN UFEJI_DB.FOTO F ON (M.id=F.ID_ASOCIATIVO) WHERE 	M.correo='$obj->email';
    ";

        $result = $this->db->query($query);


        log_message('ERROR', $query . "loginUsuario\n<pre>" . print_r($result, TRUE) . "</pre>");
        
        $filas = $result->num_rows();
        if ($filas > 0) {
            $result = $result->result_array();
            if (password_verify($obj->pass, $result[0]['contrasena'])) {
                return $result;
            } else {
                return 0;
            }
        } else {
            return $filas;
        }
    }

}
