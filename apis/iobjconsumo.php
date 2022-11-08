<?php
/**
 * Obtiene todas los Colegios de la base de datos
 */
require('ObjetosConsumo.php');
require_once('GastosIO.php');


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



	switch($funcion)
	{
		case "GET":
				 	if($filtro == 0 || $filtro == 99)
						$objetosconsumo = gconsObjeto::getAll();
				    else
					    $objetosconsumo = gconsObjeto::getById($filtro);
					break;
		case "GETRESUMEN":
						  $xpalabraClave ='';
						  if(isset($_GET['palabraClave']))  $xpalabraClave = $_GET['palabraClave'];
						  if(isset($_POST['palabraClave']))  $xpalabraClave = $_POST['palabraClave'];

						  $xcomercio=0;
					     if(isset($_GET['comercio']))  $xcomercio = $_GET['comercio'];
					     if(isset($_POST['comercio']))  $xcomercio = $_POST['comercio'];

						  $xproducto='';
						     if(isset($_GET['producto']))  $xproducto = $_GET['producto'];
						     if(isset($_POST['producto'])) $xproducto = $_POST['producto'];

						  $xFechaDesde='';
						     if(isset($_GET['FechaDesde']))  $xFechaDesde = $_GET['FechaDesde'];
						     if(isset($_POST['FechaDesde'])) $xFechaDesde = $_POST['FechaDesde'];

						  $xFechaHasta='';
						     if(isset($_GET['FechaHasta']))  $xFechaHasta = $_GET['FechaHasta'];
						     if(isset($_POST['FechaHasta'])) $xFechaHasta = $_POST['FechaHasta'];


						$xmformapago=0;
						     if(isset($_GET['FormaPago']))  $xmformapago = $_GET['FormaPago'];
						     if(isset($_POST['FormaPago'])) $xmformapago = $_POST['FormaPago'];
									
						$xmonedaSeleccionada=0;
						     if(isset($_GET['Moneda']))  $xmonedaSeleccionada = $_GET['Moneda'];
						     if(isset($_POST['Moneda'])) $xmonedaSeleccionada = $_POST['Moneda'];

						  $zobjetosconsumo = gconsObjeto::getAllResumen($xproducto,$xpalabraClave);
						//print_r($zobjetosconsumo);
						$i=0;
						$contadorProductos=0;
						foreach($zobjetosconsumo as $clave => $valor)
						{                
						//$objetosconsumo
						    $Unproducto = $valor['descripcionObjetoCons'];
							//echo "<br>un producto encontrado: $Unproducto <br>";
						   $xobjetosconsumo =  iogastos::getResumen($xcomercio,$Unproducto,
						   											$xFechaDesde,$xFechaHasta,
						   											$xmonedaSeleccionada,
						   											$xmformapago);
							//print_r($xobjetosconsumo);
						foreach($xobjetosconsumo as $keyVal => $dataConsumo)
						{
							if ( $keyVal > 0 && $keyVal < count($xobjetosconsumo) )
							{
							$date1 = new DateTime($xobjetosconsumo[$keyVal]['gasFecha']);
								//echo $xobjetosconsumo[$keyVal]['gasFecha']." <br>"; 
							$offSeter=$keyVal-1;
							$date2 = new DateTime($xobjetosconsumo[$offSeter]['gasFecha']);
								//echo $xobjetosconsumo[$offSeter]['gasFecha']." <br>";
							$diff = $date1->diff($date2);
							// will output 2 days
								//echo "$keyVal ".$diff->days . ' dias <br>';
								$xobjetosconsumo[$keyVal]['UltimaVez']=$diff->days;
							}
							else if($keyVal==0){
								$date1 = new DateTime("now");
								$date2 = new DateTime($xobjetosconsumo[$keyVal]['gasFecha']);
								$diff = $date1->diff($date2);		
										$xobjetosconsumo[$keyVal]['UltimaVez']=$diff->days;
							}

						}
						//print_r($valor['descripcionObjetoCons']);
						
							if(isset($xobjetosconsumo) && count($xobjetosconsumo) > 0)
									$zobjetosconsumo[$clave]['Detalles']=$xobjetosconsumo;
							else
								$zobjetosconsumo[$clave]['Detalles']=-1;		
						} // todos los productos..o el filtrado..
						$objetosconsumo=array();
						$conteoObjetosCons =0;
						foreach($zobjetosconsumo as $clave => $valor)
						{ 
						if(isset($valor['Detalles']) )
						{
						 if($valor['Detalles']!=-1)
						 {
						   $objetosconsumo[$conteoObjetosCons]['descripcionObjetoCons']=$valor['descripcionObjetoCons'];
						   $objetosconsumo[$conteoObjetosCons]['Detalles']=$valor['Detalles'];
						 $conteoObjetosCons++;
						 }	
						}
						}
					break;

		case "XGETX":
						$objetosconsumo = gconsObjeto::xgetAll($filtro);
					break;
					
		case "XGET":
						$resuultadoBusqueda = gconsObjeto::xgetAll($filtro);
						$html="";	
						if (count($resuultadoBusqueda) > 0) {
						foreach($resuultadoBusqueda as $clave => $valor) {                
							//print_r($valor);
							$html .= '<div><a class="suggest-element" data="'.$valor['descripcionObjetoCons'].'" id="'.$valor['descripcionObjetoCons'].'">'.$valor['descripcionObjetoCons'].'</a></div>';
								    }
						}
						echo $html;
		
					break;

		case "PUT":
						$id_consobjeto= gconsObjeto::getLastidObjCons();
						$idconsobjeto = 0;
							$idconsobjeto = (int)$id_consobjeto['ticketID'];
						//echo "ultimoi ticket cargado: $ultimoTicket, ";
						$idconsobjeto++;
					 
					 
					 $dscobjeto=""; // en cero no hace nada, en 1 achica la lista
				     if(isset($_GET['dscobjeto']))  $dscobjeto = $_GET['dscobjeto'];
				     if(isset($_POST['dscobjeto']))  $dscobjeto = $_POST['dscobjeto'];
				     
					 $consTipo=""; // en cero no hace nada, en 1 achica la lista
				     if(isset($_GET['consTipo']))  $consTipo = $_GET['consTipo'];
				     if(isset($_POST['consTipo']))  $consTipo = $_POST['consTipo'];
				     
						$objetosconsumo = gconsObjeto::insert($idconsobjeto,$dscobjeto,$consTipo);			
					break;					
		case "PUTX":
		
					$GastosIO = iogastos::xgetAll($filtro);
					
					foreach($GastosIO as $clave => $datosAgrupados)
					{
						$dscobjeto=""; // en cero no hace nada, en 1 achica la lista
						$dscobjeto = $datosAgrupados['gasDescripcion'];
					
						$id_consobjeto= gconsObjeto::getLastidObjCons();
						$idconsobjeto = 0;
						if(isset($id_consobjeto['idcnsobjeto']))
							$idconsobjeto = (int)$id_consobjeto['idcnsobjeto'];
						//echo "ultimoi ticket cargado: $ultimoTicket, ";
						$idconsobjeto++;
					 
						 $consTipo=""; // en cero no hace nada, en 1 achica la lista
				     
						$objetosconsumo = gconsObjeto::insert($idconsobjeto,$dscobjeto,$consTipo);	
					 }					
					break;					
					
		case "DEL":
					$objetosconsumo = gconsObjeto::delete($filtro);			
					break;
		case "UPD":
					 $idconsobjeto = 0;
					     if(isset($_GET['idconsobjeto']))  $idconsobjeto = $_GET['idconsobjeto'];
					     if(isset($_POST['idconsobjeto']))  $idconsobjeto = $_POST['idconsobjeto'];

					 
					 $dscobjeto=""; // en cero no hace nada, en 1 achica la lista
					     if(isset($_GET['dscobjeto']))  $dscobjeto = $_GET['dscobjeto'];
					     if(isset($_POST['dscobjeto']))  $dscobjeto = $_POST['dscobjeto'];
				     
					 $consTipo=""; // en cero no hace nada, en 1 achica la lista
					     if(isset($_GET['consTipo']))  $consTipo = $_GET['consTipo'];
				    	 if(isset($_POST['consTipo']))  $consTipo = $_POST['consTipo'];

						$objetosconsumo = gconsObjeto::update($idconsobjeto,$dscobjeto,$consTipo);
					break;																									
					
	}
								
    $datos["estado"] = 0;	
		    
	if($funcion!= "XGET")
	{
	    if ($objetosconsumo) 
	    {
			//Array ( [0] => Array ( [idclub] => 4 [nombre] => BOCAb [clubabr] => BJR ) )
	        $datos["estado"] = 1;
	        $datos["ObjCons"] = $objetosconsumo;//es un array
	        //el print lo puedo usar para cuando lo llamo desde android
	    }
		print json_encode($datos); 	
	}

}

?>
