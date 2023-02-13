<?php
/**
 * Obtiene todas los Colegios de la base de datos
 */
require ('Negocios.php');
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
						$Comercios = Comercios::getAll();
				    else
					    $Comercios = Comercios::getById($filtro);

					break;
		case "XGET":
					$Comercios = Comercios::getAllxFiltro($filtro);

					break;					
		case "PUT":
					 $nombre=""; // en cero no hace nada, en 1 achica la lista
				     if(isset($_GET['comnombre']))  $nombre = $_GET['comnombre'];
				     if(isset($_POST['comnombre']))  $nombre = $_POST['comnombre'];

					 $tipo=""; // en cero no hace nada, en 1 achica la lista
				     if(isset($_GET['ctipo']))  $tipo = $_GET['ctipo'];
				     if(isset($_POST['ctipo']))  $tipo = $_POST['ctipo'];

					 $comercioid=0; // en cero no hace nada, en 1 achica la lista
				     if(isset($_GET['cID']))  $comercioid = $_GET['cID'];
				     if(isset($_POST['cID']))  $comercioid = $_POST['cID'];

						if($comercioid == 0)
							$Comercios = Comercios::insert($nombre,$tipo);
						else
							$Comercios = Comercios::update($comercioid,$nombre,$tipo);
					break;					
		case "DEL":
						$Comercios = Comercios::delete($filtro);			
					break;										
	}
								
    $datos["estado"] = 0;	
		    
		    
	    if ($Comercios) 
	    {
			//Array ( [0] => Array ( [idclub] => 4 [nombre] => BOCAb [clubabr] => BJR ) )
	        $datos["estado"] = 1;
	        $datos["comercios"] = $Comercios;//es un array
	        //el print lo puedo usar para cuando lo llamo desde android
	    }
	print json_encode($datos); 	
}

?>
