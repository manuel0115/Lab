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
class Parametros_model extends CI_Model
{




    public function tablaParametros()
    {
        $query = "SELECT P.ID,P.NOMBRE as NOMBRE, A.NOMBRE AS ANALISIS FROM PARAMETROS AS P JOIN ANALISIS AS A ON (P.ID_ANALISIS = A.ID);";

        $resultado = $this->db->query($query);

        $resultado = $resultado->result_array();

        log_message('ERROR','cargar_menus \n'. $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }

    public function getModalParametros($id)
    {
        $query = "SELECT P.ID,P.NOMBRE as NOMBRE, A.NOMBRE AS ANALISIS, A.ID AS ID_ANALISIS FROM PARAMETROS AS P JOIN ANALISIS AS A ON (P.ID_ANALISIS = A.ID) WHERE P.ID='$id';";

        $resultado = $this->db->query($query);

        $resultado = $resultado->result_array();

        log_message('ERROR','cargar_menus \n'. $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }

    

    public function guardarParametro($obj)
    {   
        $user_id= 1;

        $query = "INSERT INTO PARAMETROS (
        `NOMBRE`,
        `ID_ANALISIS`,
        `CREADO_POR`,
        `MODIFICADO_POR`,
        `ACTIVO`,
        `CREADO_EN`,
        `MODIFICADO_EN`) VALUE('$obj->parametro','$obj->ID_ANALISIS',$user_id,$user_id,TRUE,NOW(),NOW());";


        $resultado = $this->db->query($query);

        

        log_message('ERROR','cargar_menus \n'. $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }

    public function actualizarParametro($obj)
    {   
        $user_id= 1;
        $query = "UPDATE `PARAMETROS`
        SET
        
        `NOMBRE` = '$obj->parametro',
        `ID_ANALISIS` = '$obj->ID_ANALISIS',
        `MODIFICADO_POR` = '$user_id',
        `MODIFICADO_EN` = NOW()
        WHERE `ID` =  '$obj->id';";

        $resultado = $this->db->query($query);

        

        log_message('ERROR','cargar_menus \n'. $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }

    /*public function cargarDatosTablaAreaAnalitica()
    {
        //$query = "SELECT * FROM AREA_ANALITICA;";

        //$resultado = $this->db->query($query);

        $resultado = $resultado->result_array();

        log_message('ERROR','cargarDatosTablaEventos \n'. $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return array("ssss","sdsdsdsd");
    }*/
/*
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
    }*/
}
