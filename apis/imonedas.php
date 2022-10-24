<?php
/**
 * Obtiene todas los Colegios de la base de datos
 */
require ('Monedas.php');
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
						$Monedas = Moneda::getAll();
				    else
					    $Monedas = Moneda::getById($filtro);

					break;
					
		case "PUT":
					 $nombre=""; // en cero no hace nada, en 1 achica la lista
				     if(isset($_GET['monnombre']))  $nombre = $_GET['monnombre'];
				     if(isset($_POST['monnombre']))  $nombre = $_POST['monnombre'];
				     
					 $abreviatura=""; // en cero no hace nada, en 1 achica la lista
				     if(isset($_GET['abreviatura']))  $abreviatura = $_GET['abreviatura'];
				     if(isset($_POST['abreviatura']))  $abreviatura = $_POST['abreviatura'];

				     
						$Monedas = Moneda::insert($nombre,$abreviatura);			
					break;					
		case "DEL":
						$Monedas = Moneda::delete($filtro);			
					break;										
					
	}
								
    $datos["estado"] = 0;	
		    
		    
	    if ($Monedas) 
	    {
			//Array ( [0] => Array ( [idclub] => 4 [nombre] => BOCAb [clubabr] => BJR ) )
	        $datos["estado"] = 1;
	        $datos["monedas"] = $Monedas;//es un array
	        //el print lo puedo usar para cuando lo llamo desde android
	    }
	print json_encode($datos); 	
}

?>
