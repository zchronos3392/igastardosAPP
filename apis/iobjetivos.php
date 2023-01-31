<?php
/**
 * Obtiene todas los Colegios de la base de datos
 */
require ('Objetivo.php');
require ('MediosPago.php');

if($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Manejar petici�n GET
//  parametros={"filtro":comercio,"llama":"pedircomercio","funcion":"GET"};
	$filtro ="";// SE SUPONE QUE EN EL FILTRO, VIENE EL OBJETIVO_ID
     if(isset($_GET['filtro']))  $filtro = $_GET['filtro'];
     if(isset($_POST['filtro']))  $filtro = $_POST['filtro'];

	$llamador ="";
     if(isset($_GET['llama']))  $llamador = $_GET['llama'];
     if(isset($_POST['llama']))  $llamador = $_POST['llama'];

	 $funcion=""; // en cero no hace nada, en 1 achica la lista
     if(isset($_GET['funcion']))  $funcion = $_GET['funcion'];
     if(isset($_POST['funcion']))  $funcion = $_POST['funcion'];


	switch($funcion)
	{
		case "GETDET":
						$Objetivos = objetivos::getAll($filtro);
						if( count($Objetivos) > 0)
						{
						//agregar subojbjetivos en objetivos LISTA	
						// Coleccion de SUBOBJETIVOS...
						$subObjetivos = objetivos::getAllSubObjetivos($filtro);
						$Objetivos['0']['SubObjetivos']=$subObjetivos;
						}
						break;
		case "GET":
					$Objetivos = objetivos::getAll($filtro);
						if( count($Objetivos) > 0)
						{
						//agregar subojbjetivos en objetivos LISTA	
						// Coleccion de SUBOBJETIVOS...
						$subObjetivos = objetivos::getAllSubObjetivos($filtro);
						$Objetivos['0']['SubObjetivos']=$subObjetivos;
						// CREANDO VECTOR DE FRACCIONES DE TIEMPO
						$FHasta = new DateTime($Objetivos['0']['FechaHastaVig']);
						//fechas en modo STRING
						//	$FHastaS = "'".$Objetivos['0']['FechaHastaVig']."'";
						//	$FDesdeS = "'".$Objetivos['0']['FechaDesdeVig']."'";
						// Fraccion de tiempo en que quiero dividir el intervalo.
						$fraccionTiempo = $Objetivos['0']['fraccionTiempo'];
						// se crean los intervalos segun la FRACCION
						// Echo " Fraccion  : $fraccionTiempo <br>";
						// $intervalosposibles = $diasCalculados/$fraccionTiempo;
								//($FDesdeS, $FHastaS, 'Y-m-d',$diasCalculados,$fraccionTiempo);
							$begin = new DateTime( $Objetivos['0']['FechaDesdeVig'] );
							$end   = new DateTime( $Objetivos['0']['FechaHastaVig'] );
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
					//ETAPA 1
					//	$MediosPago = MediosPago::getAll();
					//ahora recorro $subObjetivos
						//print_r($MediosPago);
						//RECORRER EL INTERVALO DE FECHAS GENERICO
					foreach ($intervaloFechas as $clave => $FechaAnalisis)
					{
						$contadorMedios = 0;	
						$intervaloMEDIOP =[];	
						foreach ($subObjetivos as $claveSOBX => $subobjetivox)
						//foreach ($MediosPago as $claveMP => $mediopago)
						{
							  $porcentajeAnalisis=objetivos::PorcentajeCumplidoFraccion(
							  		$FechaAnalisis['FechaInicio'],
							  		$FechaAnalisis['FechaFin'],
							  		$subobjetivox['fraccionMonto'],
							  		$subobjetivox['mediopagoid'],
							  		$subobjetivox['monedaid']
							  		
							  );	
							if($porcentajeAnalisis['0']['PORCENTAJE']== '')
								$porcentajeCalculo =0;
							else
								$porcentajeCalculo=$porcentajeAnalisis['0']['PORCENTAJE'];
								
				$intervaloMEDIOP[$contadorMedios]['porcentaje']=$porcentajeCalculo;
				$intervaloMEDIOP[$contadorMedios]['montoTotal']= $porcentajeAnalisis['0']['MONTOTF'];
				$intervaloMEDIOP[$contadorMedios]['medionombre']= $subobjetivox['nombreabrev'];
				$intervaloMEDIOP[$contadorMedios]['monedanombre']= $subobjetivox['abrmoneda'];
				
					$contadorMedios++;
				}
					  $intervaloFechas[$clave]['OBJETIVODETALLE']= $intervaloMEDIOP;
					 // $intervaloFechasX[$mediopago['nombreabrev']]=$intervaloFechas;	
					} // intervalos, calculo a traves de los medios de pago.
					//FIN :: ETAPA 1					
					//ETAPA 2
					  //----------------------------------------
					  //AHORA TRABAJO CON EL INTERVALO TOTAL...
					  //----------------------------------------
					$intervaloCompleto[0]['FechaTotalIni'] = $Objetivos['0']['FechaDesdeVig'];
					$intervaloCompleto[0]['FechaTotalFin'] 	= $Objetivos['0']['FechaHastaVig'];
					$contadorMedios = 0;	
					$intervaloMEDIOP =[];	
					//SOLO TENGO UN FOREACH, PORQUE NO NECESITO RECORRER UN VECTOR DE FECHAS
					// YA QUE SOLO TENGO FECHA INICIO Y FECHA FIN
//						foreach ($MediosPago as $claveMP => $mediopago)
						foreach ($subObjetivos as $claveSOBX => $subobjetivox)
						//foreach ($MediosPago as $claveMP => $mediopago)
						{

//						echo "<br>MEDIO DE PAGO PARA EL CALCULO DEL TOTAL : ".$mediopago['mediopagoid']." <br>";
//						   echo "<br>Inicio ".$Objetivos['0']['FechaDesdeVig']." y fin: ".$Objetivos['0']['FechaHastaVig']."<br>";
							//porque incluye a los extremos..
						  $porcentajeAnalisisTOTAL=objetivos::PorcentajeCumplidoFraccionX(
						  		$Objetivos['0']['FechaDesdeVig'],
						  		$Objetivos['0']['FechaHastaVig'],
							  	$subobjetivox['MontoTotalSubObj'],
							  	$subobjetivox['mediopagoid'],
							  	$subobjetivox['monedaid']
						  );

						if($porcentajeAnalisisTOTAL['0']['PORCENTAJE']== '')
							$porcentajeCalculoTot =0;
						else
							$porcentajeCalculoTot=$porcentajeAnalisisTOTAL['0']['PORCENTAJE'];
//						echo(" -> MONTO TOTAL calculado para ese intervalo ".$porcentajeAnalisisTOTAL['0']['MONTOTF']."<br>");
//echo(" -> PORCENTAJE TOTAL calculado para ese intervalo ".$porcentajeAnalisisTOTAL['0']['PORCENTAJE']."<br><br>");								
					$intervaloMEDIOP[$contadorMedios]['porcentajeTotal']  
							= $porcentajeCalculoTot;
					$intervaloMEDIOP[$contadorMedios]['montoTotal']  
							= $porcentajeAnalisisTOTAL['0']['MONTOTF'];
					$intervaloMEDIOP[$contadorMedios]['medionombre']  
							= $subobjetivox['nombreabrev'];
					$intervaloMEDIOP[$contadorMedios]['monedanombre']
							= $subobjetivox['abrmoneda'];
						$contadorMedios++;
					//$intervaloCompletoMP[$mediopago['nombreabrev']]= $intervaloCompleto;
						 } //medio de pago monto por objetivo completo						
					
				  $intervaloCompleto[0]['OBJETIVODETALLE']= $intervaloMEDIOP;
				
				//----------------------------------------------------
				//	AHORA TRABAJO CON EL INTERVALO TOTAL...
				//-----------------------------------------------------
	              } // hay objetivos cargados...						
	
					break;

		case "PUT":
		
					$FechaDesdeVig="";
					     if(isset($_GET['FechaDesdeVig']))  $FechaDesdeVig = $_GET['FechaDesdeVig'];
					     if(isset($_POST['FechaDesdeVig'])) $FechaDesdeVig = $_POST['FechaDesdeVig'];
					$FechaHastaVig="";
					     if(isset($_GET['FechaHastaVig']))  $FechaHastaVig = $_GET['FechaHastaVig'];
					     if(isset($_POST['FechaHastaVig'])) $FechaHastaVig = $_POST['FechaHastaVig'];
					$fraccion=0;
					     if(isset($_GET['fraccion']))  $fraccion = $_GET['fraccion'];
					     if(isset($_POST['fraccion'])) $fraccion = $_POST['fraccion'];
					$fraccionTiempo=0;
					     if(isset($_GET['fraccionTiempo']))  $fraccionTiempo = $_GET['fraccionTiempo'];
					     if(isset($_POST['fraccionTiempo'])) $fraccionTiempo = $_POST['fraccionTiempo'];

					$FraccionTipo="";
					     if(isset($_GET['fraccionTipo']))  $FraccionTipo = $_GET['fraccionTipo'];
					     if(isset($_POST['fraccionTipo'])) $FraccionTipo = $_POST['fraccionTipo'];

					$montoObjetivo=0;
					    // if(isset($_GET['montoobjetivo']))  $montoObjetivo = $_GET['montoobjetivo'];
					    // if(isset($_POST['montoobjetivo'])) $montoObjetivo = $_POST['montoobjetivo'];

					$montoAviso=0;
					     if(isset($_GET['montocontrol']))  $montoAviso = $_GET['montocontrol'];
					     if(isset($_POST['montocontrol'])) $montoAviso = $_POST['montocontrol'];

					$objobservaciones1="";
					     if(isset($_GET['objobservaciones1']))  
					     			$objobservaciones1 = $_GET['objobservaciones1'];
					     if(isset($_POST['objobservaciones1'])) 
					     			$objobservaciones1 = $_POST['objobservaciones1'];

					$objetivoTipo="";		
					     if(isset($_GET['objetivoTipo']))  $objetivoTipo = $_GET['objetivoTipo'];
					     if(isset($_POST['objetivoTipo'])) $objetivoTipo = $_POST['objetivoTipo'];
					     

						$Objetivos = objetivos::insert($FechaDesdeVig, $FechaHastaVig, $fraccion,
													$fraccionTiempo,$FraccionTipo,$montoObjetivo,
													$montoAviso,$objobservaciones1,$objetivoTipo );

						$i_idobjetivo= objetivos::getLastId();
						$idobjetivo = 0;
						$idobjetivo = (int)$i_idobjetivo['idobjetivo'];


						$items = "";
							if(isset($_GET['subObjetivos']))  $items = $_GET['subObjetivos'];
							if(isset($_POST['subObjetivos']))  $items = $_POST['subObjetivos'];
							for($i=1;$i<count($items);$i++)
							{
								$idsubobjetivo = 	$items[$i]["idsubobjetivo"]	;
								$monedasubobj 		= 	$items[$i]["monedasubobj"];
								$mediopagosubobj		=	$items[$i]["mediopagosubobj"];
								$fraccionsubobj		=	(int)$items[$i]["fraccionsubobj"];
								$fraccionTotsubobj		=	(int)$items[$i]["fraccTotsubobj"];
								//$idobjetivo
								objetivos::insertaSubObjetivo($idobjetivo,$idsubobjetivo,
															  $monedasubobj,$mediopagosubobj,
															  $fraccionsubobj,$fraccionTotsubobj);
							};	
													
					break;					
		case "DEL":
						$Objetivos = objetivos::deleteSubObjetivo($filtro);
						$Objetivos = objetivos::delete($filtro);			
					break;										
		case "UPD":
		             //$fraccionTiempo
		            $idobjetivo =0;
					     if(isset($_GET['idobjetivo']))  $idobjetivo = $_GET['idobjetivo'];
					     if(isset($_POST['idobjetivo'])) $idobjetivo = $_POST['idobjetivo'];
		             
					$FechaDesdeVig="";
					     if(isset($_GET['FechaDesdeVig']))  $FechaDesdeVig = $_GET['FechaDesdeVig'];
					     if(isset($_POST['FechaDesdeVig'])) $FechaDesdeVig = $_POST['FechaDesdeVig'];
					$FechaHastaVig="";
					     if(isset($_GET['FechaHastaVig']))  $FechaHastaVig = $_GET['FechaHastaVig'];
					     if(isset($_POST['FechaHastaVig'])) $FechaHastaVig = $_POST['FechaHastaVig'];
					
					$fraccion=0;
					     if(isset($_GET['fraccion']))  $fraccion = $_GET['fraccion'];
					     if(isset($_POST['fraccion'])) $fraccion = $_POST['fraccion'];
					$fraccionTiempo=0;
					if(isset($_GET['fraccionTiempo']))  $fraccionTiempo = $_GET['fraccionTiempo'];
					if(isset($_POST['fraccionTiempo'])) $fraccionTiempo = $_POST['fraccionTiempo'];

					$FraccionTipo="";
					     if(isset($_GET['fraccionTipo']))  $FraccionTipo = $_GET['fraccionTipo'];
					     if(isset($_POST['fraccionTipo'])) $FraccionTipo = $_POST['fraccionTipo'];

					$montoObjetivo=0;
					     //if(isset($_GET['montoobjetivo']))  $montoObjetivo = $_GET['montoobjetivo'];
					     //if(isset($_POST['montoobjetivo'])) $montoObjetivo = $_POST['montoobjetivo'];

					$montoAviso=0;
					     if(isset($_GET['montocontrol']))  $montoAviso = $_GET['montocontrol'];
					     if(isset($_POST['montocontrol'])) $montoAviso = $_POST['montocontrol'];

					$objobservaciones1="";
					     if(isset($_GET['objobservaciones1']))  
					     			$objobservaciones1 = $_GET['objobservaciones1'];
					     if(isset($_POST['objobservaciones1'])) 
					     			$objobservaciones1 = $_POST['objobservaciones1'];

					$objetivoTipo="";		
					     if(isset($_GET['objetivoTipo']))  $objetivoTipo = $_GET['objetivoTipo'];
					     if(isset($_POST['objetivoTipo'])) $objetivoTipo = $_POST['objetivoTipo'];
					 
						$Objetivos = objetivos::update($idobjetivo,$FechaDesdeVig, $FechaHastaVig,
													   $fraccion,$fraccionTiempo,$FraccionTipo,
													   $montoObjetivo,$montoAviso,$objobservaciones1,
													   $objetivoTipo );
						$items = "";
							if(isset($_GET['subObjetivos']))  $items = $_GET['subObjetivos'];
							if(isset($_POST['subObjetivos']))  $items = $_POST['subObjetivos'];
							
							objetivos::deleteSubObjetivo($idobjetivo);
							
							for($i=1;$i<count($items);$i++)
							{
								$idsubobjetivo = 	(int)$items[$i]["idsubobjetivo"]	;
								$monedasubobj 		= 	(int)$items[$i]["monedasubobj"];
								$mediopagosubobj		=	(int)$items[$i]["mediopagosubobj"];
								$fraccionsubobj		=	(int)$items[$i]["fraccionsubobj"];
								$fraccionTotsubobj		=	(int)$items[$i]["fraccTotsubobj"];
								//$idobjetivo
								objetivos::insertaSubObjetivo($idobjetivo,$idsubobjetivo,
															  $monedasubobj,$mediopagosubobj,
															  $fraccionsubobj,$fraccionTotsubobj);
								
							};	

	}
								
    $datos["estado"] = 0;	
		    
		    
	    if ($Objetivos) 
	    {
			//Array ( [0] => Array ( [idclub] => 4 [nombre] => BOCAb [clubabr] => BJR ) )
	        $datos["estado"] = 1;
	        $datos["Objetivos"] = $Objetivos;//es un array
	        if(isset($intervaloFechas))
		        $datos["xFracciones"] = $intervaloFechas;// $intervaloFechas;
			if(isset($intervaloCompleto))
		        $datos["xCompleto"] = $intervaloCompleto;
	        //el print lo puedo usar para cuando lo llamo desde android
	    }
	print json_encode($datos); 	

}

/*
function getRangeDate($date_ini, $date_end, $format,$diasCalculados,$intervaloFraccion) {


    $dt_ini = DateTime::createFromFormat($format, $date_ini);
    $dt_end = DateTime::createFromFormat($format, $date_end);
    
    $tiempoElegido ='P'.$intervaloFraccion.'D';
    //echo $tiempoElegido;
$periods = new DatePeriod(new DateTime($dt_ini),new DateInterval($tiempoElegido),new DateTime($dt_end));
    $range = [];
    foreach ($periods as $date) {
        $range[] = $date->format($format);
    }
    $range[] = $date_end;
    return $range;
}

*/
?>
