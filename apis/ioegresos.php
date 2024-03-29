<?php
/**
 * Obtiene todas los Colegios de la base de datos
 */
require ('GastosIO.php');
require_once('ObjetosConsumo.php');
require_once('Objetivo.php');


if($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Manejar petici�n GET
//  parametros={"filtro":comercio,"llama":"pedircomercio","funcion":"GET"};
	$filtro ="";
     if(isset($_GET['filtro']))  $filtro = $_GET['filtro'];
     if(isset($_POST['filtro']))  $filtro = $_POST['filtro'];

	$llamador ="";
     if(isset($_GET['llama']))  $llamador = $_GET['llama'];
     if(isset($_POST['llama']))  $llamador = $_POST['llama'];

	 $funcion=""; // en cero no hace nada, en 1 achica la lista
     if(isset($_GET['funcion']))  $funcion = $_GET['funcion'];
     if(isset($_POST['funcion']))  $funcion = $_POST['funcion'];

	$GastosIO=$GastosIOUPD= Array();
	switch($funcion)
	{
		case "XGET":
						$resuultadoBusqueda = iogastos::xgetAll($filtro);
						$html="";	
						if (count($resuultadoBusqueda) > 0) {
						foreach($resuultadoBusqueda as $clave => $valor) {                
							//print_r($valor);
							$html .= '<div><a class="suggest-element" data="'.$valor['gasDescripcion'].'" id="'.$valor['gasDescripcion'].'">'.$valor['gasDescripcion'].'</a></div>';
								    }
						}
						echo $html;
		
					break;
		case "XGETX":
						$GastosIO = iogastos::xgetAll($filtro);
		
					break;

		case "GET":
				 	//if($filtro == 0 || $filtro == 99)
				 		$filtro="";
				 		$ticketidParm=0;
						    if(isset($_GET['filtroTicket']))  $ticketidParm = $_GET['filtroTicket'];
						    if(isset($_POST['filtroTicket'])) $ticketidParm = $_POST['filtroTicket'];
				 		$fechaTickret='';	
				 			if(isset($_GET['gasFecha']))  $fechaTickret = "'".$_GET['gasFecha']."'";
				 			if(isset($_POST['gasFecha'])) $fechaTickret = "'".$_POST['gasFecha']."'";

						$filtroFechaGeneral='';	
							if(isset($_GET['filtroFechaGeneral']))  
								$filtroFechaGeneral = $_GET['filtroFechaGeneral'];
							if(isset($_POST['filtroFechaGeneral']))  
								$filtroFechaGeneral = $_POST['filtroFechaGeneral'];

						$FechaBuscarDde='';
							if(isset($_GET['FechaBuscarDde']))  
								$FechaBuscarDde = $_GET['FechaBuscarDde'];
							if(isset($_POST['FechaBuscarDde']))  
								$FechaBuscarDde = $_POST['FechaBuscarDde'];

						$FechaBuscarHta='';
							if(isset($_GET['FechaBuscarHta']))  
								$FechaBuscarHta = $_GET['FechaBuscarHta'];
							if(isset($_POST['FechaBuscarHta']))  
								$FechaBuscarHta = $_POST['FechaBuscarHta'];

						
						$sonCuotasVal=0;
							if(isset($_GET['SonCuotas']))  
								$sonCuotasVal = $_GET['SonCuotas'];
							if(isset($_POST['SonCuotas']))  
								$sonCuotasVal = $_POST['SonCuotas'];

								
						$productos='';
							if(isset($_GET['productos']))  
								$productos = $_GET['productos'];
							if(isset($_POST['productos']))  
								$productos = $_POST['productos'];
								
						$comercios = 0;		
							if(isset($_GET['comercios']))  
								$comercios = $_GET['comercios'];
							if(isset($_POST['comercios']))  
								$comercios = $_POST['comercios'];
						
						$moneda = 0;		
							if(isset($_GET['moneda']))  
								$moneda = $_GET['moneda'];
							if(isset($_POST['moneda']))  
								$moneda = $_POST['moneda'];

						$mformapago = 0;		
							if(isset($_GET['mformapago']))  
								$mformapago = $_GET['mformapago'];
							if(isset($_POST['mformapago']))  
								$mformapago = $_POST['mformapago'];

						
						if($llamador == 'pedirmod')
							$gastosIOAgrupados = iogastos::getAllAgrupadosFecha($ticketidParm,$fechaTickret);
						else
							$gastosIOAgrupados = iogastos::getAllAgrupados($filtroFechaGeneral,$productos,$comercios,$FechaBuscarDde,$FechaBuscarHta,$sonCuotasVal,$moneda,$mformapago);	
						//echo "<br> TICKETS DETECTADOS:: <BR>";						
						//foreach($gastosIOAgrupados as $clave => $datosCabecera)
						//			print_r($datosCabecera);
						//echo "<br> ::: FIN TICKETS DETECTADOS:: <BR>";	

						
						foreach($gastosIOAgrupados as $clave => $datosAgrupados){
							$fechaTicket = $datosAgrupados['gasFecha'];
							$ticketid    = $datosAgrupados['ticketID'];
//								echo "  <br> parametros: $fechaTicket, $ticketid  <br>";
								$gastosIOCabeceras = iogastos::getTicketById($fechaTicket,$ticketid);
//									echo "<br> INI CABECERA DETECTADA: <BR>";
//										print_r($gastosIOCabeceras);
//									echo "<br> FIN CABECERA DETECTADA: <BR>";
//
								if(is_array($gastosIOCabeceras) && count($gastosIOCabeceras) > 0)
								{
									foreach($gastosIOCabeceras as $clave => $datosCabecera){
										$gastosIODetalles = iogastos::getAllDescripciones($fechaTicket,$ticketid);		
										$datosCabecera['items']=$gastosIODetalles;
										array_push($GastosIO,$datosCabecera);
									}
								}										
						}		
				    //else
					//    $GastosIO = Comercios::getById($filtro);

					break;
		case "PUT":
						// un solo dato
						$numeroCuotasTotal=0;
						     if(isset($_GET['cuotas']))  $numeroCuotasTotal = $_GET['cuotas'];
						     if(isset($_POST['cuotas'])) $numeroCuotasTotal = $_POST['cuotas'];
						//si numero de cuotas es 0 o 1 , no pasa nada, pero si es 
						//mayor a 1, entonces hay que crear varios tickets
						//uno por mes..
						if($numeroCuotasTotal == 0)
						{
							insertarcuotas(0,0,0);
						}	
						else
							{
							  $CuotasTotal=0;	
							    if(isset($_GET['totalCuotas']))  $CuotasTotal = $_GET['totalCuotas'];
								if(isset($_POST['totalCuotas'])) $CuotasTotal = $_POST['totalCuotas'];			
							  $montoDividoCuotas = $CuotasTotal/$numeroCuotasTotal;		
							   	
							  for($i=0;$i<$numeroCuotasTotal;$i++)
							  {
								 insertarcuotas($numeroCuotasTotal,$i,$montoDividoCuotas);	
							  }
						    }	
					break;	
		case "UPD":
						//LAS CUOTAS NO SE ACTUALIZAN..
						$i_ticketID = 0;
						     if(isset($_GET['idticket']))   $i_ticketID = $_GET['idticket'];
						     if(isset($_POST['idticket']))  $i_ticketID = $_POST['idticket'];
						
						//echo " ticket : $i_ticketID, ";
						
						// un solo dato
						$tipoMedioPago=0;
						     if(isset($_GET['mformapago']))  $tipoMedioPago = $_GET['mformapago'];
						     if(isset($_POST['mformapago']))  $tipoMedioPago = $_POST['mformapago'];
						//un solo dato
						$gasFecha="";
						     if(isset($_GET['gasFecha']))  $gasFecha = $_GET['gasFecha'];
						     if(isset($_POST['gasFecha']))  $gasFecha = $_POST['gasFecha'];
/**
* NECESITO TRAER LO QUE HABIA PARA COMPARAR
* 	QUE FALTA...NO LO VUELVO A INGRESAR, 
*   LO QUE NO ESTABA SE INSERTA
*   LO OTRO SE ACTUALIIZA, SEGUN GASID  Y LA CLAVE PRINCIPAL
*/						$gasFechaUPD="'".$gasFecha."'";
						$gastosIOAgrupados = iogastos::getAllAgrupadosFecha($i_ticketID,$gasFechaUPD);
						//$totalCuotas= $gastosIOAgrupados['montoCuota'];
//							echo "<br> TICKETS DETECTADOS:: <BR>";						
//							foreach($gastosIOAgrupados as $clave => $datosCabecera)
//										print_r($datosCabecera);
//							echo "<br> ::: FIN TICKETS DETECTADOS:: <BR>";						
						foreach($gastosIOAgrupados as $clave => $datosAgrupados)
						 {
//									echo "  <br> parametros: $gasFechaUPD, $i_ticketID  <br>";
									$gastosIOCabeceras = iogastos::getTicketById($gasFecha,$i_ticketID);
									$totalCuotas = $gastosIOCabeceras['0']['montoCuota'];	
//										echo "<br> INI CABECERA DETECTADA: <BR>";
//											print_r($gastosIOCabeceras);
//										echo "<br> FIN CABECERA DETECTADA: <BR>";
							if(is_array($gastosIOCabeceras) && count($gastosIOCabeceras) > 0)
							{
							  foreach($gastosIOCabeceras as $clave => $datosCabecera)
							  {
					    $gastosIODetalles = iogastos::getAllDescripciones($gasFecha,$i_ticketID);							$datosCabecera['items']=$gastosIODetalles;
						//	print_r($gastosIODetalles);
								array_push($GastosIOUPD,$datosCabecera);
							   }
							} //recorrer $gastosIOCabeceras , CARGANDO GASTOS , Y SUS ITEMS..										
						 }// recorrer $gastosIOAgrupados
						//echo("DATOS PREVIOS PARA VER QUE CAMBIO..<br>");
						//print_r($GastosIOUPD);	
						/**
						* NECESITO TRAER LO QUE HABIA PARA COMPARAR
						* 	QUE FALTA...NO LO VUELVO A INGRESAR, 
						*   LO QUE NO ESTABA SE INSERTA
						*   LO OTRO SE ACTUALIIZA, SEGUN GASID  Y LA CLAVE PRINCIPAL
						*/						
	
						// un solo dato
						$ComercioId=0;
						     if(isset($_GET['ComercioId']))  $ComercioId = $_GET['ComercioId'];
						     if(isset($_POST['ComercioId']))  $ComercioId = $_POST['ComercioId'];
						//un solo dato
						$monedaId=0;
						     if(isset($_GET['moneda']))  $monedaId = $_GET['moneda'];
						     if(isset($_POST['moneda']))  $monedaId = $_POST['moneda'];

						$tipoMov='';
						if(isset($_GET['tipoMovimiento']))   $tipoMov = $_GET['tipoMovimiento'];
						if(isset($_POST['tipoMovimiento']))  $tipoMov = $_POST['tipoMovimiento'];

						$esGastoFijo=0;
						if(isset($_GET['esGastoFijo']))  $esGastoFijo = $_GET['esGastoFijo'];
						if(isset($_POST['esGastoFijo']))  $esGastoFijo = $_POST['esGastoFijo'];
						     //no se usan aun...
						$gasobservaciones1=$gasobservaciones2="";

					    $descgenDesc="";
						     if(isset($_GET['descgenDesc']))  $descgenDesc = $_GET['descgenDesc'];
						     if(isset($_POST['descgenDesc'])) $descgenDesc = $_POST['descgenDesc'];

					    $descuentogenmonto=0;
						     if(isset($_GET['descuentogenmonto']))  $descuentogenmonto = $_GET['descuentogenmonto'];
						     if(isset($_POST['descuentogenmonto'])) $descuentogenmonto = $_POST['descuentogenmonto'];


						$gasPUnit=0;
						$gasCant=0;
						$descuento=0;
						$unidad=0;
						
						$items = "";
						     if(isset($_GET['items']))  $items = $_GET['items'];
						     if(isset($_POST['items']))  $items = $_POST['items'];
						//print_r($items);
						//echo "<BR>";     
						//echo "<BR>CABECERA LLEGO POR GET: MP: $tipoMedioPago, FECHA: $gasFecha, COM: $ComercioId, MON: $monedaId <BR>";
						//echo "<BR>DETALLE LLEGO POR GET <BR>";
						for($i=1;$i<count($items);$i++){
							$gasid			=   $items[$i]["gasid"];
							$gasDescripcion = 	$items[$i]["descripcion"];
							$gasCant 		= 	$items[$i]["cantidad"];
							$gasPUnit		=	$items[$i]["punitario"];
							$descuento		=	$items[$i]["discount"];
							$unidad			=   $items[$i]["unidad"];
							$recargo		=	(int)$items[$i]["recargo"];
							
						 if($unidad == "") $unidad= 0;
						 if($descuento == "") $descuento=0;
						//echo "<BR>ID:$gasid, DSC: $gasDescripcion, PUNIT:$gasPUnit, CANT: $gasCant, DIS:$descuento <BR>";
							if($gasid == 0)
							{
								//$tipoMov='E';
								$GastosIO = iogastos::insert($i_ticketID,$tipoMedioPago,$gasFecha,$gasDescripcion,$gasPUnit,$gasCant,$unidad,$ComercioId,$monedaId,$descuento,$recargo,$tipoMov,$gasobservaciones1,$gasobservaciones2,$descgenDesc,$descuentogenmonto,$totalCuotas,$esGastoFijo);
							}
							else
							     $GastosIO = iogastos::update($i_ticketID,$gasFecha,$gasid,$tipoMedioPago,$gasDescripcion,$gasPUnit,$gasCant,$unidad,$ComercioId,$monedaId,$descuento,$recargo,$tipoMov,$gasobservaciones1,$gasobservaciones2,$descgenDesc,$descuentogenmonto,$esGastoFijo);
						}
					break;										
		case "DEL":
					$gasFecha = "";
						if(isset($_GET['gasFecha']))   $gasFecha = "'".$_GET['gasFecha']."'";
						if(isset($_POST['gasFecha']))  $gasFecha = "'".$_POST['gasFecha']."'";

							$GastosIO = iogastos::delete($filtro,$gasFecha);
					break;	
		case "iDEL":
					$idrenglon = 0;
						if(isset($_GET['idrenglon']))   $idrenglon = $_GET['idrenglon'];
						if(isset($_POST['idrenglon']))  $idrenglon = $_POST['idrenglon'];

					$i_ticketID = 0;
						if(isset($_GET['idticket']))   $i_ticketID = $_GET['idticket'];
						if(isset($_POST['idticket']))  $i_ticketID = $_POST['idticket'];
						
					$gasFecha = "";
						if(isset($_GET['gasFecha']))   $gasFecha = "'".$_GET['gasFecha']."'";
						if(isset($_POST['gasFecha']))  $gasFecha = "'".$_POST['gasFecha']."'";


							$GastosIO = iogastos::deleteDetalle($i_ticketID,$gasFecha,$idrenglon);
					break;
		case "MESES":						
			$ianio = 0;
			if(isset($_GET['ianio']))   $ianio = $_GET['ianio'];
			if(isset($_POST['ianio']))  $ianio = $_POST['ianio'];

			$GastosIO = iogastos::mesesCargados($ianio);
			break;

		case "RESUMES":						
				$ianio = 0;
				if(isset($_GET['ianio']))   $ianio = $_GET['ianio'];
				if(isset($_POST['ianio']))  $ianio = $_POST['ianio'];
	
				$imes=0;
				if(isset($_GET['imes']))   $imes = $_GET['imes'];
				if(isset($_POST['imes']))  $imes = $_POST['imes'];

				$imedioPago=0;
				if(isset($_GET['mformapago']))   $imedioPago = $_GET['mformapago'];
				if(isset($_POST['mformapago']))  $imedioPago = $_POST['mformapago'];




				$resumenObtenidoI = iogastos::ResuMesIngreso($ianio,$imes);
				$resumenObtenidoE = iogastos::ResuMesEgreso($ianio,$imes);				
				//echo "Egresos <br>";
				//print_r($resumenObtenidoE);
				//  echo "<br> Ingresos: ";
				//  print_r($resumenObtenidoI);
				$resumenProcesado['Ingresos'] = $resumenObtenidoI;
				$resumenProcesado['Egreso']  = $resumenObtenidoE;
				// RESTANTE MES EN EFECTIVO INGRESO - TOTAL GASTOS CASH
				$acumuladoIngreso = $calculoRestanteEfectivo = $acumuladoGasto = 0;
				$monedaCalculo    = '';
				foreach($resumenObtenidoE as $clave => $valor)
				 {                
					if($valor['nombreabrev'] == 'CASH')
						$acumuladoGasto += $valor['Monto'];
					//$html .= '<div><a class="suggest-element" data="'.$valor['gasDescripcion'].'" id="'.$valor['gasDescripcion'].'">'.$valor['gasDescripcion'].'</a></div>';
				}

				foreach($resumenObtenidoI as $clave => $valor)
				{                
					$acumuladoIngreso += $valor['Monto']; 
						$monedaCalculo    = $valor['moneda'];
				}

				$calculoRestanteEfectivo = $acumuladoIngreso - $acumuladoGasto; 

				$resumenProcesado['RestanteEFE'] =  round($calculoRestanteEfectivo,2);
				$resumenProcesado['RestanteEFEMON'] = $monedaCalculo;

				 $Semanas = [];
				 $iObjetivos = iogastos::ResuMesEgresoSemana($ianio,$imes);

				 // FECHA INICIAL DEL INTERVALO COMPLETO
				$FDesde = new DateTime( $iObjetivos['0']['FechaDesdeVig'] );
				// FECHA FINAL DEL INTERVALO COMPLETE
				$FHasta   = new DateTime( $iObjetivos['0']['FechaHastaVig'] );
				//echo "Desde : ".$iObjetivos['0']['FechaDesdeVig']." / Hasta: ".$iObjetivos['0']['FechaHastaVig'];	

				// agrego estadisticas acumuladas desde la cabecera: tope de gastos y tope de repetidos en el MES/INTERVALO
					$xTopGastosRepetidos=[];
					$xTopGastosRepetidos= iogastos::TopGastosRepetidos
						(
							$iObjetivos['0']['FechaDesdeVig'],
							$iObjetivos['0']['FechaHastaVig'],
							0,
							0,
							10
						);
						$resumenProcesado['xTopGastosRepetido'][]=$xTopGastosRepetidos;	
					// echo " ----------------------------------------------------------------------------------------------------------------------------";	
					$xTopGastosGrandes=[];
					$xTopGastosGrandes= iogastos::TopGastosGrandes
						(
							$iObjetivos['0']['FechaDesdeVig'],
							$iObjetivos['0']['FechaHastaVig'],
							0,
							0,
							10
						);
						$resumenProcesado['xTopGastosGrandes'][]=$xTopGastosGrandes;	
					// agrego estadisticas acumuladas desde la cabecera: tope de gastos y tope de repetidos en el MES/INTERVALO

				 $Semanas = creaIntervaloSemanas($iObjetivos); 
					// $Semanas = segun objetivos, las semanas que estan incluidas
					//ETAPA 1
					// Recorro $iObjetivos
					//RECORRER EL INTERVALO DE FECHAS GENERICO
					// $Semanas reemplaza a $intervaloFechas
					foreach ($Semanas as $clave => $FechaAnalisis)
					{
						$contadorMedios = 0;	
						$intervaloMEDIOP =[];
						// $iObjetivos reemplaza a $subObjetivos	
						foreach ($iObjetivos as $claveSOBX => $subobjetivox)
						{
							  $porcentajeAnalisis=objetivos::PorcentajeCumplidoFraccion
							  		(
										$FechaAnalisis['FechaInicio'],
										$FechaAnalisis['FechaFin'],
										$subobjetivox['fraccionMonto'],
										$subobjetivox['mediopagoid'],
										$subobjetivox['monedaid']
							  		);	
								// ajuste poor sino encuentra nada o no hay valores cargados			
								if($porcentajeAnalisis['0']['PORCENTAJE']== '')
									$porcentajeCalculo =0;
								else
									$porcentajeCalculo=$porcentajeAnalisis['0']['PORCENTAJE'];
								// ajuste poor sino encuentra nada o no hay valores cargados			

								$intervaloMEDIOP[$contadorMedios]['porcentaje']=$porcentajeCalculo;
								$intervaloMEDIOP[$contadorMedios]['montoTotal']= round($porcentajeAnalisis['0']['MONTOTF'],2);
								$intervaloMEDIOP[$contadorMedios]['medionombre']= $subobjetivox['nombreabrev'];
								$intervaloMEDIOP[$contadorMedios]['monedanombre']= $subobjetivox['abrmoneda'];
								$intervaloMEDIOP[$contadorMedios]['montoFraccion']= $subobjetivox['fraccionMonto'];
								//POR FRACCION, CALCULO EL GASTO ACUMULADO POR COMERCIO Y MONEDA
								$TopGastosRepetidos=[];
								// echo " ----------------------------------------------------------------------------------------------------------------------------";	
								$TopGastosRepetidos= iogastos::TopGastosRepetidos
									(
										$FechaAnalisis['FechaInicio'],
										$FechaAnalisis['FechaFin'],
										$subobjetivox['monedaid'],
										$imedioPago,
										5
									);
								// agregara los gastos acumulados por semana
								$intervaloMEDIOP[$contadorMedios]['TopGastosRepetido'][]=$TopGastosRepetidos;	
								// echo " ----------------------------------------------------------------------------------------------------------------------------";	
								$TopGastosGrandes=[];
								// echo " ----------------------------------------------------------------------------------------------------------------------------";	
								$TopGastosGrandes= iogastos::TopGastosGrandes
									(
										$FechaAnalisis['FechaInicio'],
										$FechaAnalisis['FechaFin'],
										$subobjetivox['monedaid'],
										$imedioPago,
										5
									);
								$intervaloMEDIOP[$contadorMedios]['TopGastosGrandes'][]=$TopGastosGrandes;	
								// echo " ----------------------------------------------------------------------------------------------------------------------------";	

								$GastosxComercio=[];
								// echo " ----------------------------------------------------------------------------------------------------------------------------";	
								$GastosxComercio= iogastos::calculoGastosxComercio
									(
										$FechaAnalisis['FechaInicio'],
										$FechaAnalisis['FechaFin'],
										$subobjetivox['monedaid'],
										$imedioPago
									);
								// echo " =========================================================================================================================";										
									// print_r($GastosxComercio);
								// echo " =========================================================================================================================";																		
								// echo " ----------------------------------------------------------------------------------------------------------------------------";	
								// agregara los gastos acumulados por semana?	
								$intervaloMEDIOP[$contadorMedios]['GastosDetalle'][]=$GastosxComercio;	
								//POR FRACCION, CALCULO EL GASTO ACUMULADO POR COMERCIO Y MONEDA									
							$contadorMedios++;
						}
					    
						$Semanas[$clave]['OBJETIVODETALLE']= $intervaloMEDIOP;
					} // intervalos, calculo a traves de los medios de pago.
					//FIN :: ETAPA 1					
				//  echo "Semanas ";	
				//  print_r($Semanas);
				$resumenProcesado['Semanas'] = $Semanas;
				$GastosIO = $resumenProcesado;
				break;
	

	};// end of SWITCH
														

								
    $datos["estado"] = 0;	
		    
	if($funcion!= "XGET"){
		
	    if ($GastosIO) 
	    {
			//Array ( [0] => Array ( [idclub] => 4 [nombre] => BOCAb [clubabr] => BJR ) )
			//print_r($GastosIO);
	        $datos["estado"] = 1;
	        $datos["gastos"] = $GastosIO;//es un array
	        //el print lo puedo usar para cuando lo llamo desde android
	    }
		 print json_encode($datos); 	
	}		    
	
} // FIN DEL GET

