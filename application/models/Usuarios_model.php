<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Usuarios_model extends CI_Model {

    public function cargarDatosTablaUsuario() {
        $query = "SELECT distinct
    M.id,
    CONCAT(M.nombre_completo, ' ', M.apellido) AS nombre,
    M.telefono,
    M.correo,
    M.titulo,
    M.ocupacion,
    C.nombre_cargo AS cargo,
    M.activo AS estado,
    M.genero,
    CONCAT(F.UBUCACION_ASOCIATIVO,
            F.NOMBRE_ARCHIVO,
            '.png') AS FOTO
FROM
    tbl_miembros AS M
        JOIN
    tbl_cargo AS C ON (M.cargo = C.id_cargo)
        LEFT JOIN
    FOTO AS F ON (F.ID_ASOCIATIVO = M.id); ";

        $resultado = $this->db->query($query);

        $resultado = $resultado->result_array();

        return $resultado;
    }

    public function cargarDatosModalUsuario($id) {
        $query = "SELECT `tbl_miembros`.`id`,
    `tbl_miembros`.`nombre_completo`,
    `tbl_miembros`.`apellido`,
    `tbl_miembros`.`genero`,
    `tbl_miembros`.`telefono`,
    `tbl_miembros`.`cedula`,
    `tbl_miembros`.`correo`,
    `tbl_miembros`.`contrasena`,
    `tbl_miembros`.`titulo`,
    `tbl_miembros`.`ocupacion`,
    `tbl_miembros`.`cargo`,
     if(`tbl_miembros`.`activo`=TRUE,'S','N') AS estado
     FROM `UFEJI_DB`.`tbl_miembros` WHERE `tbl_miembros`.`id`= '$id'";

        $resultado = $this->db->query($query);

        $resultado = $resultado->result_array();
        log_message('ERROR', $query . "\n<pre>" . print_r($resultado, TRUE) . "</pre>");
        return $resultado;
    }

    public function cargarDatosCargo() {
        $query = "SELECT id_cargo,nombre_cargo FROM UFEJI_DB.tbl_cargo;";

        $resultado = $this->db->query($query);

        $resultado = $resultado->result_array();

        log_message('ERROR', $query . "\n<pre>" . print_r($resultado, TRUE) . "</pre>");

        return $resultado;
    }

    public function cargarCargosFundacion() {
        $query = "select tbl_cargo.id_cargo,tbl_cargo.nombre_cargo from u320591076_ufeji.tbl_cargo";

        $resultado = $this->db->query($query);

        $resultado = $resultado->result_array();

        return $resultado;
    }

    public function editarUsuario($obj) {
        $usuario_id = $this->session->userdata('id');
        $query = "UPDATE `UFEJI_DB`.`tbl_miembros`
SET
`nombre_completo` = '$obj->nombre',
`apellido` = '$obj->apellido',
`genero` = '$obj->genero',
`telefono` = '$obj->telefono',
`cedula` = '$obj->cedula',
`correo` = '$obj->email',
`titulo` = '$obj->titulo',
`ocupacion` = '$obj->ocupacion',
`cargo` ='$obj->cargo',
`activo` = $obj->estado,
`creado_por` = '$usuario_id',
`fecha_creacion` = NOW(),
`modificado_por` = '$usuario_id',
`fecha_modificacion` = NOW()
WHERE `id` = '$obj->id';";


        $resultado = $this->db->query($query);


        log_message('ERROR', $query . 'editarUsuario\n<pre> ' . print_r($resultado, true) . '</pre>');


        return $resultado;
    }

    public function agregarUsuario($obj) {

        $usuario_id = $this->session->userdata('id');

        $query = "INSERT INTO `UFEJI_DB`.`tbl_miembros`
(
`nombre_completo`,
`apellido`,
`genero`,
`telefono`,
`cedula`,
`correo`,
`contrasena`,
`titulo`,
`ocupacion`,
`cargo`,
`activo`,
`creado_por`,
`fecha_creacion`,
`modificado_por`,
`fecha_modificacion`)
VALUES
('$obj->nombre' ,
 '$obj->apellido',
 '$obj->genero',
 '$obj->telefono',
 '$obj->cedula',
 '$obj->email',
 '$obj->pass_confirmacion',
 '$obj->titulo',
 '$obj->ocupacion',
 '$obj->cargo',
 $obj->estado,
 '$usuario_id',
  NOW(),
 '$usuario_id',
 NOW()
 );";

        $resultado = $this->db->query($query);


        log_message('ERROR', $query . "\n<pre>" . print_r($resultado, TRUE) . "</pre>");

        return $resultado;
    }

    public function agregar_info_imagen($obj) {
        $usuario_id = $this->session->userdata('id');
        $query = "INSERT INTO FOTO(ID_ASOCIATIVO,UBUCACION_ASOCIATIVO,NOMBRE_ARCHIVO,CATEGORIA,CREADO_POR,CREADO_EN,MODIFICADO_POR,MODIFICADO_EN,ESTADO)
VALUE('$obj->usuario_id', '$obj->dir', '$obj->nombre_fichero', '$obj->categoria' ,'$usuario_id', NOW(), '$usuario_id' ,NOW() ,TRUE);";
               


        $resultado = $this->db->query($query);



        log_message('ERROR',"agregar_info_imagen\n" . $query . "\n<pre>" . print_r($resultado, TRUE) . "</pre>");

        return $resultado;
    }

}
