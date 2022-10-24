<?php
/**
 * Provee las constantes */
//define("HOSTNAME", "localhost");// Nombre del host
//define("DATABASE", "c0990415_voleyap"); // Nombre de la base de datos
//define("USERNAME", "c0990415_voleyap"); // Nombre del usuario
//define("PASSWORD", "kefaKA24fu"); // Nombre de la constrase�a appvolley

define("HOSTNAME", "localhost");// Nombre del host agregar 3309 para localhost
define("DATABASE", "c0990415_xpensio"); // Nombre de la base de datos
define("USERNAME", "c0990415_voleyap"); // Nombre del usuario
define("PASSWORD", "kefaKA24fu"); // Nombre de la constrase�a appvolley

/**
* CREATE USER 'volleyapp'@'%' IDENTIFIED WITH mysql_native_password AS '***';GRANT SELECT, INSERT, 
* UPDATE, DELETE, FILE ON *.* TO 'volleyapp'@'%' REQUIRE NONE WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0
*  MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;GRANT ALL PRIVILEGES ON `volleyapp`.* 
* TO 'volleyapp'@'%';
* 
*/
/* IMITAR LOS DATOS DE CONEXION A LA BASE EN FEROZO..*/
/*	$dbhost = 'localhost';
	$dbuser = 'c0990415_voleyap';
	$dbpass = 'kefaKA24fu';
	$dbname = 'c0990415_voleyap';
	$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die ('Ocurrio un error al conectarse al servidor mysql');
	mysql_select_db($dbname);
*/
//host desconocido, no se conoce el HOST..


$connection = @mysqli_connect(HOSTNAME, USERNAME, PASSWORD, DATABASE) or 
			     die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());

//$connection = @mysqli_connect('localhost:3309', 'c0990415_voleyap', 'kefaKA24fu', 'c0990415_voleyap') or 
//			     die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());


//if(!$connection) 
//	$connection = @mysqli_connect('localhost:3309', 'c0990415_voleyap', 'kefaKA24fu', 'c0990415_voleyap') or 
//			     die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());


?>

