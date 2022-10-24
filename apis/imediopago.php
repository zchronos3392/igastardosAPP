<?php
/**
 * Obtiene todas los Colegios de la base de datos
 */
require ('MediosPago.php');
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
						$MediosPago = MediosPago::getAll();
				    else
					    $MediosPago = MediosPago::getById($filtro);

					break;

		case "PUT":
					 $nombre=""; // en cero no hace nada, en 1 achica la lista
				     if(isset($_GET['mpagonombre']))  $nombre = $_GET['mpagonombre'];
				     if(isset($_POST['mpagonombre']))  $nombre = $_POST['mpagonombre'];

					 $nombreabrev=""; // en cero no hace nada, en 1 achica la lista
				     if(isset($_GET['mediopagoabrev']))  $nombreabrev = $_GET['mediopagoabrev'];
				     if(isset($_POST['mediopagoabrev']))  $nombreabrev = $_POST['mediopagoabrev'];
						$MediosPago = MediosPago::insert($nombre,$nombreabrev);			
					break;					
		case "DEL":
						$MediosPago = MediosPago::delete($filtro);			
					break;										


	}
								
    $datos["estado"] = 0;	
		    
		    
	    if ($MediosPago) 
	    {
			//Array ( [0] => Array ( [idclub] => 4 [nombre] => BOCAb [clubabr] => BJR ) )
	        $datos["estado"] = 1;
	        $datos["MediosPago"] = $MediosPago;//es un array
	        //el print lo puedo usar para cuando lo llamo desde android
	    }
	print json_encode($datos); 	
}

?>
