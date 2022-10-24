<?php
/**
 * Obtiene todas los Colegios de la base de datos
 */
require ('Umedida.php');
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
						$UnidadesMedidas = UnidadesMedidas::getAll();
				    else
					    $UnidadesMedidas = UnidadesMedidas::getById($filtro);

					break;
		case "PUT":
					 $nombre=""; // en cero no hace nada, en 1 achica la lista
				     if(isset($_GET['umednombre']))  $nombre = $_GET['umednombre'];
				     if(isset($_POST['umednombre']))  $nombre = $_POST['umednombre'];
				     
				     
					 $nombreAbr=""; // en cero no hace nada, en 1 achica la lista
				     if(isset($_GET['umednombreabrev']))  $nombreAbr = $_GET['umednombreabrev'];
				     if(isset($_POST['umednombreabrev']))  $nombreAbr = $_POST['umednombreabrev'];
				     
						$UnidadesMedidas = UnidadesMedidas::insert($nombre,$nombreAbr);			
					break;					
		case "DEL":
						$UnidadesMedidas = UnidadesMedidas::delete($filtro);			
					break;										
					
	}
								
    $datos["estado"] = 0;	
		    
		    
	    if ($UnidadesMedidas) 
	    {
			//Array ( [0] => Array ( [idclub] => 4 [nombre] => BOCAb [clubabr] => BJR ) )
	        $datos["estado"] = 1;
	        $datos["UMedidas"] = $UnidadesMedidas;//es un array
	        //el print lo puedo usar para cuando lo llamo desde android
	    }
	print json_encode($datos); 	
}

?>
