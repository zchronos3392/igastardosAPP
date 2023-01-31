<?php

/**
 * Representa el la estructura de las categorias
 * almacenadas en la base de datos
 */
require_once 'database.php';

class objetivos
{
    function __construct()
    {
    }

    /**
     * Retorna en la fila especificada de la tabla 'gasobjetivos'
     *
     * @param NO HAY
     * @return array Datos del registro
     */

    public static function getLastId()
    {
    	$filtro="";
    	$consulta = "SELECT idobjetivo FROM gasobjetivos ORDER BY idobjetivo desc LIMIT 1";

        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute();
			// no se estaba devolviendl el resultado en formato JSON
			// con esta linea se logro...
			// usar en vez de return echo, aunque no se si funcionara con ANDROID
            return $comando->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            return ($e->getMessage());
        }
    }    
         
    public static function getAll($filtro)
    {
    	$filtrarPor="";
    	if($filtro != 99)
    		$filtrarPor=" where idobjetivo = $filtro";		
        $consulta = "SELECT idobjetivo, FechaDesdeVig, FechaHastaVig, 
        				fraccion, FraccionTipo,fraccionTiempo, montoObjetivo, montoAviso,
        			objobservaciones1, objetivoTipo FROM gasobjetivos $filtrarPor";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute();
			// no se estaba devolviendl el resultado en formato JSON
			// con esta linea se logro...
			// usar en vez de return echo, aunque no se si funcionara con ANDROID
            return $comando->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            return ($e->getMessage());
        }
    }
    
    
    public static function getAllSubObjetivos($filtro)
    {
    	$filtrarPor="";
    	if($filtro != 99)
    		$filtrarPor=" where idobjetivo = $filtro";		
        $consulta = "SELECT gasdetobjetivos.*,gasmonedas.abrmoneda,gasmediospago.nombreabrev 
        			 FROM gasdetobjetivos  
						INNER JOIN gasmonedas
			            on gasmonedas.monedaId=gasdetobjetivos.monedaid
			            INNER JOIN gasmediospago
			            on gasmediospago.mediopagoid = gasdetobjetivos.mediopagoid 
			        $filtrarPor";

        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute();
			// no se estaba devolviendl el resultado en formato JSON
			// con esta linea se logro...
			// usar en vez de return echo, aunque no se si funcionara con ANDROID
            return $comando->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            return ($e->getMessage());
        }
    }

    /**
     * Retorna conteo de registros de la tabla 'gasobjetivos'
     *
     * @return array Datos del registro
     */

   public static function PorcentajeCumplidoFraccion($FechaInicio,$Fechafin,$FraccionMonto,
   													$mediopago,$monedaid){

   	$consulta = "SELECT (sum(IF(md.montoCuota <>0,md.montoCuota,md.gasPUnit * md.gasCant +(IF(md.EsRecargo = 1, md.descuento, (-1)*(md.descuento))- md.descuentoGeneral)))
      /$FraccionMonto) as 'PORCENTAJE', 
      (sum(IF(md.montoCuota <>0,md.montoCuota,md.gasPUnit * md.gasCant +(IF(md.EsRecargo = 1, md.descuento, (-1)*(md.descuento))- md.descuentoGeneral)))
       ) as 'MONTOTF' 
			FROM gasmovdiarios md 
			WHERE md.movTipo='E' 
			and md.tipoMedioPago = $mediopago
			and md.monedaId  = $monedaid			
			and md.gasFecha >= '$FechaInicio' 
			and md.gasFecha < '$Fechafin'; ";
