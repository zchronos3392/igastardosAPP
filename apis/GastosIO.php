<?php

/**
 * Representa el la estructura de las categorias
 * almacenadas en la base de datos
 */
require_once 'database.php';

class iogastos
{
    function __construct()
    {
    }

    /**
     * Retorna en la fila especificada de la tabla 'vappCategoria'
     *
     * @param $idCategoria Identificador del registro
     * @return array Datos del registro
     */
    public static function getAll($filtro)
    {
    	$filtro="";
        $consulta = "SELECT gasid,ticketID,gasFecha,neg.descripcionComercio,neg.tipo  ,mon.descripcionmoneda,  mp.nombreabrev, movTipo,
       						gasDescripcion,umed.descripcionumedida, gasPUnit, gasCant,  descuento,
       						EsRecargo,ConceptoDescGen,descuentoGeneral,montoCuota 
	     						FROM gasmovdiarios 
					    	INNER join gasmonedas mon on mon.monedaId = gasmovdiarios.monedaId
					        INNER join gasnegocios neg on neg.ComercioId = gasmovdiarios.ComercioId
					        INNER join gasmediospago mp on mp.mediopagoid = gasmovdiarios.tipoMedioPago
					        left join gasumedidas umed on umed.unidadmedidaid = gasmovdiarios.unidad ";
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

	
    public static function ResuMesIngreso($ianio,$imes)
    {
		$consulta = "SELECT SUM(gasPUnit) as 'Monto' ,gasDescripcion,
		CONCAT(mon.abrmoneda, ' ', mon.descripcionmoneda) As moneda  
		FROM gasmovdiarios
			inner join gasmonedas mon
			 on mon.monedaId = gasmovdiarios.monedaId
		where year(gasFecha) = $ianio
			  and gasmovdiarios.movTipo='I'
			  AND month(gasFecha) = $imes
		GROUP by mon.abrmoneda,descripcionmoneda,gasPUnit,gasDescripcion";
        
		//echo "<br> $consulta<br>";
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
    public static function ResuMesEgreso($ianio,$imes)
    {
		$consulta = "SELECT 
						mp.descripcionmediopago,
						mp.nombreabrev,
						mon.abrmoneda as 'moneda',   
						(
						ROUND(   
						Sum(IF(md.montoCuota <>0,md.montoCuota,md.gasPUnit * md.gasCant +
								(IF(md.EsRecargo = 1, md.descuento,(-1)*(md.descuento))- md.descuentoGeneral)))
						,2)   
						) as 'Monto'
					FROM gasmovdiarios md 
					INNER JOIN gasmonedas mon
						on mon.monedaId = md.monedaId
						INNER JOIN gasmediospago mp
						on mp.mediopagoid = md.tipoMedioPago
					WHERE md.movTipo='E'  AND year(md.gasFecha) = $ianio AND month(md.gasFecha) = $imes
					GROUP BY mp.mediopagoid, md.monedaId,'Monto';";
        
		//echo "<br> $consulta<br>";
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

    public static function ResuMesEgresoSemana($ianio,$imes)
	{
		$consulta = "SELECT fraccionTiempo ,FechaHastaVig,FechaDesdeVig,
							 Det.idobjetivo, Det.monedaid,Det.mediopagoid,Det.fraccionMonto,
							 gasmonedas.abrmoneda,gasmediospago.nombreabrev							 
						FROM gasobjetivos iobj
						inner join gasdetobjetivos Det
						  on Det.idobjetivo = iobj.idobjetivo
						  INNER JOIN gasmonedas
							on gasmonedas.monedaId=Det.monedaid
						INNER JOIN gasmediospago
							on gasmediospago.mediopagoid = Det.mediopagoid 
						 WHERE (month(FechaDesdeVig) = $imes OR month(FechaDesdeVig) = ($imes-1)) 
						   AND (month(FechaHastaVig) = $imes or month(FechaHastaVig) = ($imes+1)) 
						      and year(FechaDesdeVig) = $ianio;";
		// echo "<br> $consulta<br>";
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


public static function TopGastosRepetidos($FechaInicio,$FechaFin,$monedaid,$imedioPago,$tope)
{
		// por el momento  filtro por monedaID
		// ESTA TRAYENDO LOS MONTOS DE LAS TARJETAS TODAS LAS SEMANAS DEL MES...
		
		$filtroExtra = "";
		
		if($imedioPago != 0)
			$filtroExtra = "and md.tipoMedioPago = $imedioPago ";

	
	$consulta = "	SELECT  md.gasDescripcion, count(md.gasDescripcion) as 'Conteo', 
						( ROUND( Sum(IF(md.montoCuota <>0,md.montoCuota,md.gasPUnit * md.gasCant + (IF(md.EsRecargo = 1, md.descuento,(-1)*(md.descuento))- md.descuentoGeneral))) ,2) ) as 'Monto' 
					FROM gasmovdiarios md
					WHERE md.movTipo='E'  AND md.gasFecha >='$FechaInicio'  AND md.gasFecha < '$FechaFin'
					$filtroExtra
					GROUP BY md.gasDescripcion
					ORDER by count(md.gasDescripcion) desc  LIMIT $tope;";
	//   ECHO "<BR> $consulta <BR>";
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

public static function TopGastosGrandes($FechaInicio,$FechaFin,$monedaid,$imedioPago,$tope)
{
		// por el momento  filtro por monedaID
		// ESTA TRAYENDO LOS MONTOS DE LAS TARJETAS TODAS LAS SEMANAS DEL MES...
		
		$filtroExtra = "";
		
		if($imedioPago != 0)
			$filtroExtra = "and md.tipoMedioPago = $imedioPago ";

	
	$consulta = "SELECT  md.gasDescripcion, count(md.gasDescripcion) as 'Conteo', 
					( ROUND( Sum(IF(md.montoCuota <>0,md.montoCuota,md.gasPUnit * md.gasCant + (IF(md.EsRecargo = 1, md.descuento,(-1)*(md.descuento))- md.descuentoGeneral))) ,2) ) as 'Monto' 
				FROM gasmovdiarios md
				WHERE md.movTipo='E'
				AND md.gasFecha >='2023-01-26'
				AND md.gasFecha < '2023-02-28'
				$filtroExtra
				GROUP BY md.gasDescripcion,'Monto'  
				ORDER BY `Monto`  DESC limit $tope";
	//   ECHO "<BR> $consulta <BR>";
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

    public static function calculoGastosxComercio($FechaInicio,$FechaFin,$monedaid,$imedioPago)
	{
			// por el momento  filtro por monedaID
			// ESTA TRAYENDO LOS MONTOS DE LAS TARJETAS TODAS LAS SEMANAS DEL MES...
			
			$filtroExtra = "";
			
			if($imedioPago != 0)
				$filtroExtra = "and md.tipoMedioPago = $imedioPago ";
	
			$consulta = "SELECT 
					    md.gasFecha,negocios.descripcionComercio,
						mp.nombreabrev,
						mon.abrmoneda as 'moneda',   
						(
						ROUND(   
							Sum(IF(md.montoCuota <>0,md.montoCuota,md.gasPUnit * md.gasCant +
							(IF(md.EsRecargo = 1, md.descuento,(-1)*(md.descuento))- md.descuentoGeneral)))
							,2) ) as 'Monto'
						FROM gasmovdiarios md 
						INNER JOIN gasmonedas mon
						on mon.monedaId = md.monedaId
						INNER JOIN gasmediospago mp
							on mp.mediopagoid = md.tipoMedioPago 
						INNER JOIN gasnegocios negocios
						on negocios.ComercioId = md.ComercioId
						WHERE md.movTipo='E'  AND md.gasFecha >='$FechaInicio'  AND md.gasFecha < '$FechaFin'
						$filtroExtra 
						GROUP BY md.gasFecha,mp.nombreabrev,md.ComercioId, md.monedaId,'Monto';";
		//   ECHO "<BR> $consulta <BR>";
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

    public static function mesesCargados($ianio)
    {
        $consulta = "SELECT DISTINCT MONTH(gasFecha) as 'MesVal' ,
						 ELT(MONTH(gasFecha), 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
						 	 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre')
							  as 'MesDescripcion'
						FROM gasmovdiarios
							where year(gasFecha) = $ianio;";
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
    
    public static function xgetAll($filtro)
    {
    	$xfiltro="where gasDescripcion like '%$filtro%'";
        $consulta = "SELECT DISTINCT gasDescripcion
	     						FROM gasmovdiarios $xfiltro
	     			ORDER BY gasDescripcion";
        //echo "<br>$consulta<br>";
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
    
    public static function getAllAgrupados($filtroFechaGeneral,$productos,$comercios,
    									   $FechaBuscarDde,$FechaBuscarHta,
    									   $sonCuotasVal,$moneda,$mformapago)
    {
    	$filtro="";
    	$contadorFiltros = 0;
    	
    	if($comercios != '9999'){
    			$filtro=" where ComercioId=$comercios ";
    			$contadorFiltros++;
		}
		//$productos == '9999': seleccione producto..
    	if($productos != '9999'){
    			if($contadorFiltros == 0)
	    			$filtro=" where gasDescripcion = '$productos' ";
	    		else 	
	    			$filtro .=" and  gasDescripcion='$productos' ";
    			$contadorFiltros++;
		}
		
			if($FechaBuscarDde == '' ){

				switch($filtroFechaGeneral)
				{
					case "ESTASEMANA": 
										$FechaCargaHoy = date('Y-m-d H:i:s');
										//resto 7 d�as
										$FechaCargaHoyTexto = date('Y-m-d H:i:s',strtotime($FechaCargaHoy."- 7 days")); 
										$FechaCargaHoyTexto = "'".$FechaCargaHoyTexto."'";
										//$filtro=" and fechaEnHoja >= $FechaCargaHoyTexto ";
										break;
					case "ESTAQUINCENA":
										$FechaCargaHoy = date('Y-m-d H:i:s');
										//resto 7 d�as
										$FechaCargaHoyTexto = date('Y-m-d H:i:s',strtotime($FechaCargaHoy."- 2 weeks")); 
										$FechaCargaHoyTexto = "'".$FechaCargaHoyTexto."'";
										//$filtro=" and fechaEnHoja >= $FechaCargaHoyTexto ";
										 break;
					case "ESTAMES": 
										$FechaCargaHoy = date('Y-m-d H:i:s');
										//resto 7 d�as
										$FechaCargaHoyTexto = date('Y-m-d H:i:s',strtotime($FechaCargaHoy."- 1 month")); 
										$FechaCargaHoyTexto = "'".$FechaCargaHoyTexto."'";
										//$filtro=" and fechaEnHoja >= $FechaCargaHoyTexto ";
										break;
					case "ESTATRESM": 
										$FechaCargaHoy = date('Y-m-d H:i:s');
										//resto 7 d�as
										$FechaCargaHoyTexto = date('Y-m-d H:i:s',strtotime($FechaCargaHoy."- 3 months")); 
										$FechaCargaHoyTexto = "'".$FechaCargaHoyTexto."'";
										//$filtro=" and fechaEnHoja >= $FechaCargaHoyTexto ";
										 break;
					case "ESTASEISM": 
										$FechaCargaHoy = date('Y-m-d H:i:s');
										//resto 7 d�as
										$FechaCargaHoyTexto = date('Y-m-d H:i:s',strtotime($FechaCargaHoy."- 6 months")); 
										$FechaCargaHoyTexto = "'".$FechaCargaHoyTexto."'";
										//$filtro=" and fechaEnHoja >= $FechaCargaHoyTexto ";
										 break;
					case "ESTAANIO": 
										$FechaCargaHoy = date('Y-m-d H:i:s');
										//resto 7 d�as
										$FechaCargaHoyTexto = date('Y-m-d H:i:s',strtotime($FechaCargaHoy."- 1 year")); 
										$FechaCargaHoyTexto = "'".$FechaCargaHoyTexto."'";
										//$filtro=" and fechaEnHoja >= $FechaCargaHoyTexto ";
										 break;
				} 

    	if($filtroFechaGeneral != '0' && $sonCuotasVal == 0){
    			if($contadorFiltros == 0)
	    			$filtro=" where gasFecha >= $FechaCargaHoyTexto ";
	    		else
	    		   {
	    		   	//mostramos,por ahora las fechas de cuotas futuras.
		    			//$filtro .=" and  gasFecha >= $FechaCargaHoyTexto ";
	    			if($sonCuotasVal != 0)
		    			$FechaCargaHoyTexto = "'".$FechaCargaHoy."'"; 
	    			$filtro .=" and  gasFecha >= $FechaCargaHoyTexto ";
				   } 	
    			$contadorFiltros++;
		}

			}
			
	
		

		if($sonCuotasVal == 1){
    			if($contadorFiltros == 0)
	    			$filtro=" where montoCuota != 0 ";
	    		else 	
	    			$filtro .=" and  montoCuota != 0  ";
    			$contadorFiltros++;
		}


    	if($FechaBuscarDde != ''){
    			if($contadorFiltros == 0)
	    			$filtro=" where gasFecha >= '$FechaBuscarDde' 
	    						and gasFecha <= '$FechaBuscarHta' ";
	    		else 	
	    			$filtro .=" and  (gasFecha >= '$FechaBuscarDde'
	    				    	      and gasFecha <= '$FechaBuscarHta') ";
    			$contadorFiltros++;
		}

			
		
    	if($moneda != ''){
    			if($contadorFiltros == 0)
	    			$filtro=" where monedaId = $moneda ";
	    		else 	
	    			$filtro .=" and  monedaId = $moneda ";
    			$contadorFiltros++;
		}

    	if($mformapago != ''){
    			if($contadorFiltros == 0)
	    			$filtro=" where tipoMedioPago = $mformapago ";
	    		else 	
	    			$filtro .=" and  tipoMedioPago = $mformapago ";
    			$contadorFiltros++;
		}
/*
        $consulta = "(SELECT gasFecha,ticketID FROM gasmovdiarios
        						$filtro
        					 and montoCuota <> 0	
							group by gasFecha,ticketID
						ORDER BY gasFecha DESC,ticketID DESC	)
					UNION
					
						(SELECT gasFecha,ticketID FROM gasmovdiarios
        						$filtro
							group by gasFecha,ticketID
						ORDER BY ticketID DESC ) ";
*/
        $consulta = "(SELECT gasFecha,ticketID FROM gasmovdiarios
        						$filtro
							group by gasFecha,ticketID
						ORDER BY gasFecha,ticketID ) ";
       // echo "<br> getAllAgrupados $consulta <br><br>";
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

    public static function getResumen($xcomercio,$xproducto,$xFechaDesde,$xFechaHasta,
						   			  $xmonedaSeleccionada,$xmformapago)
    {

		//echo "getResumen($xcomercio,$xproducto,$xFechaDesde,$xFechaHasta,$xmonedaSeleccionada,$xmformapago)<br>";


		$filtro="";
    	$contadorFiltros = 0;
    	
    	if($xcomercio != '9999'){
    			$filtro=" where gm.ComercioId=$xcomercio ";
    			$contadorFiltros++;
		}
		//$productos == '9999': seleccione producto..
    	if($xproducto != '9999'){
    			if($contadorFiltros == 0)
	    			$filtro=" where gasDescripcion = '$xproducto' ";
	    		else 	
	    			$filtro .=" and  gasDescripcion='$xproducto' ";
    			$contadorFiltros++;
		}
		
    	if($xFechaDesde != ''){
    			if($contadorFiltros == 0)
	    			$filtro=" where gasFecha >= '$xFechaDesde' ";
	    		else 	
	    			$filtro .=" and  gasFecha >= '$xFechaDesde' ";
    			$contadorFiltros++;
		}
		
    	if($xFechaHasta != ''){
    			if($contadorFiltros == 0)
	    			$filtro=" where gasFecha <= '$xFechaHasta' ";
	    		else 	
	    			$filtro .=" and  gasFecha <= '$xFechaHasta' ";
    			$contadorFiltros++;
		}

		if($xmonedaSeleccionada != 0){
    			if($contadorFiltros == 0)
	    			$filtro=" where gm.monedaId = $xmonedaSeleccionada ";
	    		else 	
	    			$filtro .=" and  gm.monedaId = $xmonedaSeleccionada ";
    			$contadorFiltros++;
		}
		
		if($xmformapago != 0){
    			if($contadorFiltros == 0)
	    			$filtro=" where gm.tipoMedioPago = $xmformapago ";
	    		else 	
	    			$filtro .=" and  gm.tipoMedioPago = $xmformapago ";
    			$contadorFiltros++;
		}
        
        
        $consulta = "SELECT gasid, ticketID, gmpa.nombreabrev, gasFecha, montoCuota, movTipo, 
        					gasDescripcion, gumed.nombreAbr, gasPUnit, gasCant,
        					gcoms.descripcionComercio, gmon.abrmoneda, descuento, EsRecargo
        					 FROM gasmovdiarios gm
								 inner join gasmonedas gmon
								    on gmon.monedaId = gm.monedaId
								inner join gasnegocios gcoms
								   on gcoms.ComercioId= gm.ComercioId
								inner join gasmediospago gmpa
								   on gmpa.mediopagoid= gm.tipoMedioPago
								inner join gasumedidas gumed
								   on gumed.unidadmedidaid = gm.unidad
        						$filtro
						ORDER BY gasFecha DESC,ticketID DESC ";
       // echo "<br>  $consulta <br><br>";
		
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute();
			// no se estaba devolviendl el resultado en formato JSON
			// con esta linea se logro...
			// usar en vez de return echo, aunque no se si funcionara con ANDROID
            return $comando->fetchAll(PDO::FETCH_ASSOC);
			//echo json_encode($cmd);

        } catch (PDOException $e) {
            return ($e->getMessage());
        }
		
	}

    public static function getAllAgrupadosFecha($ticketidParm,$gasFecha)
    {
    	$filtro="";
    	if($ticketidParm != 99)
    		$filtro=" where ticketID=$ticketidParm and gasFecha=$gasFecha";
        
        $consulta = "SELECT gasFecha,ticketID FROM gasmovdiarios
        						$filtro
							group by gasFecha,ticketID";
//        echo "<br> getAllAgrupadosFecha $consulta <br><br>";
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
     
     
          
    public static function getTicketById($fechaTicket,$ticketid)
    {
    	$filtro="";
        $consulta = "SELECT gasid,ticketID,gasFecha,gasmovdiarios.ComercioId,neg.descripcionComercio,neg.tipo,gasmovdiarios.monedaId ,mon.descripcionmoneda,mon.abrmoneda,  gasmovdiarios.tipoMedioPago,mp.nombreabrev,gasmovdiarios.unidad ,movTipo,
        umed.descripcionumedida,ConceptoDescGen,descuentoGeneral,montoCuota
	     						FROM gasmovdiarios 
					    	INNER join gasmonedas mon on mon.monedaId = gasmovdiarios.monedaId
					        INNER join gasnegocios neg on neg.ComercioId = gasmovdiarios.ComercioId
					        INNER join gasmediospago mp on mp.mediopagoid = gasmovdiarios.tipoMedioPago
					        left join gasumedidas umed on umed.unidadmedidaid = gasmovdiarios.unidad 
					WHERE gasFecha='$fechaTicket' and ticketID= $ticketid LIMIT 1";
				//echo "<br> $consulta <br>";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($fechaTicket,$ticketid));
			// no se estaba devolviendl el resultado en formato JSON
			// con esta linea se logro...
			// usar en vez de return echo, aunque no se si funcionara con ANDROID
            return $comando->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            return ($e->getMessage());
        }
    }
					//		$gastosIODetalles  = iogastos::getAllDescripciones($fechaTicket,$ticketid);    


    public static function getAllDescripciones($fechaTicket,$ticketid)
    {
    	$filtro="";
        $consulta = "SELECT gasid,gasDescripcion,umed.unidadmedidaid,umed.descripcionumedida, gasPUnit, gasCant,  descuento ,EsRecargo
	     						FROM gasmovdiarios 
					    	INNER join gasmonedas mon on mon.monedaId = gasmovdiarios.monedaId
					        INNER join gasnegocios neg on neg.ComercioId = gasmovdiarios.ComercioId
					        INNER join gasmediospago mp on mp.mediopagoid = gasmovdiarios.tipoMedioPago
					        left join gasumedidas umed on umed.unidadmedidaid = gasmovdiarios.unidad 
					WHERE gasFecha='$fechaTicket' and ticketID= $ticketid ";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($fechaTicket,$ticketid));
			// no se estaba devolviendl el resultado en formato JSON
			// con esta linea se logro...
			// usar en vez de return echo, aunque no se si funcionara con ANDROID
            return $comando->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            return ($e->getMessage());
        }
    }

    public static function getLastTicket()
    {
    	$filtro="";
    	$consulta = "SELECT ticketID FROM gasmovdiarios ORDER BY gasid desc LIMIT 1";
//        $consulta = "SELECT ticketID FROM gasmovdiarios ORDER BY gasFecha desc,ticketID desc LIMIT 1";
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
    
    /**
     * Retorna en la fila especificada de la tabla 'vappCategoria'
     *
     * @param $idCategoria Identificador del registro
     * @return array Datos del registro
     */

        
    
   public static function contar()
    {
    		
        $consulta = "SELECT count(*) FROM gasmovdiarios ";
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
     * Obtiene los campos de una categoria con un identificador
     * determinado
     *
     * @param $idcategoria Identificador de la categoria
     * @return mixed
     */
    public static function getById($gasid)
    {
        // Consulta de la categoria
        $consulta = "SELECT gasid,ticketID,gasFecha,neg.descripcionComercio,neg.tipo  ,mon.descripcionmoneda,  mp.nombreabrev, movTipo,
       						gasDescripcion,umed.descripcionumedida, gasPUnit, gasCant,  descuento, 
	     						EsRecargo,ConceptoDescGen,descuentoGeneral,montoCuota
	     						FROM gasmovdiarios 
					    	INNER join gasmonedas mon on mon.monedaId = gasmovdiarios.monedaId
					        INNER join gasnegocios neg on neg.ComercioId = gasmovdiarios.ComercioId
					        INNER join gasmediospago mp on mp.mediopagoid = gasmovdiarios.tipoMedioPago
					        left join gasumedidas umed on umed.unidadmedidaid = gasmovdiarios.unidad 
					WHERE gasid=$gasid  ";

        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($gasid));
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
     * @param $idcategoria      identificador
     * @param $nombre      nuevo titulo
     * 
     */
    public static function update($i_ticketID,$gasFecha,$gasid,$tipoMedioPago,$gasDescripcion,$gasPUnit,$gasCant,$unidad,$ComercioId,$monedaId,$descuento,$recargo,$tipoMov,$gasobservaciones1,$gasobservaciones2,$descgenDesc,$descuentogenmonto,$esGastoFijo)
    {
        // Creando consulta UPDATE
        $consulta = "UPDATE gasmovdiarios
						set tipoMedioPago = $tipoMedioPago, 
							gasDescripcion = '$gasDescripcion', 
							gasPUnit = $gasPUnit, 
							unidad   = $unidad,
							gasCant = $gasCant, 
							ComercioId = $ComercioId, 
							monedaId = $monedaId, 
							descuento = $descuento, 
							EsRecargo = $recargo,
							esGastoFijo =$esGastoFijo,
							ConceptoDescGen='$descgenDesc',
							descuentoGeneral = $descuentogenmonto,
							movTipo = '$tipoMov',
							gasobservaciones1 = '$gasobservaciones1', 
							gasobservaciones2 = '$gasobservaciones2' 
							WHERE gasFecha = '$gasFecha'
								AND ticketID= $i_ticketID 
								AND gasid = $gasid";
		//echo " <br> $consulta <br>";
        
        // Preparar la sentencia
        $cmd = Database::getInstance()->getDb()->prepare($consulta);
        // Relacionar y ejecutar la sentencia
        $cmd->execute(array($i_ticketID,$gasFecha,$gasid,$tipoMedioPago,$gasDescripcion,
        					$gasPUnit,$gasCant,$unidad,$ComercioId,$monedaId,$descuento,
        					$recargo,$tipoMov,$gasobservaciones1,$gasobservaciones2,
        					$descgenDesc,$descuentogenmonto,$esGastoFijo));
			//echo json_encode($cmd);
			
    }

    /**
     * Insertar un nuevo categoria
     *
     * @param $idcategoria      titulo del nuevo registro
     * @param $nombre descripci�n del nuevo registro
     * @return PDOStatement
     */
    public static function insert($ticketID,$tipoMedioPago,$gasFecha,$gasDescripcion,$gasPUnit,$gasCant,$unidad,$ComercioId,$monedaId,$descuento,$recargo,$movTipo,$gasobservaciones1,$gasobservaciones2,
    $descgenDesc,$descuentogenmonto,$totalCuotas,$esGastoFijo){
        // Sentencia INSERT
         
        $comando = "INSERT INTO gasmovdiarios (ticketID,tipoMedioPago, gasFecha, 
        				gasDescripcion,gasPUnit, gasCant,unidad, ComercioId, monedaId,movTipo,
        				descuento,EsRecargo,gasobservaciones1, gasobservaciones2,
						ConceptoDescGen,descuentoGeneral,montoCuota,esGastoFijo) 
        				VALUES ($ticketID,$tipoMedioPago,'$gasFecha','$gasDescripcion',$gasPUnit,
        					    $gasCant,$unidad,$ComercioId,$monedaId,'$movTipo',$descuento,
        					    $recargo,'$gasobservaciones1','$gasobservaciones2',
        					    '$descgenDesc',$descuentogenmonto,$totalCuotas,$esGastoFijo)";

		//echo " <br> $comando <br>";
        // Preparar la sentencia
        $sentencia = Database::getInstance()->getDb()->prepare($comando);

        return $sentencia->execute(
            array($ticketID,$tipoMedioPago,$gasFecha,$gasDescripcion,$gasPUnit,$gasCant,$unidad,$ComercioId,$monedaId,$descuento,$recargo,$movTipo,$gasobservaciones1,$gasobservaciones2,
    				$descgenDesc,$descuentogenmonto,$totalCuotas,$esGastoFijo));
    				
    }

    /**
     * Eliminar el registro con el identificador especificado
     *
     * @param $idcategoria identificador de la categoria
     * @return bool Respuesta de la eliminaci�n
     */
    public static function delete($idTicket,$gasFecha)
    {
        // Sentencia DELETE
        
        $comando = "DELETE FROM gasmovdiarios 
			        WHERE ticketID=$idTicket and gasFecha=$gasFecha ";
		//echo "<br>$comando <br>";
        // Preparar la sentencia
        $sentencia = Database::getInstance()->getDb()->prepare($comando);

        return $sentencia->execute(array($idTicket,$gasFecha));
    }
    
    public static function deleteDetalle($idTicket,$gasFecha,$idrenglon)
    {
        // Sentencia DELETE
        
        $comando = "DELETE FROM gasmovdiarios 
			        WHERE ticketID=$idTicket and gasFecha=$gasFecha and gasid=$idrenglon";
		//	echo "<br>$comando <br>";
        // Preparar la sentencia
        $sentencia = Database::getInstance()->getDb()->prepare($comando);

        return $sentencia->execute(array($idTicket,$gasFecha,$idrenglon));
    }    
}

?>