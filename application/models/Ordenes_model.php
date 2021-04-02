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


    public $user_id;
    public $id_laboratorio;
    public $user;
    function __construct()
    {
        $this->load->model('login_model');
        $user = $this->ion_auth->user()->row();
        $user = $user->id;
      

        $this->user = $this->login_model->getDataUsuario($user);
        $this->user_id=$this->user[0]["Id"];
        $this->id_laboratorio  =$this->user[0]["ID_LABORATORIO"];

    }

    public function cargarDatosOrdenes()
    {   
       

        $query = "SELECT O.ID as ORDEN,
        CONCAT(P.NOMBRE,' ',P.APELLIDOS) AS PACIENTE,
        R.NOMBRE AS REFERENCIA,
        O.CREADO_EN AS FECHA,
        P.ID as ID_PACIENTE,
        P.CEDULA AS CEDULA_PACIENTE,
        P.CORREO AS CORREO_PACIENTE,
        L.NOMBRE AS LABORATORIO,
        S.NOMBRE AS SUCURSAL,
        S.LABORATORIO AS ID_LABORATORIO,
        O.SUCURSALES AS ID_SUCURSAL,
        P.TELEFONO AS TELEFONO_PACIENTE
        FROM ORDEN AS O 
        JOIN PACIENTES AS P ON O.ID_PACIENTE = P.ID 
        JOIN REFERENCIA AS R ON R.ID = O.REFERENCIA
        JOIN SUCURSALES AS S ON S.ID = O.SUCURSALES
        JOIN LABORATORIO AS L ON L.ID = S.LABORATORIO";

        
        if ($this->ion_auth->in_group(array(3))){
           /* echo "<pre>";
            print_r(array("aa"));
            echo "<pre>";
            die();*/

            $query .= " WHERE S.LABORATORIO ='". $this->user[0]["ID_LABORATORIO"]."'";
        }

        if ($this->ion_auth->in_group(array(5,6))){
            $query .= " WHERE O.SUCURSALES ='". $this->user[0]["ID_SUCURSAL"]."'";

           /* echo "<pre>";
            print_r(array("bb"));
            echo "<pre>";
            die();*/
        }

        if ($this->ion_auth->in_group(array(4))){
            $query .= " WHERE R.NOMBRE ='". $this->user[0]["ID_SUCURSAL"]."'";

           /* echo "<pre>";
            print_r(array("cc"));
            echo "<pre>";
            die();*/
        }

        
        $resultado = $this->db->query($query);

        $resultado = $resultado->result_array();

        log_message('ERROR', 'cargarDatosTablaAreaAnalitica \n' . $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }





    public function insertar_orden($obj)
    {
        $this->db->trans_start();

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
        `SUCURSALES`)
        VALUES
        (
        '$obj->id_paciente',
        '$obj->referencia',
        '$this->user_id',
        NOW(),
        '$this->user_id',
        NOW(),
        TRUE,
        '1',
        '$this->id_laboratorio');";

        $this->db->query($query);

        $lastOreden = $insertId = $this->db->insert_id();
        $queryAnalisisResulatado = "INSERT INTO ANALISIS_RESULTADO
        (
        CREADO_POR,
        CREADO_EN,
        MODIFICADO_POR,
        MODIFICADO_EN,
        ACTIVO,
        COMENTARIO,
        ID_ANALISIS,
        ID_ORDEN)
        VALUES";

        foreach ($obj->lista_analisis as $key => $value) {
            $queryAnalisisResulatado .= "(
                $obj->id_paciente,
                NOW(),
                $obj->id_paciente,
                NOW(),
                TRUE,
                '',
                '$value',
                '$lastOreden'),";
        }

        $queryAnalisisResulatado .= ";";
        $queryAnalisisResulatado = str_replace("),;", ");", $queryAnalisisResulatado);

        $this->db->query($queryAnalisisResulatado);


        $resultado = $this->db->trans_complete();


    

        $resultado = ["RESULTADO" => $resultado, "ID_ORDEN" => $lastOreden];
        $arrayQuery = [$queryAnalisisResulatado, $query];


        log_message('ERROR', 'insertar_orden \n' . $arrayQuery . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }


    public function modificar_orden($obj)
    {

        $this->db->trans_start();



        $query = "UPDATE ORDEN
        SET
        ID_PACIENTE = '$obj->id_paciente',
        REFERENCIA = '$obj->referencia',
        MODIFICADO_POR = '$this->user_id',
        MODIFICADO_EN= NOW(),
        ACTIVO = TRUE
        WHERE ID = '$obj->id_orden';";


        $resultado = $this->db->query($query);




        if (!empty($obj->valores_eliminar)) {

            $valores = implode(",", $obj->valores_eliminar);

            $queryElimina = "DELETE ANALISIS_RESULTADO,
        PARAMEROS_TEMPORAL_RESULATDO 
        FROM ANALISIS_RESULTADO 
        LEFT JOIN PARAMEROS_TEMPORAL_RESULATDO ON ANALISIS_RESULTADO.ID = PARAMEROS_TEMPORAL_RESULATDO.ID_ANALSIS_RESULTADO
        WHERE ANALISIS_RESULTADO.ID_ANALISIS in ($valores) AND  ANALISIS_RESULTADO.ID_ORDEN ='$obj->id_orden'";

            $this->db->query($queryElimina);
        }
      
        if (!empty($obj->valores_agregar)) {
            $queryAnalisisResulatado = "INSERT INTO ANALISIS_RESULTADO
        (
        CREADO_POR,
        CREADO_EN,
        MODIFICADO_POR,
        MODIFICADO_EN,
        ACTIVO,
        COMENTARIO,
        ID_ANALISIS,
        ID_ORDEN)
        VALUES";

            foreach ($obj->valores_agregar as $key => $value) {
                $queryAnalisisResulatado .= "(
                $obj->id_paciente,
                NOW(),
                $obj->id_paciente,
                NOW(),
                TRUE,
                '',
                '$value',
                '$obj->id_orden'),";
            }

            $queryAnalisisResulatado .= ";";
            $queryAnalisisResulatado = str_replace("),;", ");", $queryAnalisisResulatado);

            $this->db->query($queryAnalisisResulatado);
        }

        $resultado = $this->db->trans_complete();

        $resultado = ["RESULTADO" => $resultado];
        $arrayQuery = [$query];

        log_message('ERROR', 'modificar_orden \n' . $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        log_message('ERROR', 'eliminar \n' . $queryElimina . '\n<pre> ' . print_r($resultado, true) . '</pre>');

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
        $query = "SELECT AR.ID_ORDEN,
        GROUP_CONCAT(AR.ID_ANALISIS,'-',A.NOMBRE,'-',PP.PRECIO) AS LISTA_PRECIO,
        O.ID,
        O.ID_PACIENTE,
        O.REFERENCIA,
        O.REFERENCIA_DOCTOR,
        CONCAT(P.NOMBRE,' ',P.APELLIDOS) AS NOMBRE,
        P.CEDULA AS CEDULA
        FROM ORDEN AS O
        JOIN ANALISIS_RESULTADO AS AR
        JOIN PERFIL_PRECIOS AS PP ON PP.ID_ANALISIS = AR.ID_ANALISIS AND O.REFERENCIA= PP.ID_REFERENCIA AND PP.ID_LABORATORIO = 1
        JOIN ANALISIS AS A ON AR.ID_ANALISIS = A.ID AND AR.ID_ORDEN = O.ID
        JOIN PACIENTES AS P ON O.ID_PACIENTE = P.ID
        WHERE O.ID ='$id'
        GROUP BY O.ID;";

        $resultado = $this->db->query($query);

        $resultado = $resultado->result_array();

        log_message('ERROR', 'getDataOrden \n' . $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }

    public function buscarParametrosResulatdo($id_orden)
    {
       

        /*$query = "SELECT AR.ID,
        AR.ID_ANALISIS,
        A.NOMBRE AS NOMBRE_ANALISIS,
        CP.ID_PARAMETRO,
        PTR.VALOR,
        AR.COMENTARIO,
        GROUP_CONCAT(CONCAT(CP.ORDEN_PARAMETRO,'|',CP.ID_PARAMETRO,'|',P.NOMBRE,'|',IF(PTR.VALOR IS NULL,'NTV',PTR.VALOR ))) AS PARAMETROS
        FROM ANALISIS_RESULTADO AS AR
        LEFT JOIN CONFIGURACION_PAREMETROS AS CP ON CP.ID_ANALISISIS = AR.ID_ANALISIS AND CP.LABORATORIO =1
        LEFT JOIN  PARAMEROS_TEMPORAL_RESULATDO AS PTR ON AR.ID = PTR.ID_ANALSIS_RESULTADO AND PTR.ID_PARAMETRO = CP.ID_PARAMETRO
        JOIN PARAMETROS AS P ON P.ID = CP.ID_PARAMETRO
        JOIN ANALISIS AS A ON AR.ID_ANALISIS = A.ID
        WHERE AR.ID_ORDEN='$id_orden'
        GROUP BY AR.ID_ANALISIS";*/

        $query="SELECT AR.ID AS ID_ANALISIS_RESULATADO,
        AR.ID_ANALISIS AS ID_ANALISIS,
        IF(AR.COMENTARIO = '','NTC',AR.COMENTARIO) AS ANALISIS_COMENTARIO,
        S.LABORATORIO AS ID_LABORATORIO,
        CA.ID AS ID_CONFIGURACION_ANALISIS,
        A.NOMBRE AS NOMBRE_ANALISIS,
        IF(PTR.VALOR IS NULL,'NTV',PTR.VALOR) AS VALOR,
        GROUP_CONCAT(CONCAT(CP.ORDEN_PARAMETRO,'|',CP.ID_PARAMETRO,'|',P.NOMBRE,'|',IF(PTR.VALOR IS NULL,'NTV',PTR.VALOR ))) AS PARAMETROS
        FROM ANALISIS_RESULTADO AS AR
        JOIN ORDEN AS O ON AR.ID_ORDEN = O.ID
        JOIN SUCURSALES AS S ON S.ID = O.SUCURSALES
        JOIN CONFIGURACION_ANALISIS AS CA ON CA.ID_ANALISIS = AR.ID_ANALISIS AND CA.LABORATORIO=S.LABORATORIO
        JOIN CONFIGURACION_PAREMETROS AS CP ON CP.ID_CONFIGURACION_ANALISIS = CA.ID 
        LEFT JOIN PARAMEROS_TEMPORAL_RESULATDO AS PTR ON PTR.ID_ANALSIS_RESULTADO = AR.ID AND PTR.ID_PARAMETRO = CP.ID_PARAMETRO
        JOIN PARAMETROS AS P ON P.ID = CP.ID_PARAMETRO
        JOIN ANALISIS AS A ON A.ID = AR.ID_ANALISIS
        WHERE AR.ID_ORDEN = '$id_orden'
        GROUP BY AR.ID_ANALISIS
        ORDER BY FIELD(AR.ID_ANALISIS,'53') DESC;";

        $resultado = $this->db->query($query);

        $resultado = $resultado->result_array();

        log_message('ERROR', 'buscarParametrosResulatdo \n' . $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }

    public function insertar_resulatdo($obj)
    {


        $this->db->trans_start();

        foreach ($obj->datos as $value) {
            $queryAnalisisResultados = "UPDATE ANALISIS_RESULTADO
                SET
                MODIFICADO_POR = '$this->user_id',
                MODIFICADO_EN = NOW(),
                COMENTARIO = '" . $value["comentario"] . "'
                WHERE ID = '" . $value["id_analisis_resultado"] . "';";

            $this->db->query($queryAnalisisResultados);

            foreach ($value['parametros'] as $key_r => $value_r) {
               

                if ($value_r["status"] == "AGREGAR") {

                   
                    $query_parametro_valor = "INSERT INTO PARAMEROS_TEMPORAL_RESULATDO
                        (
                        ID_ANALSIS_RESULTADO,
                        ID_PARAMETRO,
                        VALOR)
                        VALUES
                        (
                        '" . $value["id_analisis_resultado"] . "',
                        '" . $value_r["id_paremetro"] . "',
                        '" . $value_r["valor"] . "');";

                    $this->db->query($query_parametro_valor);
                } else {

                    
                    $query_parametro_valor = "UPDATE  PARAMEROS_TEMPORAL_RESULATDO
                       SET VALOR = '" . $value_r["valor"] . "' WHERE ID_ANALSIS_RESULTADO ='" . $value["id_analisis_resultado"] . "' AND  ID_PARAMETRO ='" . $value_r["id_paremetro"] . "';";


                   




                    $this->db->query($query_parametro_valor);
                }
            }
        }

        $resultado = $this->db->trans_complete();


        log_message('ERROR', 'insertar_resulatdo \n' . $query_parametro_valor . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }

    public function eliminar_Ordenes($id)
    {

        $query = "DELETE ORDEN,ANALISIS_RESULTADO,PARAMEROS_TEMPORAL_RESULATDO FROM ORDEN 
        JOIN ANALISIS_RESULTADO ON ORDEN.ID = ANALISIS_RESULTADO.ID_ORDEN 
        LEFT JOIN PARAMEROS_TEMPORAL_RESULATDO ON PARAMEROS_TEMPORAL_RESULATDO.ID_ANALSIS_RESULTADO = ANALISIS_RESULTADO.ID OR PARAMEROS_TEMPORAL_RESULATDO.ID_ANALSIS_RESULTADO IS NULL
        WHERE ORDEN.ID ='$id'
        ";

        $resultado = $this->db->query($query);

        log_message('ERROR', 'eliminar_Ordenes \n' . $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');
        return $resultado;
    }

    public function actulizarListaPrecios($obj)
    {   
        if (!$this->ion_auth->in_group(array(1,2))){
        
            $obj->id_laboratorio=$this->user[0]["ID_LABORATORIO"];
        }


        $query = "SELECT PP.ID_ANALISIS,
        A.NOMBRE, 
        PP.PRECIO 
        FROM PERFIL_PRECIOS AS PP 
        JOIN ANALISIS AS A ON A.ID = PP.ID_ANALISIS
        WHERE PP.ID_ANALISIS IN ($obj->lista_analisis) AND PP.ID_REFERENCIA ='$obj->id_referencia'  AND ID_LABORATORIO='".$obj->id_laboratorio."'";

        $resultado = $this->db->query($query);

        $resultado = $resultado->result_array();

        log_message('ERROR', 'actulizarListaPrecios \n' . $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }
}
