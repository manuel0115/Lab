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
class Reporte_resultado_model extends CI_Model
{

    public function getTablaReporteResultado()
    {
        $query = "SELECT R.ID AS ID_RESULTADO, R.ID_ORDEN,
        P.ID AS ID_PACIENTE,
        CONCAT(P.NOMBRE,' ',P.APELLIDOS) AS NOMBRE,
        O.ID,
        P.CEDULA AS CEDULA,
        R.CREADO_EN
        FROM RESULTADO AS R 
        JOIN ORDEN AS O ON R.ID_ORDEN = O.ID
        JOIN PACIENTES AS P ON O.ID_PACIENTE = P.ID";

        $resultado = $this->db->query($query);

        $resultado = $resultado->result_array();

        log_message('ERROR','cargar_menus \n'. $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }



    

    public function getModalresultados($resultado)
    {
        /*$query = "select ptr.ID AS ID_PARAMETRO_TEMPORAL_RESULTADO,
        ptr.VALOR as VALOR,
        ptr.MEDIDA as MEDIDA,
        ptr.REFERENCIA AS REFERENCIA,
        ptr.ID_ANALSIS_RESULTADO AS ID_ANALISIS_RESULTADO,
        p.NOMBRE AS NOMBRE_PARAMETRO,
        ar.COMENTARIO,
        r.ID as ID_RESULTADO,
        a.PARAMETROS AS TIENE_PARAMETROS ,
        a.NOMBRE AS NOMBRE_ANALISIS,
        arn.ID as id_area_analitica,
        arn.NOMBRE as nombre_araea_analitica
        from PARAMEROS_TEMPORAL_RESULATDO as ptr 
        join ANALISIS_RESULTADO as ar on ptr.ID_ANALSIS_RESULTADO = ar.ID
        JOIN RESULTADO AS r on ar.ID_RESULTADO = r.ID 
        JOIN ANALISIS AS a ON ar.ID_ANALISIS= a.id
        JOIN PARAMETROS AS p on ptr.ID_PARAMETRO=p.ID
        JOIN  AREA_ANALITICA AS arn on a.ID_AREA_ANALITICA = arn.ID
        WHERE r.ID ='$resultado'
        ";*/

        $query="SELECT PTR.ID AS ID_PARAMETRO_RESULTADO,
        PTR.ID_PARAMETRO AS ID_PARAMETRO,
        PTR.VALOR AS VALOR,
        CP.ID AS CONFIGURACION_PARAMETRO_ID,
        CP.UNIDAD_MEDIDA AS ID_UNIDAD_MEDIDA,
        UM.NOMBRE AS NOMBRE_UNIDAD_MEDIDA,
        P.NOMBRE AS NOMBRE_PARAMETRO,
        AR.ID AS ANALISIS_PADRE,
        AR.ID_ANALISIS AS ID_ANALISIS,
        A.NOMBRE AS NOMBRE_ANALSIS,
        AA.NOMBRE AS NOMBRE_AREA,
    
        AR.COMENTARIO AS COMENTARIO,
        AR.ID_ORDEN AS ID_ORDEN,
        O.ID_PACIENTE AS ID_PACIENTE,
        PA.FECHA_NACIMIENTO AS FECHA_NACIMIENTO,
        @EDAD :=YEAR(CURDATE())-YEAR(PA.FECHA_NACIMIENTO) + IF(DATE_FORMAT(CURDATE(),'%m-%d') > DATE_FORMAT(PA.FECHA_NACIMIENTO,'%m-%d'), 0 , -1 ) AS EDAD,
        @GENERO := PA.GENERO AS GENERO,
        IF(@EDAD BETWEEN 0 AND 12,CP.HOMBRE_NINO_REFERENCIA,IF(@EDAD BETWEEN 12 AND 65,HOMBRE_ADULTO_REFERENCIA,IF(@EDAD BETWEEN 65 AND 150,HOMBRE_ANCIANO_REFERENCIA,'ERROR'))) AS REFERENCIA
        FROM PARAMEROS_TEMPORAL_RESULATDO AS PTR
        JOIN PARAMETROS AS P ON PTR.ID_PARAMETRO = P.ID
        JOIN ANALISIS_RESULTADO AS AR ON PTR.ID_ANALSIS_RESULTADO = AR.ID
        JOIN ANALISIS AS A ON AR.ID_ANALISIS = A.ID
        JOIN AREA_ANALITICA AA ON A.ID_AREA_ANALITICA = AA.ID
        JOIN CONFIGURACION_PAREMETROS AS CP ON CP.ID_PARAMETRO = PTR.ID_PARAMETRO AND AR.ID_ANALISIS = CP.	ID_ANALISISIS
        LEFT JOIN UNIDAD_MEDIDA AS UM ON UM.ID = CP.UNIDAD_MEDIDA
      
        JOIN ORDEN AS O ON AR.ID_ORDEN = O.ID
        JOIN PACIENTES AS PA ON PA.ID = O.ID_PACIENTE
        WHERE AR.ID_ORDEN = '$resultado'";

        $resultado = $this->db->query($query);

        $resultado = $resultado->result_array();

        log_message('ERROR','modificar_analisis \n'. $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }
    

    public function getInfoResultados($id)
    {
        $query = "SELECT 
        #DATOS DEL PACIENTE Y LA ORDEN
        O.ID AS NUMERO_ORDEN,
        O.ID_PACIENTE AS NUMERO_PACIENTE,
        DATE(O.CREADO_EN) AS  FECHA_ENTRADA,
        DATE(NOW()) AS FECHA_SALIDA,
        O.REFERENCIA AS REFERENCIA,
        O.SUCURSALES ,
        O.REFERENCIA_DOCTOR,
        S.NOMBRE AS PROCEDENCIA,
        R.NOMBRE AS COBERTURA,
        #DATOS DE LA SUCURSA Y DEL LABORATORIO
        S.DIRECCION AS DIRECCION,
        S.TELEFONOS AS TELEFONOS_SUCURSALES,
        L.CORREO AS CORREO_LABORATORIO,
        L.RNC AS RNC,
        UPPER(CONCAT(PAC.NOMBRE,' ',PAC.APELLIDOS)) AS NOMBRE_PACIENTE ,
        PAC.CEDULA AS PACIENTE_CEDULA,
        PAC.FECHA_NACIMIENTO AS FECHA_NACIMIENTO,
        @EDAD :=YEAR(CURDATE())-YEAR(PAC.FECHA_NACIMIENTO) + IF(DATE_FORMAT(CURDATE(),'%m-%d') > DATE_FORMAT(PAC.FECHA_NACIMIENTO,'%m-%d'), 0 , -1 ) AS EDAD,
        @GENERO := PAC.GENERO AS GENERO,
        #ANALISIS INFORMACION 
        AR.ID AS ID_ANALISIS_RESULTADO,
        AR.ID_ANALISIS AS ID_ANALAISIS,
        A.NOMBRE AS NOMBRE_ANALISIS,
        AR.COMENTARIO AS COMENTARIO,
        PTR.ID AS ID_PTR,
        PTR.ID_PARAMETRO,
        PTR.VALOR,
        AA.NOMBRE AS NOMBRE_AREA, 
        P.ID AS ID_PARAMETRO,
        CA.ID AS ID_CONFIGURACION_ANALISIS,
        IF(CP.UNIDAD_MEDIDA = '0','SUM',UM.NOMBRE) AS UNIDAD_DE_MEDIDA,
        IF(@EDAD BETWEEN 0 AND 12,CP.HOMBRE_NINO_REFERENCIA,IF(@EDAD BETWEEN 12 AND 65,HOMBRE_ADULTO_REFERENCIA,IF(@EDAD BETWEEN 65 AND 150,HOMBRE_ANCIANO_REFERENCIA,'ERROR'))) AS REFERENCIA,
        P.NOMBRE AS NOMBRE_PARAMETRO,
        GROUP_CONCAT(CONCAT(P.NOMBRE,'|',PTR.VALOR,'|',IF(CP.UNIDAD_MEDIDA = '0','SUM',UM.NOMBRE),'|',IF(@EDAD BETWEEN 0 AND 12,CP.HOMBRE_NINO_REFERENCIA,IF(@EDAD BETWEEN 12 AND 65,HOMBRE_ADULTO_REFERENCIA,IF(@EDAD BETWEEN 65 AND 150,HOMBRE_ANCIANO_REFERENCIA,'ERROR'))))) AS PARAMETROS
        FROM ORDEN AS O
        JOIN REFERENCIA AS R ON R.ID = O.REFERENCIA 
        JOIN PACIENTES AS PAC ON PAC.ID = O.ID_PACIENTE
        JOIN SUCURSALES AS S ON S.ID = O.SUCURSALES
        JOIN LABORATORIO AS L ON L.ID  = S.LABORATORIO
        JOIN ANALISIS_RESULTADO AS AR ON AR.ID_ORDEN = O.ID
        JOIN ANALISIS AS A ON A.ID = AR.ID_ANALISIS
        JOIN AREA_ANALITICA AS AA ON AA.ID = A.ID_AREA_ANALITICA
        JOIN PARAMEROS_TEMPORAL_RESULATDO AS PTR ON PTR.ID_ANALSIS_RESULTADO = AR.ID
        JOIN PARAMETROS AS P ON P.ID = PTR.ID_PARAMETRO
        JOIN CONFIGURACION_ANALISIS AS CA ON CA.ID_ANALISIS = AR.ID_ANALISIS  AND CA.LABORATORIO = S.LABORATORIO
        JOIN CONFIGURACION_PAREMETROS AS CP ON CP.ID_CONFIGURACION_ANALISIS = CA.ID AND PTR.ID_PARAMETRO = CP.ID_PARAMETRO
        LEFT JOIN UNIDAD_MEDIDA AS UM ON CP.UNIDAD_MEDIDA = UM.ID
        WHERE O.ID ='$id'
        group by AR.ID
        ORDER BY FIELD(AR.ID_ANALISIS,'53','174','43') DESC;";

        $resultado = $this->db->query($query);

        $resultado = $resultado->result_array();

        

        log_message('ERROR','getInfoResultados \n'. $query . '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
    }

    public function modificarfoResultados($obj)
    {   

      
        $this->db->trans_start();

        foreach($obj as $value){
            $queryComentario = "UPDATE ANALISIS_RESULTADO SET COMENTARIO = '" .$value['comentario']."' WHERE ID = '".$value["id_analisis"]."';";

            $this->db->query($queryComentario);


            foreach($value["parametros"] as $value_p){
                $queryValorParametro = "UPDATE PARAMEROS_TEMPORAL_RESULATDO SET VALOR = '" .$value_p['valor']."' WHERE ID = '".$value_p["id_paremetro"]."';";

                $this->db->query($queryValorParametro);

            }
        }

        $resultado=$this->db->trans_complete(); 


        
        
        

       

        /*$resultado = $this->db->query($query);

        $resultado = $resultado->result_array();*/

        

        log_message('ERROR','getInfoResultados \n'. $queryComentario .$queryValorParametro. '\n<pre> ' . print_r($resultado, true) . '</pre>');

        return $resultado;
        
    }


    


   
    
}
