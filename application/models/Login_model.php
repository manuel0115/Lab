<?php

class Login_model extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }

   /* public function loginUsuario($obj)
    {

        $query = "SELECT U.ID AS ID_USUARIO,
        CONCAT(U.NOMBRE,' ',U.APELLIDO) AS NOMBRE_USUARIO,
        U.CORREO AS CORREO,
        U.PASS AS PASSWORD,
        U.ROL AS ROL,
        U.ID_SUCURSAL AS ID_SUSCURSAL,
        S.NOMBRE AS NOMBRE_SUCURSAL,
        S.TELEFONOS AS TELEFONOS_SUCURSALES,
        L.NOMBRE AS NOMBRE_LABORATORIO,
	    L.RNC AS RNC,
        L.CORREO AS CORREO_LABORATORIO,
        S.LABORATORIO,
        D.CALLE AS CALLE,
        D.NUMERO AS NUMERO,
        D.SECTOR AS SECTOR,
        D.PROVINCIA,
        D.PAIS
        FROM USUARIO AS U
        JOIN SUCURSALES AS S ON S.ID = U.ID_SUCURSAL
        JOIN LABORATORIO AS L ON L.ID = S.ID 
        JOIN DIRECICONES AS D ON S.ID = D.ID
        WHERE U.CORREO = '$obj->email';";


        $result = $this->db->query($query);


        log_message('ERROR', $query . "loginUsuario\n<pre>" . print_r($result, TRUE) . "</pre>");

        $filas = $result->num_rows();

        //return $filas;

        if (!$filas > 0) {
            return false;
        } else {
            $result = $result->result_array();

            if (!password_verify($obj->pass, $result[0]['PASSWORD'])) {
                return false;
            } else {
                return $result;
            }
        }
    }*/

    public function getDataUsuario($id)
    {
        $query = "SELECT UL.id as Id,
        concat(UL.first_name,' ',UL.last_name) as nombre,
        UL.phone as Telefono,
        UL.email AS Correo,
        U.CEDULA AS Cedula,
        U.GENERO AS Genero,
        U.ACTIVO AS ESATADO,
        U.ID_ORGANIZACION,
        UG.group_id AS ID_ROL,
        G.name as Nombre_rol
        FROM users as UL 
        LEFT JOIN USUARIO AS U ON UL.id = U.ID
        JOIN users_groups AS UG ON UG.user_id = UL.id
        JOIN groups AS G ON UG.group_id = G.id
        WHERE UL.id = '$id'";

        $result = $this->db->query($query);
        $result = $result->result_array();

        log_message('ERROR', $query . "loginUsuario\n<pre>" . print_r($result, TRUE) . "</pre>");

        return $result;
    }
}
