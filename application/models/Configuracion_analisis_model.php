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
        $query = "SELECT DISTINCT CP.ID_ANALISISIS,A.NOMBRE,L.NOMBRE NOMBRE_LABORATORIO FROM CONFIGURACION_PAREMETROS AS CP
        JOIN ANALISIS AS A ON CP.ID_ANALISISIS = A.ID JOIN LABORATORIO AS L ON CP.LABORATORIO = L.ID";

        $resultado = $this->db->query($query);

        $resultado = $resultado->result_array();

        log_message('ERROR', 'cargar_menus \n' . $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }





    


    public function insertar_configuracion($obj)
    {
       
        $error=array();
        

        $this->db->trans_start();

        $queryInsertarParametros = "INSERT INTO CONFIGURACION_PAREMETROS
            (
            ID_ANALISISIS,
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
            MUJER_ANCIANO_REFERENCIA,
            LABORATORIO)VALUES";

        foreach($obj->parametros as $value){
            $queryInsertarParametros .= "(
            '$obj->id_analisis','".
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
            $value["MUJER_ANCIANO"]."','".
            $this->id_laboratorio."'),";

            
        }
        
        $queryInsertarParametros .= ";";
        $queryInsertarParametros =str_replace("),;",");", $queryInsertarParametros );

        $this->db->query($queryInsertarParametros);
        $resultado=$this->db->trans_complete(); 

        
        log_message('ERROR', 'insertar configuracion parametros \n' . $queryInsertarParametros . '\n<pre> ' . print_r($resultado, true) . '</pre>');
         


        return $resultado;
    }

    public function eliminarConfiguracion($id){
        $query="DELETE  FROM  CONFIGURACION_PAREMETROS
        WHERE ID_ANALISISIS = '$id' AND LABORATORIO = '$this->id_laboratorio';";

        $resultado= $this->db->query($query);

        log_message('ERROR', 'insertar configuracion parametros \n' . $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
         
    }

    public function getConfiguracionesModal($id){
        $query="SELECT CP.ID AS CONFIGURACION_PARAMETRO,
        CP.ID_ANALISISIS AS ID_ANALISIS,
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
        A.NOMBRE AS NOMBRE_ANALISIS
        FROM CONFIGURACION_PAREMETROS AS CP
        JOIN PARAMETROS AS P ON CP.ID_PARAMETRO = P.ID
        JOIN ANALISIS AS A ON CP.ID_ANALISISIS=A.ID 
		WHERE CP.LABORATORIO = '$this->id_laboratorio' AND CP.ID_ANALISISIS='$id'";

        $resultado= $this->db->query($query);
        $resultado= $resultado->result_array();
        
        

     


        log_message('ERROR', 'insertar referencias parametros \n' . $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        
        return $resultado;
    }
    
   


    


    public function modificar_configuracion($obj)
    {
        $errores = array();
        $eliminarConfiguraqcion=$this->eliminarConfiguracion($obj->id_analisis);

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
