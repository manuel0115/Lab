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
class Eventos_model extends CI_Model
{





    public function cargarDatosTablaEventos()
    {
        $query = "SELECT DISTINCT E.ID,E.TITULO,E.SUBTITULO,CE.NOMBRE AS CATEGORIA,CE.ICONO,F.UBUCACION_ASOCIATIVO AS FOTO, CONCAT(M.nombre_completo,' ',M.apellido) as NOMBRE,DATE_FORMAT(STR_TO_DATE(E.FECHA_EVENTO,'%Y-%m-%d'),'%d/%m/%Y') as FECHA_EVENTO,DATE_FORMAT(STR_TO_DATE(E.FECHA_LIMITE,'%Y-%m-%d'),'%d/%m/%Y') as FECHA_LIMITE,E.PRECIO,E.ACTIVO,E.DESCRIPCION,E.HORA_INICIO FROM UFEJI_DB.tbl_eventos AS E JOIN UFEJI_DB.tbl_miembros as M on (E.ENCARGADO=M.id)
        JOIN UFEJI_DB.CATEGORIA_EVENTOS AS CE ON (E.CATEGORIA=CE.ID)  LEFT JOIN  UFEJI_DB.FOTO AS F ON (F.ID_ASOCIATIVO= E.ID AND F.CATEGORIA=2) order by E.ID ASC;";

        $resultado = $this->db->query($query);

        $resultado = $resultado->result_array();

        log_message('ERROR','cargarDatosTablaEventos \n'. $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }

    public function getDataEvento($id)
    {
        $query = "SELECT E.ID,
    E.TITULO,
    E.SUBTITULO,
    E.CATEGORIA,
    E.DESCRIPCION,
    CONCAT(M.nombre_completo,' ',M.apellido) AS NOMBRE_ENCARGADO,
    E.ENCARGADO,
    DATE_FORMAT(STR_TO_DATE(E.FECHA_EVENTO,'%Y-%m-%d'),'%d/%m/%Y') as FECHA_EVENTO,
    DATE_FORMAT(STR_TO_DATE(E.FECHA_LIMITE,'%Y-%m-%d'),'%d/%m/%Y') as FECHA_LIMITE,
    
    E.PRECIO,
    E.CANTIDAD_PERSONAS,
    E.CREADO_POR,
    E.CREADO_EN,
    E.MODIFICADO_POR,
    E.MODIFICADO_EN,
    E.HORA_INICIO,
    E.HORA_FIN,
    E.ACTIVO
FROM tbl_eventos AS E JOIN tbl_miembros AS M ON  (E.ENCARGADO=M.id) WHERE E.ID ='$id';";

        $resultado = $this->db->query($query);

        $resultado = $resultado->result_array();

        return $resultado;
    }

    public function getCategoriasEvento()
    {
        $query = "SELECT ID, NOMBRE FROM CATEGORIA_EVENTOS;";

        $resultado = $this->db->query($query);

        $resultado = $resultado->result_array();

        return $resultado;
    }

    public function autocompletadoUsuario($param)
    {


        $query = "SELECT id as ID, CONCAT(nombre_completo,' ',apellido) as NOMBRE FROM tbl_miembros having  NOMBRE like '%$param%';";

        $resultado = $this->db->query($query);

        $resultado = $resultado->result_array();

        log_message('ERROR', "completadoRecetas\n " . $query . "\n<pre>" . print_r($resultado, TRUE) . "</pre>");

        foreach ($resultado as $value) {
            $fila["label"] = $value['NOMBRE'];
            $fila["value"] = $value['ID'];

            $filas[] = $fila;
        }


        return $filas;
    }


    public function insertar_evento($obj)
    {

        $usuario_id = $this->session->userdata('id');

        $query = "INSERT INTO tbl_eventos
        (
        TITULO,
        SUBTITULO,
        CATEGORIA,
        DESCRIPCION,
        ENCARGADO,
        FECHA_EVENTO,
        FECHA_LIMITE,
        CANTIDAD_PERSONAS,
        CREADO_POR,
        CREADO_EN,
        MODIFICADO_POR,
        MODIFICADO_EN,
        HORA_INICIO,
        ACTIVO)
        VALUES
        (
        '$obj->titulo',
        '$obj->subtitulo',
        '$obj->categoria',
        '$obj->descripcion',
        '$obj->id_encargado',
        '$obj->fecha_evento',
        '$obj->fecha_limite',
        '$obj->cantidad_personas',
        '$usuario_id',
         NOW(),
        '$usuario_id',
         NOW(),
         '$obj->hora',
        $obj->activo);";

        $resultado = $this->db->query($query);


        log_message('ERROR', $query . 'insertar_evento\n<pre> ' . print_r($resultado, true) . '</pre>');


        return $resultado;
    }



    public function modificar_evento($obj)
    {

        $usuario_id = $this->session->userdata('id');

        $query = "UPDATE UFEJI_DB.tbl_eventos
        SET
        TITULO = '$obj->titulo' ,
        SUBTITULO = '$obj->subtitulo' ,
        CATEGORIA = '$obj->categoria' ,
        DESCRIPCION = '$obj->descripcion' ,
        ENCARGADO = '$obj->id_encargado' ,
        FECHA_EVENTO = '$obj->fecha_evento' ,
        FECHA_LIMITE = '$obj->fecha_limite' ,
        CANTIDAD_PERSONAS = '$obj->cantidad_personas' ,
        MODIFICADO_POR = '$usuario_id',
        MODIFICADO_EN = NOW(),
        HORA_INICIO = '$obj->hora',
        ACTIVO = $obj->activo
        WHERE ID = '$obj->id';";

        $resultado = $this->db->query($query);


        log_message('ERROR', $query . 'insertar_evento\n<pre> ' . print_r($resultado, true) . '</pre>');


        return $resultado;
    }
}
