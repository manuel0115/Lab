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
class Pacientes_model extends CI_Model
{   
    public $user_id;
    public $id_laboratorio;
    function __construct(){
        $this->user_id = $this->session->userdata("ID_USUARIO");
        $this->id_laboratorio = $this->session->userdata("LABORATORIO");
    }

    public function cargarDatosPacientes()
    {
        $query = "SELECT P.ID,CONCAT(P.NOMBRE,' ',P.APELLIDOS) AS NOMBRE,P.CEDULA,P.GENERO,P.FECHA_NACIMIENTO FROM PACIENTES AS P";

        $resultado = $this->db->query($query);

        $resultado = $resultado->result_array();

        log_message('ERROR','cargarDatosPacientes \n'. $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }



    

    public function getModalPacientes($id)
    {
        $query = "SELECT  
        PACI.ID,
        PACI.NOMBRE,
        PACI.APELLIDOS,
        PACI.ID_PACIENTE_FACTURACION,
        PACI.FECHA_NACIMIENTO,
        PACI.CEDULA,
        PACI.GENERO,
        YEAR(CURDATE())-YEAR(PACI.FECHA_NACIMIENTO) + IF(DATE_FORMAT(CURDATE(),'%m-%d') > DATE_FORMAT(PACI.FECHA_NACIMIENTO,'%m-%d'), 0 , -1 ) AS EDAD
        FROM PACIENTES AS PACI WHERE PACI.ID= '$id'";

        $resultado = $this->db->query($query);

        $resultado = $resultado->result_array();

        log_message('ERROR','modificar_analisis \n'. $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }
    

    public function insertar_pacientes($obj)
    {   
        
        
        $query = "INSERT INTO PACIENTES
        (
        ID_PACIENTE_FACTURACION,
        NOMBRE,
        APELLIDOS,
        GENERO,
        CEDULA,
        FECHA_NACIMIENTO,
        CREADO_POR,
        CREADO_EN,
        MODIFICADO_POR,
        MODIFCADO_EN,
        ACTIVO,
        LABORATORIO)
        VALUES
        (
        '$obj->id_facturacion',
        '$obj->nombre',
        '$obj->apellido',
        '$obj->genero',
        '$obj->cedula',
        '$obj->fecha',
        '$this->user_id',
        now(),
        '$this->user_id',
        now(),
        TRUE,
        '$this->id_laboratorio');";

        $resultado = $this->db->query($query);

        

        log_message('ERROR','insertar_pacientes \n'. $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }

    public function modificar_pacientes($obj)
    {   
       
        $query = "UPDATE PACIENTES
        SET
       
        ID_PACIENTE_FACTURACION = '$obj->id_facturacion',
        NOMBRE = '$obj->nombre',
        APELLIDOS = '$obj->apellido',
        GENERO = '$obj->genero',
        CEDULA = '$obj->cedula',
        FECHA_NACIMIENTO = '$obj->fecha',
        CREADO_POR = '$this->user_id',
        CREADO_EN = now(),
        MODIFICADO_POR = '$this->user_id',
        MODIFCADO_EN = now(),
        ACTIVO = TRUE,
        LABORATORIO='$this->id_laboratorio'
        WHERE ID = $obj->id_paciente;";

        $resultado = $this->db->query($query);

        log_message('ERROR','modificar_analisis \n'. $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }

    public function getDatosPorCedula($cedula)
    {
        $query = "SELECT ID,CONCAT(NOMBRE,' ',APELLIDOS) AS NOMBRE FROM PACIENTES WHERE CEDULA ='$cedula'";

        $resultado = $this->db->query($query);

        $resultado = $resultado->result_array();

        log_message('ERROR','getDatosPorCedula \n'. $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        foreach ($resultado as $value) {
            $fila["label"] = $value['NOMBRE'];
            $fila["value"] = $value['NOMBRE'];
            $fila["ID"] = $value['ID'];
            $fila["parametros"] = $value['PARAMETROS'];

            $filas[] = $fila;
        }

        return $filas;
    }

    /*public function getDatosPorOrden($orden)
    {
        $query = "SELECT P.ID AS ID_PACIENTE, CONCAT(P.NOMBRE,' ',P.APELLIDOS) AS NOMBRE,
        P.CEDULA AS CEDULA,O.ID AS NUMERO_ORDEN
        FROM PACIENTES AS P 
        JOIN ORDEN AS O ON (O.ID_PACIENTE = P.ID) WHERE O.ID = '$orden';";

        $resultado = $this->db->query($query);

        $resultado = $resultado->result_array();

        log_message('ERROR','getDatosPorCedula \n'. $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }*/
    

   
    
}

