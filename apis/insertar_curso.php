<?php
/**
 * Obtiene todas las Clubs de la base de datos
 */
require ('Curso.php');
if($_SERVER['REQUEST_METHOD'] == 'POST') {
//"cursonombre""cursonivel","cursocolegio"
	$cursonombre="";
	$cursonivel=$cursocolegio=$anioCurso=0;
	
	//año del curso...
	if(isset($_POST['ianio']))
		$anioCurso = $_POST['ianio'];		
	//nombre o codigo del curso
	if(isset($_POST['cursonombre']))
		$cursonombre = $_POST['cursonombre'];	
	
	//nivel id
	if(isset($_POST['cursonivel']))
		$cursonivel = $_POST['cursonivel'];		
	
	//colegio id
	if(isset($_POST['cursocolegio']))
		$cursocolegio = $_POST['cursocolegio'];
    // Insertar Curso
    $retorno = Cursos::insert($anioCurso,$cursocolegio,$cursonivel,$cursonombre);

	if ($retorno) 
	  {
	        $datos["estado"] = 1;
	        //el print lo puedo usar para cuando lo llamo desde android
	  }
	else
	{
		$datos["estado"] = 2;
	    $datos["Cursos"] = array($retorno);//es un array
 	}	
	print json_encode($datos); 	
}

?>
