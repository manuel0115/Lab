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
class Ordenes_model extends CI_Model
{




    public function cargarDatosOrdenes()
    {
        $query = "SELECT O.ID AS ORDEN,
        O.LISTA_ANALISIS,
        CONCAT(P.NOMBRE,' ',P.APELLIDOS) AS PACIENTE,
        R.NOMBRE AS REFERENCIA,
        C.NOMBRE AS COBERTURA,
        O.CREADO_EN AS FECHA_ENTRADA,
        IF((SELECT count(id) FROM RESULTADO where ID_ORDEN =O.ID ) > 0,TRUE,FALSE) AS RESULATADO_EXISTENTES
        FROM ORDEN AS O 
        JOIN PACIENTES AS P ON(P.ID = O.ID_PACIENTE)
        JOIN REFERENCIA AS R ON (R.ID = O.REFERENCIA)
        JOIN COBERTURA AS C ON (C.ID = P.ID);";

        $resultado = $this->db->query($query);

        $resultado = $resultado->result_array();

        log_message('ERROR', 'cargarDatosTablaAreaAnalitica \n' . $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }





    public function insertar_orden($obj)
    {
        $user_id = 1;

        $query = "INSERT INTO `ORDEN`
        (
        `ID_PACIENTE`,
        `REFERENCIA`,
        `CREADO_POR`,
        `CREADO_EN`,
        `MODIFICADO_POR`,
        `MODIFICADO_EN`,
        `ACTIVO`,
        `STATUS`,
        `LISTA_ANALISIS`)
        VALUES
        (
        '$obj->id_paciente',
        '$obj->referencia',
        '$user_id',
        NOW(),
        '$user_id',
        NOW(),
        TRUE,
        '1',
        '$obj->listado_analisis' );";

        $resultado = $this->db->query($query);













        log_message('ERROR', 'insertar_orden \n' . $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }


    public function modificar_orden($obj)
    {
        $user_id = 1;

        $query = "UPDATE ORDEN
        SET
        
        `ID_PACIENTE` = '$obj->id_paciente',
        `REFERENCIA` = '$obj->referencia',
        `MODIFICADO_POR` = '$user_id',
        `MODIFICADO_EN` = NOW(),
        `ACTIVO` = TRUE,
        `STATUS` = '1',
        `LISTA_ANALISIS` = '$obj->listado_analisis'
        WHERE `ID` = '$obj->id_orden';";

        $resultado = $this->db->query($query);



        log_message('ERROR', 'modificar_orden \n' . $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }

    public function modificar_area($obj)
    {
        $query = "UPDATE `AREA_ANALITICA`
        SET
        `NOMBRE` = '$obj->area',
        `MODIFICADO_POR` = '$this->user_id',
        `MODIFICADO_EN` = NOW(),
        `ESTADO` = TRUE
        WHERE `ID` = '$obj->id_area';";

        $resultado = $this->db->query($query);



        log_message('ERROR', 'modificar_area \n' . $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }

    public function getDataOrden($id)
    {
        $query = "SELECT O.ID,
        O.LISTA_ANALISIS,
        O.ID,
        O.ID_PACIENTE,
        CONCAT(P.NOMBRE,'',P.APELLIDOS)AS NOMBRE,
        P.CEDULA,
        O.REFERENCIA  
        FROM ORDEN AS O
        JOIN PACIENTES AS P ON P.ID = O.ID_PACIENTE
        WHERE O.ID = '$id';";

        $resultado = $this->db->query($query);

        $resultado = $resultado->result_array();

        log_message('ERROR', 'getDataOrden \n' . $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }

    public function buscarParametrosResulatdo($analisis)
    {
        $query = "SELECT 
        CONCAT(CP.ID_PARAMETRO,'-',P.NOMBRE) AS NOMBRE_PARAMETRO,
        CP.ORDEN_PARAMETRO AS ORDEN_PARAMETRO,
        A.NOMBRE AS NOMBRE_ANALISIS,
        CA.ID_ANALISIS AS ID_ANALISIS
        FROM CONFIGURACION_PAREMETROS AS CP 
        JOIN CONFIGURACION_ANALISIS AS CA ON CP.ID_CONFIGURACION_ANALISISIS	 = CA.ID
        JOIN ANALISIS AS A ON A.ID=CA.ID_ANALISIS 
        JOIN PARAMETROS AS P ON CP.ID_PARAMETRO = P.ID
        WHERE CA.ID_ANALISIS IN($analisis)";

        

        $resultado = $this->db->query($query);

        $resultado = $resultado->result_array();

        log_message('ERROR', 'getDataOrden \n' . $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }

    public function insertar_resulatdo($obj)
    {   

        $errores= array();
        $user_id = 1;



        $queryCrearResultado = "INSERT INTO `RESULTADO`
        (
        `ID_ORDEN`,
        `CREADO_POR`,
        `CREADO_EN`,
        `MODIFICADO_POR`,
        `MODIFICADO_EN`,
        `ACTIVO`)
        VALUES
        (
        '$obj->id_orden',
        '$user_id',
        NOW(),
        '$user_id',
        NOW(),
        TRUE);";



        $resultadoCrearResultado = $this->db->query($queryCrearResultado);

        if(!$resultadoCrearResultado){
            $errores[]="CrearResulatado";
        }

        $queryIdUltimoResultado = "select last_insert_id() as id";

        $idUltimoResultado = $this->db->query($queryIdUltimoResultado);
        $idUltimoResultado = $idUltimoResultado->result_array();

        $idUltimoResultado = $idUltimoResultado[0]["id"];


        log_message('ERROR', 'insertar resultado');
        log_message('ERROR', 'queryCrearResultado \n' . $queryCrearResultado . '\n<pre> ' . print_r($resultadoCrearResultado, true) . '</pre>');
        log_message('ERROR', 'idUltimoResultado \n' . $queryIdUltimoResultado . '\n<pre> ' . print_r($idUltimoResultado, true) . '</pre>');

        foreach ($obj->datos as $key => $value) {



            $queryAnalisisResultado = "INSERT INTO `ANALISIS_RESULTADO`
            (
            `CREADO_POR`,
            `CREADO_EN`,
            `MODIFICADO_POR`,
            `MODIFICADO_EN`,
            `ACTIVO`,
            `COMENTARIO`,
            `ID_RESULTADO`,
            `ID_ANALISIS`)
            VALUES
            (
            '$user_id',
            NOW(),
            '$user_id',
            NOW(),
            TRUE,
            '" . $value["comentario"] . "',
            '$idUltimoResultado',
            '" . $value["id_analisis"] . "');";

            $analsisResultadoResultado = $this->db->query($queryAnalisisResultado);
            
            if(!$analsisResultadoResultado){
                $errores[]="analisResulatado";
            }
    


            $queryIdUltimoAnalsisResultado = "select last_insert_id() as id";

            $idUltimoAnalsisResultado = $this->db->query($queryIdUltimoAnalsisResultado);

            $idUltimoAnalisisResultado = $idUltimoAnalsisResultado->result_array();
            $idUltimoAnalisisResultado = $idUltimoAnalisisResultado[0]["id"];



            

                $queryParametroResultado = "INSERT INTO PARAMEROS_TEMPORAL_RESULATDO(ID_ANALSIS_RESULTADO,ID_PARAMETRO,VALOR)VALUES";

                foreach ($value['parametros'] as $key_r => $value_r) {
                    $queryParametroResultado =$queryParametroResultado . "
                    ('$idUltimoAnalisisResultado','" . 
                    $value_r['id_paremetro'] . 
                    "','" . $value_r["valor"] . "'),";
                }

                $queryParametroResultado =$queryParametroResultado .";";

                $queryParametroResultado =str_replace("),;",");",$queryParametroResultado);

                $resulatdoParametroResultado = $this->db->query($queryParametroResultado);

                if(!$resulatdoParametroResultado){
                    $errores[]="parametrosVariosResulatado";
                }
        

                log_message('ERROR', 'queryVariosParametroResultado \n' . $queryParametroResultado . '\n<pre> ' . print_r($resulatdoParametroResultado, true) . '</pre>');
          
                

               

                
               
            }



            log_message('ERROR', 'queryAnalisisResultado \n' . $queryAnalisisResultado . '\n<pre> ' . print_r($analsisResultadoResultado, true) . '</pre>');
            log_message('ERROR', 'idUltimoAnalisisResultado \n' . $queryIdUltimoAnalsisResultado . '\n<pre> ' . print_r($idUltimoAnalisisResultado, true) . '</pre>');
        


        if(!empty($errores)){
            log_message('ERROR', 'resultadoProceso \n' . "errores" . '\n<pre> ' . print_r($errores, true) . '</pre>');
            return false;
        }
        

        log_message('ERROR', 'resultadoProceso \n' . $errores . '\n<pre> ' . print_r(true, true) . '</pre>');
        return true;



     
    }
}
