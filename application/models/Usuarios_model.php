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

    public $user_id = 1;

    public function InsertaUsarios($obj)
    {

        switch ($obj->grupo) {
            case 1:
                $obj->organizacion = 0;
                break;
            case 2:
                $obj->organizacion =  0;
                break;
            case 4:
                $obj->organizacion = $obj->id_sucursal;
                break;
            case 3:
                $obj->organizacion = $obj->idlaboratorio;
                break;
            case 5:
                $obj->organizacion = $obj->id_sucursal;
                break;
            case 6:
                $obj->organizacion = $obj->id_sucursal;
                break;
        }
        

        $query = "INSERT INTO USUARIO
        (ID,
        ID_ORGANIZACION,
        CEDULA,
        GENERO,
        CREADO_EN,
        CREADO_POR,
        MODIFICADO_EN,
        MODIFCADO_POR,
        ACTIVO)
        VALUES
        ('$obj->id_usuario_creado',
        '$obj->organizacion',
        '$obj->cedula',
        '$obj->genero',
        now(),
        '$this->user_id',
        now(),
        '$this->user_id',
        $obj->activo);";



        $resultado = $this->db->query($query);



        log_message('ERROR', 'InsertaUsarios \n' . $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');
       
        return $resultado;
    }

    public function modificarUsuarios($obj)
    {

        switch ($obj->grupo) {
            case 1:
                $obj->organizacion = 0;
                break;
            case 2:
                $obj->organizacion =  0;
                break;
            case 4:
                $obj->organizacion = $obj->id_sucursal;
                break;
            case 3:
                $obj->organizacion = $obj->idlaboratorio;
                break;
            case 5:
                $obj->organizacion = $obj->id_sucursal;
                break;
            case 6:
                $obj->organizacion = $obj->id_sucursal;
                break;
        }

       
        
        $this->db->trans_start();

        $query="UPDATE USUARIO
        SET
        ID_ORGANIZACION = '$obj->organizacion',
        MODIFICADO_EN = now(),
        MODIFCADO_POR = '$this->user_id',
        ACTIVO = $obj->activo,
        CEDULA = '$obj->cedula',
        GENERO = '$obj->genero'
        WHERE ID = $obj->id_usuario";

        $this->db->query($query);
        
        $query = "update  users_groups set  group_id = '$obj->grupo' where user_id = '$obj->id_usuario';";

        $this->db->query($query);

        $resultado=$this->db->trans_complete();


        

        log_message('ERROR', 'modificarUsuarios \n' . $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');
       
        return $resultado;
    }

    

    public function getCargarDatosUSUARIOS()
    {


        $query = "SELECT UL.id as ID_USUARIO,
        CONCAT(UL.first_name,' ',
        UL.last_name) AS NOMBRE_USUARIO,
        UL.email as CORREO_USUARIO,
        UL.phone as CELULAR,
        U.CEDULA,
        U.GENERO,
        UG.group_id,
        U.ID_ORGANIZACION,
        U.ACTIVO,
        G.name as ROL
        FROM users as UL
        LEFT JOIN USUARIO AS U ON U.ID=UL.id
        JOIN users_groups AS UG ON UG.user_id = UL.ID
        JOIN groups as G ON G.id = UG.group_id
        ;";

        $resultado = $this->db->query($query);

        $resultado = $resultado->result_array();

        log_message('ERROR', 'cargar_menus \n' . $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }

    public function getModalUsuarios($id)
    {


        $query = "SELECT UL.id as ID_USUARIO,
        UL.first_name as NOMBRE_USUARIO,
        UL.last_name AS APELLIDOS_USUARIO,
        UL.email as CORREO_USUARIO,
        UL.phone as CELULAR,
        U.CEDULA,
        U.GENERO,
        UG.group_id,
        U.ID_ORGANIZACION,
        U.ACTIVO,
        G.name as ROL
        FROM users as UL
        LEFT JOIN USUARIO AS U ON U.ID=UL.id
        JOIN users_groups AS UG ON UG.user_id = UL.ID
        JOIN groups as G ON G.id = UG.group_id
        WHERE UL.ID='$id';";



        $resultado = $this->db->query($query);
        $resultado = $resultado->result_array();

        $rol = $resultado[0]["group_id"];
        $id_organizacion = $resultado[0]["ID_ORGANIZACION"];


        switch ($rol) {
            case 1:
            case 2:
                break;
            case 3:
                $queryOrganizacion = "select ID AS ID_ORGANIZACION,NOMBRE AS NOMBRE_ORGANIZACION FROM LABORATORIO WHERE ID ='$id_organizacion'";
                $organizacionResultado = $this->db->query($queryOrganizacion);
                $organizacionResultado = $organizacionResultado->result_array();
                $resultado[0][0]= $organizacionResultado[0];

                log_message('ERROR', 'cargar_menus \n' . $queryOrganizacion . '\n<pre> ' . print_r($organizacionResultado, true) . '</pre>');
                break;
            default:
                $queryOrganizacion = "select ID AS ID_ORGANIZACION,NOMBRE AS NOMBRE_ORGANIZACION FROM SUCURSALES WHERE ID ='$id_organizacion'";
                $organizacionResultado = $this->db->query($queryOrganizacion);
                $organizacionResultado = $organizacionResultado->result_array();
                $resultado[0][0]= $organizacionResultado[0];

                log_message('ERROR', 'cargar_menus \n' . $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');
                break;
        }




        log_message('ERROR', 'cargar_menus \n' . $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }
}
