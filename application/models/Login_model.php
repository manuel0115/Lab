<?php

class Login_model extends CI_Model
{

  

   /* public $user_id;
    public $id_laboratorio;
    public $user;*/
    function __construct()
    {
       
        /*$user = $this->ion_auth->user()->row();
        $user = $user->id;

        $this->user = $this->getDataUsuario($user);
        $this->user_id=$this->user[0]["Id"];*/

    }

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
        G.name as Nombre_rol,
        S.ID AS ID_SUCURSAL,
        L.ID AS ID_LABORATORIO
        FROM users as UL 
        LEFT JOIN USUARIO AS U ON UL.id = U.ID
        LEFT JOIN users_groups AS UG ON UG.user_id = UL.id
        JOIN groups AS G ON UG.group_id = G.id
		LEFT JOIN SUCURSALES AS S ON S.ID = U.ID_ORGANIZACION
        LEFT JOIN LABORATORIO AS L ON L.ID = IF(S.ID IS NOT NULL,S.LABORATORIO,  U.ID_ORGANIZACION)
        WHERE UL.id = '$id'";

        $result = $this->db->query($query);
        $result = $result->result_array();

        log_message('ERROR', $query . "loginUsuario\n<pre>" . print_r($result, TRUE) . "</pre>");

        return $result;
    }
}
