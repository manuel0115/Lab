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
    function __construct(){
        $this->user_id = $this->session->userdata("ID_USUARIO");
        $this->id_laboratorio = $this->session->userdata("LABORATORIO");
    }
    

    public function cargarDatosTablaConfiguracion_analisis()
    {
        $query = "SELECT CA.ID AS ID_CONFIGURACION,
        CA.ID_ANALISIS AS ID_ANALISIS,
        CA.ID_LABORATORIO AS ID_LABORATORIO,
        L.NOMBRE AS NOMBRE_LABORATORIO,
        A.NOMBRE AS NOMBRE_ANALISIS,
        IF(CA.ACTIVO,'ACTIVO','INACTIVO') AS ESTADO
        FROM CONFIGURACION_ANALISIS AS CA
        JOIN LABORATORIO AS L ON CA.ID_LABORATORIO = L.ID
        JOIN ANALISIS AS A ON CA.ID_ANALISIS = A.ID";

        $resultado = $this->db->query($query);

        $resultado = $resultado->result_array();

        log_message('ERROR', 'cargar_menus \n' . $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }





    public function getModalAnalisis($id)
    {
        $query = "SELECT ID,NOMBRE,ID_AREA_ANALITICA FROM ANALISIS WHERE ID= '$id'";

        $resultado = $this->db->query($query);

        $resultado = $resultado->result_array();

        log_message('ERROR', 'modificar_analisis \n' . $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }


    public function insertar_configuracion($obj)
    {
        $orden=0;
        $error=array();
        $queryInsertaAnalisisConfiguracion = " INSERT INTO CONFIGURACION_ANALISIS
                    (
                    ID_ANALISIS,
                    ID_LABORATORIO,
                    CREADO_POR,
                    CREADO_EN,
                    MODIFICADO_POR,
                    MODIFICADO_EN,
                    ACTIVO)
                    VALUES
                    (
                    '$obj->id_analisis',
                    '$this->id_laboratorio',
                    '$this->user_id',
                    now(),
                    '$this->user_id',
                    now(),
                    TRUE);";

        $resultadoInsertaAnalisisConfiguracion = $this->db->query($queryInsertaAnalisisConfiguracion);

        if(!$resultadoInsertaAnalisisConfiguracion){
            $error[]="analisis configuracion";
        }

        $queryUltimoAnalisisConfiguracion = "select last_insert_id() as id_analisis_configuracion";
        $resultadoUltimoAnalisisConfiguracion = $this->db->query($queryUltimoAnalisisConfiguracion);

        

        $resultadoUltimoAnalisisConfiguracion = $resultadoUltimoAnalisisConfiguracion->result_array();
        $ultimoAnalisisConfiguracion = $resultadoUltimoAnalisisConfiguracion[0]["id_analisis_configuracion"];

        if(!$ultimoAnalisisConfiguracion){
            $error[]=" ultimo analisis configuracion";
        }

        log_message('ERROR', 'insertar configuracion analisis \n' . $queryInsertaAnalisisConfiguracion . '\n<pre> ' . print_r($resultadoInsertaAnalisisConfiguracion, true) . '</pre>');
        log_message('ERROR', 'ultimo analisis confirguracion \n' . $queryUltimoAnalisisConfiguracion . '\n<pre> ' . print_r($resultadoUltimoAnalisisConfiguracion, true) . '</pre>');
        
        $queryInsertarParametros="INSERT INTO CONFIGURACION_PAREMETROS
        (
        `ID_CONFIGURACION_ANALISISIS`,
        `ID_PARAMETRO`,
        `ORDEN_PARAMETRO`,
        `UNIDAD_MEDIDA`,
        `CREADO_POR`,
        `CREADO_EN`,
        `MODIFICADO_POR`,
        `MODIFICADO_EN`,
        `ACTIVO`,
        `HOMBRE_ADULTO_REFERENCIA`,
        `HOMBRE_NINO_REFERENCIA`,
        `HOMBRE_ANCIANO_REFERENCIA`,
        `MUJER_ADULTO_REFERENCIA`,
        `MUJER_NINO_REFERENCIA`,
        `MUJER_ANCIANO_REFERENCIA`)VALUES";

        foreach($obj->parametros as $value){

       

            $queryInsertarParametros .="(
            '$ultimoAnalisisConfiguracion','".
            $value["ID_PARAMETRO"]."','".
            $value["ORDEN_PARAMETRO"]."','".
            $value["MEDIDA"].
            "','$this->user_id',
            now(),
            '$this->user_id',
            now(),
            TRUE,'".
            $value["HOMBRE_ADULTO"]."','".
            $value["HOMBRE_NINO"]."','".
            $value["HOMBRE_ANCIANO"]."','".
            $value["MUJER_ADULTO"]."','".
            $value["MUJER_NINO"]."','".
            $value["MUJER_ANCIANO"]."'),";

        }

        $queryInsertarParametros .= ";";

        $queryInsertarParametros=str_replace("),;",");",$queryInsertarParametros);

        $resultadoInsertarParametros=$this->db->query($queryInsertarParametros);


            if(!$resultadoInsertarParametros){
                $error[]=" insertar parametro configuracion";
            }


            log_message('ERROR', 'insertar configuracion parametros \n' . $queryInsertarParametros . '\n<pre> ' . print_r($resultadoInsertaAnalisisConfiguracion, true) . '</pre>');
         

            
           

            
        

      



        

        
       


      


        return count($error) == 0;
    }

    public function eliminarConfiguracion($id){
        $query="DELETE CA,CP FROM CONFIGURACION_ANALISIS AS CA
        JOIN CONFIGURACION_PAREMETROS AS CP ON CA.ID = CP.ID_CONFIGURACION_ANALISISIS
        WHERE CA.ID = '$id'";

        $resultado= $this->db->query($query);

        log_message('ERROR', 'insertar configuracion parametros \n' . $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
         
    }

    public function getConfiguracionesModal($id){
        $query="SELECT CP.ID AS CONFIGURACION_PARAMETRO,
        CP.ID_CONFIGURACION_ANALISISIS AS CONFIGURACION_ANALISIS,
        CP.ID_PARAMETRO,
        CP.HOMBRE_ADULTO_REFERENCIA,
        CP.HOMBRE_NINO_REFERENCIA,
        CP.HOMBRE_ANCIANO_REFERENCIA,
        CP.MUJER_ADULTO_REFERENCIA,
        CP.MUJER_NINO_REFERENCIA,
        CP.MUJER_ANCIANO_REFERENCIA,
        P.NOMBRE AS NOMBRE_PARAMETRO,
        CP.UNIDAD_MEDIDA ,
        CP.ORDEN_PARAMETRO,
        CA.ID_ANALISIS,
        A.NOMBRE AS NOMBRE_ANALISIS
        FROM CONFIGURACION_PAREMETROS AS CP
        JOIN PARAMETROS AS P ON CP.ID_PARAMETRO = P.ID
        JOIN CONFIGURACION_ANALISIS AS CA ON CA.ID = CP.ID_CONFIGURACION_ANALISISIS
        JOIN ANALISIS AS A ON CA.ID_ANALISIS=A.ID 
        WHERE CP.ACTIVO = TRUE AND CP.ID_CONFIGURACION_ANALISISIS='$id';";

        $resultado= $this->db->query($query);
        $resultado= $resultado->result_array();
        
        

     


        log_message('ERROR', 'insertar referencias parametros \n' . $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        
        return $resultado;
    }
    
    public function getParametroID($n){
        return $n["CONFIGURACION_PARAMETRO"];

    }


    


    public function modificar_configuracion($obj)
    {
        $errores = array();
        $eliminarConfiguraqcion=$this->eliminarConfiguracion($obj->id_analisis_confifuracion);

        if(!$eliminarConfiguraqcion){
            $errores[]="error al eliminar";
        }

        $insertarNuevaConfiguracion=$this->insertar_configuracion($obj);
       
        if(!$insertarNuevaConfiguracion){
            $errores[]="error al insertar";
        }

        $resultado = count($errores) == 0;


        log_message('ERROR', 'modificar_analisis \n meteodo insertar y eleminar \n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }

    
}
