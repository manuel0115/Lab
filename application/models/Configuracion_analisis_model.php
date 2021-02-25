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
class Configuracion_analisis_model extends CI_Model
{

    public $user_id;
    public $id_laboratorio;
    public $user;
    function __construct()
    {
        $this->load->model('login_model');
        $user = $this->ion_auth->user()->row();
        $user = $user->id;

        $this->user = $this->login_model->getDataUsuario($user);
    }


    public function cargarDatosTablaConfiguracion_analisis()
    {


        $query = "SELECT CA.ID AS CONFIGURACION_ANALISIS,
        CA.ID_ANALISIS AS ID_ANALISIS,
        CA.LABORATORIO AS LABORATORIO,
        L.NOMBRE AS NOMBRE_LABORATORIO,
        A.NOMBRE AS NOMBRE_ANALISIS
        FROM CONFIGURACION_ANALISIS AS CA
        JOIN LABORATORIO AS L ON L.ID= CA.LABORATORIO
        JOIN ANALISIS AS A ON A.ID = CA.ID_ANALISIS";

        if ($this->user[0]["ID_ROL"] == 3 || $this->user[0]["ID_ROL"] == 4) {
            $query .= " WHERE CA.LABORATORIO ='" . $this->user[0]["ID_LABORATORIO"] . "'";
        }

        /*if ($this->user[0]["ID_ROL"] == 4 ) {
            $query .= "WHERE CA.LABORATORIO ='".$this->user[0]["ID_LABORATORIO"]."'";
        }*/

        $resultado = $this->db->query($query);

        $resultado = $resultado->result_array();

        log_message('ERROR', 'cargar_menus \n' . $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }

    public function checkAnalsis($obj)
    {

        if (!($this->user[0]["ID_ROL"] == 1 || $this->user[0]["ID_ROL"] == 2)) {
            $obj->laboratorio=$this->user[0]["ID_LABORATORIO"];
        }
      

        $query = "SELECT ID FROM CONFIGURACION_ANALISIS WHERE ID_ANALISIS='$obj->id_analisis' AND LABORATORIO = '$obj->laboratorio';";

       
        /*if ($this->user[0]["ID_ROL"] == 4 ) {
            $query .= "WHERE CA.LABORATORIO ='".$this->user[0]["ID_LABORATORIO"]."'";
        }*/

        $resultado = $this->db->query($query);

        $resultado = $resultado->result_array();

        log_message('ERROR', 'cargar_menus \n' . $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }



    public function insertar_configuracion($obj)
    {

        if (!($obj->laboratorio > 0)) {
            $obj->laboratorio = $this->user[0]["ID_LABORATORIO"];
        }

        $queryInsertarAnalsis = "INSERT INTO CONFIGURACION_ANALISIS
                                (
                                ID_ANALISIS,
                                CREADO_POR,
                                CREADO_EN,
                                MODIFICADO_POR,
                                MODIFICADO_EN,
                                ACTIVO,
                                LABORATORIO)
                                VALUES
                                (
                                '$obj->id_analisis',
                                '" . $this->user[0]["Id"] . "',
                                now(),
                                '" . $this->user[0]["Id"] . "',
                                NOW(),
                                TRUE,
                                '" .   $obj->laboratorio . "');";


        $ultimo_insert = $this->db->query("select LAST_INSERT_ID() as ultimo_id");
        $ultimo_insert = $ultimo_insert->result_array();


        $ultimo_insert = $ultimo_insert[0]["ultimo_id"];

        if ($this->db->query($queryInsertarAnalsis)) {

            $ultimo_insert = $this->db->query("select LAST_INSERT_ID() as ultimo_id");
            $ultimo_insert = $ultimo_insert->result_array();



            $queryInsertarParametros = "INSERT INTO CONFIGURACION_PAREMETROS
            (
            ID_CONFIGURACION_ANALISIS,
            ID_PARAMETRO,
            ORDEN_PARAMETRO,
            UNIDAD_MEDIDA,
            CREADO_POR,
            CREADO_EN,
            MODIFICADO_POR,
            MODIFICADO_EN,
            ACTIVO,
            HOMBRE_ADULTO_REFERENCIA,
            HOMBRE_NINO_REFERENCIA,
            HOMBRE_ANCIANO_REFERENCIA,
            MUJER_ADULTO_REFERENCIA,
            MUJER_NINO_REFERENCIA,
            MUJER_ANCIANO_REFERENCIA
            )VALUES";


            foreach ($obj->parametros as $value) {
                $queryInsertarParametros .= "(
            '" . $ultimo_insert[0]["ultimo_id"] . "','" .
                    $value["ID_PARAMETRO"] . "','" .
                    $value["ORDEN_PARAMETRO"] . "','" .
                    $value["MEDIDA"] .
                    "','" . $this->user[0]["Id"] . "',
            now(),
            '" . $this->user[0]["Id"] . "',
            now(),
            TRUE,'" .
                    $value["HOMBRE_ADULTO"] . "','" .
                    $value["HOMBRE_NINO"] . "','" .
                    $value["HOMBRE_ANCIANO"] . "','" .
                    $value["MUJER_ADULTO"] . "','" .
                    $value["MUJER_NINO"] . "','" .
                    $value["MUJER_ANCIANO"] . "'),";
            }

            $queryInsertarParametros .= ";";
            $queryInsertarParametros = str_replace("),;", ");", $queryInsertarParametros);

            $resultado = $this->db->query($queryInsertarParametros);
        }






        log_message('ERROR', $queryInsertarAnalsis . '\n' . $queryInsertarParametros . '\n<pre> ' . print_r($resultado, true) . '</pre>');



        return $resultado;
    }





    public function eliminarConfiguracion($id)
    {
        $query = "DELETE CONFIGURACION_ANALISIS,CONFIGURACION_PAREMETROS  FROM   CONFIGURACION_ANALISIS
        JOIN CONFIGURACION_PAREMETROS ON CONFIGURACION_PAREMETROS.ID_CONFIGURACION_ANALISIS =
        CONFIGURACION_ANALISIS.ID
        WHERE CONFIGURACION_ANALISIS.ID = '$id';";

        $resultado = $this->db->query($query);

        log_message('ERROR', 'insertar configuracion parametros \n' . $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }

    public function eliminarParametrosConfiguracion($id)
    {
        $query = "DELETE  FROM  CONFIGURACION_PAREMETROS
        WHERE ID_CONFIGURACION_ANALISIS = '$id';";

        $resultado = $this->db->query($query);

        log_message('ERROR', 'insertar configuracion parametros \n' . $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }



    public function getConfiguracionesModal($id)
    {
        $query = "SELECT
        CP.ID_CONFIGURACION_ANALISIS,
        group_concat(CONCAT(CP.ID,'|',
                            CP.ID_PARAMETRO,'|',
                            P.NOMBRE,'|',
                            CP.ORDEN_PARAMETRO,'|',
                            CP.UNIDAD_MEDIDA,'|',
                            HOMBRE_ADULTO_REFERENCIA,'|',
                            HOMBRE_NINO_REFERENCIA,'|',	
                            HOMBRE_ANCIANO_REFERENCIA,'|',	
                            MUJER_ADULTO_REFERENCIA,'|',
                            MUJER_NINO_REFERENCIA,'|',
                            MUJER_ANCIANO_REFERENCIA)) AS PARAMETROS,
        CA.ID_ANALISIS AS ID_ANALISIS,
        A.NOMBRE AS NOMBRE_ANALISIS,
        CA.LABORATORIO AS ID_LABORATORIO
        FROM CONFIGURACION_PAREMETROS AS CP
        JOIN PARAMETROS AS P ON CP.ID_PARAMETRO= P.ID
        JOIN CONFIGURACION_ANALISIS AS CA ON CP.ID_CONFIGURACION_ANALISIS= CA.ID
        JOIN ANALISIS AS A ON CA.ID_ANALISIS = A.ID
        JOIN LABORATORIO AS L ON CA.LABORATORIO = L.ID
        WHERE CP.ID_CONFIGURACION_ANALISIS ='$id'
        GROUP BY CP.ID_CONFIGURACION_ANALISIS";

        $resultado = $this->db->query($query);
        $resultado = $resultado->result_array();

        log_message('ERROR', 'insertar referencias parametros \n' . $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');


        return $resultado;
    }







    public function modificar_configuracion($obj)
    {

        /*$eliminarParametrosConfiguracion = $this->eliminarParametrosConfiguracion($obj->id_analisis_confifuracion);*/

        $resultado=$this->eliminarParametrosConfiguracion($obj->id_analisis_confifuracion);

        if ($resultado){



            



            $queryInsertarParametros = "INSERT INTO CONFIGURACION_PAREMETROS
            (
            ID_CONFIGURACION_ANALISIS,
            ID_PARAMETRO,
            ORDEN_PARAMETRO,
            UNIDAD_MEDIDA,
            CREADO_POR,
            CREADO_EN,
            MODIFICADO_POR,
            MODIFICADO_EN,
            ACTIVO,
            HOMBRE_ADULTO_REFERENCIA,
            HOMBRE_NINO_REFERENCIA,
            HOMBRE_ANCIANO_REFERENCIA,
            MUJER_ADULTO_REFERENCIA,
            MUJER_NINO_REFERENCIA,
            MUJER_ANCIANO_REFERENCIA
            )VALUES";


            foreach ($obj->parametros as $value) {
                $queryInsertarParametros .= "(
            '" . $obj->id_analisis_confifuracion . "','" .
                    $value["ID_PARAMETRO"] . "','" .
                    $value["ORDEN_PARAMETRO"] . "','" .
                    $value["MEDIDA"] .
                    "','" . $this->user[0]["Id"] . "',
            now(),
            '" . $this->user[0]["Id"] . "',
            now(),
            TRUE,'" .
                    $value["HOMBRE_ADULTO"] . "','" .
                    $value["HOMBRE_NINO"] . "','" .
                    $value["HOMBRE_ANCIANO"] . "','" .
                    $value["MUJER_ADULTO"] . "','" .
                    $value["MUJER_NINO"] . "','" .
                    $value["MUJER_ANCIANO"] . "'),";
            }

            $queryInsertarParametros .= ";";
            $queryInsertarParametros = str_replace("),;", ");", $queryInsertarParametros);

            $resultado = $this->db->query($queryInsertarParametros);
        }

        /*if (!$insertarNuevaConfiguracion) {
            $errores[] = "error al insertar";
        }*/

      


        log_message('ERROR', 'modificar_analisis \n meteodo insertar y eleminar \n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }
}
