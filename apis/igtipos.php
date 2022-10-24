<?php
/**
 * Obtiene todas los Colegios de la base de datos
 */
require ('TiposTabla.php');
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
				 	if($filtro == '')
						$gTipos = gTipos::getAll();
				    else
					    $gTipos = gTipos::getById($filtro);

					break;
		case "PUT":
					 $tablaPertenece=""; // en cero no hace nada, en 1 achica la lista
				     if(isset($_GET['tablaPertenece']))
				       	$tablaPertenece = $_GET['tablaPertenece'];
				     if(isset($_POST['tablaPertenece'])) 
				     	 $tablaPertenece = $_POST['tablaPertenece'];

					 $descripciontipo=""; // en cero no hace nada, en 1 achica la lista
				     if(isset($_GET['descripciontipo']))
				       	$descripciontipo = $_GET['descripciontipo'];
				     if(isset($_POST['descripciontipo'])) 
				     	 $descripciontipo = $_POST['descripciontipo'];
				     
				     
					$gTipos = gTipos::insert($tablaPertenece, $descripciontipo);			
					break;					
		case "DEL":
					 $tablaPertenece=""; // en cero no hace nada, en 1 achica la lista
				     if(isset($_GET['tablaPertenece']))
				       	$tablaPertenece = $_GET['tablaPertenece'];
				     if(isset($_POST['tablaPertenece'])) 
				     	 $tablaPertenece = $_POST['tablaPertenece'];
		
						$gTipos = gTipos::delete($filtro,$tablaPertenece);			
					break;										
					
	}
								
    $datos["estado"] = 0;	
		    
		    
	    if ($gTipos) 
	    {
			//Array ( [0] => Array ( [idclub] => 4 [nombre] => BOCAb [clubabr] => BJR ) )
	        $datos["estado"] = 1;
	        $datos["GTipos"] = $gTipos;//es un array
	        //el print lo puedo usar para cuando lo llamo desde android
	    }
	print json_encode($datos); 	
}

?>