//        echo "<br> $consulta <br>";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute();
			// no se estaba devolviendl el resultado en formato JSON
			// con esta linea se logro...
			// usar en vez de return echo, aunque no se si funcionara con ANDROID
            return $comando->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            return ($e->getMessage());
        }   	
   }
    
   public static function PorcentajeCumplidoFraccionX($FechaInicio,$Fechafin,$FraccionMonto,
   													$mediopago,$monedaid){

   	$consulta = "SELECT (sum(IF(md.montoCuota <>0,md.montoCuota,md.gasPUnit * md.gasCant +(IF(md.EsRecargo = 1, md.descuento, (-1)*(md.descuento))- md.descuentoGeneral)))
      /$FraccionMonto) as 'PORCENTAJE', 
      (sum(IF(md.montoCuota <>0,md.montoCuota,md.gasPUnit * md.gasCant +(IF(md.EsRecargo = 1, md.descuento, (-1)*(md.descuento))- md.descuentoGeneral)))
       ) as 'MONTOTF' 
			FROM gasmovdiarios md 
			WHERE md.movTipo='E' 
			and md.tipoMedioPago = $mediopago
			and md.monedaid		 = $monedaid
			and md.gasFecha >= '$FechaInicio' 
			and md.gasFecha <= '$Fechafin';  ";
        //echo "<br> $consulta <br>";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute();
			// no se estaba devolviendl el resultado en formato JSON
			// con esta linea se logro...
			// usar en vez de return echo, aunque no se si funcionara con ANDROID
            return $comando->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            return ($e->getMessage());
        }   	
   }    
   public static function contar()
    {
    		
        $consulta = "SELECT count(*) FROM gasobjetivos ";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute();

            return $comando->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            return $e;
        }
    }


    /**
     * Obtiene los campos del objetivo buscado o pedido
     *
     * @param $idobjetivo Identificador del Objetivo
     * @return mixed
     */
    public static function getById($idobjetivo)
    {
        // Consulta de la categoria
        $consulta = " SELECT idobjetivo, FechaDesdeVig, FechaHastaVig, 
        				fraccion, FraccionTipo,fraccionTiempo, montoObjetivo, montoAviso,
        			objobservaciones1, objetivoTipo FROM gasobjetivos
					WHERE idobjetivo=$idobjetivo  ";

        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($idobjetivo));
            // Capturar primera fila del resultado
            $row = $comando->fetch(PDO::FETCH_ASSOC);
            return $row;
            //echo json_encode($row);

        } catch (PDOException $e) {
            // Aqu� puedes clasificar el error dependiendo de la excepci�n
            // para presentarlo en la respuesta Json
            return -1;
        }
    }

    /**
     * Actualiza un registro de la bases de datos basado
     * en los nuevos valores relacionados con un identificador
     *
     * @param TODOS MODIFICABLES, Y SE INGRESA POR LA CLAVE $idobjetivo
     * 
     */
    public static function update($idobjetivo,$FechaDesdeVig, $FechaHastaVig, $fraccion,
    							  $fraccionTiempo,$FraccionTipo,$montoObjetivo,
    							  $montoAviso,$objobservaciones1,$objetivoTipo )
    {

        // Creando consulta UPDATE
        $consulta = "UPDATE gasobjetivos
        				SET FechaDesdeVig='$FechaDesdeVig',
        					FechaHastaVig='$FechaHastaVig', 
        					fraccion=$fraccion, 
        					FraccionTipo='$FraccionTipo', 
        					fraccionTiempo=$fraccionTiempo,
        					montoObjetivo=$montoObjetivo, 
        					montoAviso=$montoAviso,
        					objobservaciones1='$objobservaciones1', 
        					objetivoTipo='$objetivoTipo'
        					WHERE idobjetivo=$idobjetivo ";
//		echo "$consulta";
        // Preparar la sentencia
        $cmd = Database::getInstance()->getDb()->prepare($consulta);
        // Relacionar y ejecutar la sentencia
        return $cmd->execute(array($idobjetivo,$FechaDesdeVig, $FechaHastaVig, $fraccion,$fraccionTiempo,
    							  $FraccionTipo,$montoObjetivo, $montoAviso,$objobservaciones1,
    							  $objetivoTipo ));

		//echo json_encode($cmd);
    }

    /**
     * Insertar un OBJETIVO
     *
     * @return PDOStatement
     */
    public static function insert($FechaDesdeVig, $FechaHastaVig, $fraccion,$FraccionTipo,
    							  $fraccionTiempo,$montoObjetivo, $montoAviso,
    							  $objobservaciones1,$objetivoTipo ){
        // Sentencia INSERT

        $comando = "INSERT INTO gasobjetivos (FechaDesdeVig, FechaHastaVig, 
        				fraccion, fraccionTiempo,FraccionTipo, montoObjetivo, montoAviso,
        			objobservaciones1, objetivoTipo) 
        				VALUES ('$FechaDesdeVig', '$FechaHastaVig', $fraccion,$FraccionTipo,
    							 '$fraccionTiempo',$montoObjetivo, $montoAviso,
    							 '$objobservaciones1','$objetivoTipo' )";

        // Preparar la sentencia
        //echo "<br> $comando <br>";
        $sentencia = Database::getInstance()->getDb()->prepare($comando);

        return $sentencia->execute(array($FechaDesdeVig, $FechaHastaVig, $fraccion,$FraccionTipo,
                  $fraccionTiempo,$montoObjetivo, $montoAviso,$objobservaciones1,$objetivoTipo  ));

    }


    public static function insertaSubObjetivo($idobjetivo,$idsubobjetivo,$monedasubobj,
    									$mediopagosubobj,$fraccionsubobj,$fraccionTotsubobj )
    {
        // Sentencia INSERT
        $comando = "INSERT INTO gasdetobjetivos(idobjetivo, iddetobjetivo, monedaid, 
        						mediopagoid, fraccionMonto, MontoTotalSubObj)
        			 VALUES ($idobjetivo,$idsubobjetivo,$monedasubobj,
    						  $mediopagosubobj,$fraccionsubobj,$fraccionTotsubobj  )";
        // Preparar la sentencia
       // echo "<br> $comando <br>";
        $sentencia = Database::getInstance()->getDb()->prepare($comando);
        return $sentencia->execute(
            array($idobjetivo,$idsubobjetivo,$monedasubobj,
    			   $mediopagosubobj,$fraccionsubobj,$fraccionTotsubobj ));
    }

    /**
     * Eliminar el registro con el identificador especificado
     *
     * @return bool Respuesta de la eliminaci�n
     */
    public static function delete($idobjetivo)
    {
        // Sentencia DELETE
        $comando = "DELETE FROM gasobjetivos 
			        WHERE idobjetivo=$idobjetivo";
        // Preparar la sentencia
        $sentencia = Database::getInstance()->getDb()->prepare($comando);

        return $sentencia->execute(array($idobjetivo));
    }



    public static function deleteSubObjetivo($idobjetivo)
    {
        // Sentencia DELETE
        $comando = "DELETE FROM gasdetobjetivos 
			        WHERE idobjetivo=$idobjetivo";
        // Preparar la sentencia
        $sentencia = Database::getInstance()->getDb()->prepare($comando);

        return $sentencia->execute(array($idobjetivo));
    }



}

?>