<?php
/**
 * Obtiene todas las Clubs de la base de datos
 */
require ('Curso.php');
if($_SERVER['REQUEST_METHOD'] == 'POST') {
//"cursonombre""cursonivel","cursocolegio"
	$idCurso=0;
	
	//año del curso...
	if(isset($_POST['ianio']))
		$anioCurso = $_POST['ianio'];		
	//nombre o codigo del curso
	if(isset($_POST['idcurso']))
		$idCurso = $_POST['idcurso'];	
	
	if(isset($_POST['idColegio']))
		$idColegio = $_POST['idColegio'];		
    // Eliminar Curso
    $retorno = Cursos::delete($anioCurso, $idColegio, $idCurso);

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