function insertarcuotas($numeroTotal,$cuotaNumero,$totalCuotas){
	
	$i_ticketID= iogastos::getLastTicket();
	$ultimoTicket = 0;
	$ultimoTicket = (int)$i_ticketID['ticketID'];
	//echo "ultimoi ticket cargado: $ultimoTicket, ";
	$ultimoTicket++;
	//echo "siguiente ticket : $ultimoTicket, ";

	// un solo dato
	$tipoMedioPago=0;
	if(isset($_GET['mformapago']))  $tipoMedioPago = $_GET['mformapago'];
	if(isset($_POST['mformapago']))  $tipoMedioPago = $_POST['mformapago'];
	// un solo dato
	$tipoMov='';
	if(isset($_GET['tipoMovimiento']))   $tipoMov = $_GET['tipoMovimiento'];
	if(isset($_POST['tipoMovimiento']))  $tipoMov = $_POST['tipoMovimiento'];
	//un solo dato
	$gasFecha="";
	if(isset($_GET['gasFecha']))  $gasFecha = $_GET['gasFecha'];
	if(isset($_POST['gasFecha']))  $gasFecha = $_POST['gasFecha'];

	// un solo dato
	$ComercioId=0;
	if(isset($_GET['ComercioId']))  $ComercioId = $_GET['ComercioId'];
	if(isset($_POST['ComercioId']))  $ComercioId = $_POST['ComercioId'];
	//un solo dato
	$monedaId=0;
	if(isset($_GET['moneda']))  $monedaId = $_GET['moneda'];
	if(isset($_POST['moneda']))  $monedaId = $_POST['moneda'];


	$esGastoFijo=0;
	if(isset($_GET['esGastoFijo']))  $esGastoFijo = $_GET['esGastoFijo'];
	if(isset($_POST['esGastoFijo']))  $esGastoFijo = $_POST['esGastoFijo'];

	//no se usan aun...
	$gasobservaciones1=$gasobservaciones2="";
	if($numeroTotal != 0)
	{
	  $gasobservaciones1=" Cuota ".($cuotaNumero+1)." de $numeroTotal, monto: $totalCuotas ";
	  //$gasFecha sumarle al mes el numero de cuota que vino..
			//$fecha_actual = date("d-m-Y");
 		// sumas 1 mes
 		if($cuotaNumero == 0)
			//echo " $gasFecha <br>"; 
			1;
		else{
			//echo date("d-m-Y",strtotime($gasFecha."+ ".$cuotaNumero." month"))."<br>"; 
			$gasFecha = date("Y-m-d",strtotime($gasFecha."+ ".$cuotaNumero." month"));
		}	
		// $totalCuotas 	tendria qe guardarlo aparte...
		//echo " monto de cada cuota : $totalCuotas <br>";
	}
	  
	$descgenDesc="";
	if(isset($_GET['descgenDesc']))  $descgenDesc = $_GET['descgenDesc'];
	if(isset($_POST['descgenDesc'])) $descgenDesc = $_POST['descgenDesc'];

	$descuentogenmonto=0;
	if(isset($_GET['descuentogenmonto']))  $descuentogenmonto = $_GET['descuentogenmonto'];
	if(isset($_POST['descuentogenmonto'])) $descuentogenmonto = $_POST['descuentogenmonto'];

	$gasPUnit=0;
	$gasCant=0;
	$descuento=0;
	$unidad =0;

	$items = "";
	if(isset($_GET['items']))  $items = $_GET['items'];
	if(isset($_POST['items']))  $items = $_POST['items'];
//						print_r($items);
//						echo "<BR>";     
//						echo "<BR>CABECERA: MP: $tipoMedioPago, FECHA: $gasFecha, COM: $ComercioId, MON: $monedaId <BR>";
//						echo "<BR>DETALLE <BR>";
	for($i=1;$i<count($items);$i++)
	{
		$gasDescripcion = 	$items[$i]["descripcion"]	;
		$gasCant 		= 	$items[$i]["cantidad"];
		$gasPUnit		=	$items[$i]["punitario"];
		$descuento		=	(int)$items[$i]["discount"];
		$recargo		=	(int)$items[$i]["recargo"];

		$unidad			=   $items[$i]["unidad"];
		//$tipoMov = 'E';
		if($descuento == "") $descuento=0;
		if($unidad == "") $unidad=0;
		if($i>1) $descuentogenmonto =0;//lo grabo solo una vez...
		//								echo "<BR>DSC: $gasDescripcion, PUNIT:$gasPUnit, CANT: $gasCant, DIS:$descuento , unidad: $unidad <BR>";
		$GastosIO = iogastos::insert($ultimoTicket,$tipoMedioPago,$gasFecha,$gasDescripcion,
									 $gasPUnit,$gasCant,$unidad,$ComercioId,$monedaId,$descuento,
									 $recargo,$tipoMov,$gasobservaciones1,$gasobservaciones2,
									 $descgenDesc,$descuentogenmonto,$totalCuotas,$esGastoFijo);
			$objetosconsumo = gconsObjeto::xgetAll($gasDescripcion);
			if(!count($objetosconsumo)>0) 
			{
//			sino hay coincidencias: 
				$id_consobjeto= gconsObjeto::getLastidObjCons();
				$idconsobjeto = 0;
				if(isset($id_consobjeto['idcnsobjeto']))
					$idconsobjeto = (int)$id_consobjeto['idcnsobjeto'];
				//echo "ultimoi ticket cargado: $ultimoTicket, ";
				$idconsobjeto++;
					 
				$consTipo=""; // en cero no hace nada, en 1 achica la lista
				$ret_objetosconsumo = gconsObjeto::insert($idconsobjeto,$gasDescripcion,$consTipo);
				//echo $ret_objetosconsumo;
			}
									 
	}

}

