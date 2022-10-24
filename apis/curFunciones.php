<?php
session_start();
define('__ROOT__', dirname(dirname(__FILE__)));

	$llamador ="";
     if(isset($_GET['llamador']))  $llamador = $_GET['llamador'];
     if(isset($_POST['llamador']))  $llamador = $_POST['llamador'];

	 $funcion=""; // en cero no hace nada, en 1 achica la lista
     if(isset($_GET['funcion']))  $funcion = $_GET['funcion'];
     if(isset($_POST['funcion']))  $funcion = $_POST['funcion'];

switch($funcion){
	case "grabarsesion":
						$_SESSION[$_GET['clave']] = $_GET['valorSesion'];
						break;									
	case "leersesion":if(isset($_GET['clave']))
							if(isset($_SESSION[$_GET['clave']]))
								echo  trim($_SESSION[$_GET['clave']]);
							else
							  echo "";
						break;
				}
				


?>