function creaintervaloSemanas($ListaObjetivos)
{
// --------------------------------------------------------------
// :: INICIO BLOQUE :: CREANDO VECTOR DE FRACCIONES DE TIEMPO
// -----------------------------------------------------------------
$intervaloFechas=[];
if(count($ListaObjetivos) >0){
$FHasta = new DateTime($ListaObjetivos['0']['FechaHastaVig']);
//fechas en modo STRING
//	$FHastaS = "'".$Objetivos['0']['FechaHastaVig']."'";
//	$FDesdeS = "'".$Objetivos['0']['FechaDesdeVig']."'";
// Fraccion de tiempo en que quiero dividir el intervalo.
$fraccionTiempo = $ListaObjetivos['0']['fraccionTiempo'];
// se crean los intervalos segun la FRACCION
// Echo " Fraccion  : $fraccionTiempo <br>";
// $intervalosposibles = $diasCalculados/$fraccionTiempo;
		//($FDesdeS, $FHastaS, 'Y-m-d',$diasCalculados,$fraccionTiempo);
	$begin = new DateTime( $ListaObjetivos['0']['FechaDesdeVig'] );
	$end   = new DateTime( $ListaObjetivos['0']['FechaHastaVig'] );
	$textoCalculo = '+'.$fraccionTiempo.' day';
		$end   = $end->modify( $textoCalculo );
	$textoCalculo = 'P'.$fraccionTiempo.'D';
	$interval = new DateInterval($textoCalculo);
	//echo(" $textoCalculo ");
	$periods = new DatePeriod($begin, $interval ,$end);
	//print_r($periods);
	$range = [];
	foreach ($periods as $date) {
		$range[] = $date->format("Y-m-d");
	}
	$range[count($range)-1] = $FHasta->format("Y-m-d");
	//print_r($range);
	//echo count($range);
	// FIN DEL CALCULO DE INTERVALO DE FECHAS LIMITE
	// creando coleccion con los porcentajes y la data parametrizada
	$intervaloFechas = [];
	
	for($i=0;$i < count($range) ; $i++) {
		//echo $range[$i]." y ".$range[$i+1];
		if($i < count($range)-1)
			$intervaloFechas[$i]['FechaInicio'] = $range[$i];
		if( ($i+1) < count($range) )
			$intervaloFechas[$i]['FechaFin'] 	= $range[$i+1];
	}
	// FIN::creando coleccion con los porcentajes y la data parametrizada
// --------------------------------------------------------------
// :: FIN BLOQUE :: CREANDO VECTOR DE FRACCIONES DE TIEMPO
// -----------------------------------------------------------------
}
return $intervaloFechas;
//print_r($intervaloFechas);

}
?>
