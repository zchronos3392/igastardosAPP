<?php

/**
 * Representa el la estructura de las categorias
 * almacenadas en la base de datos
 */
require_once 'database.php';

class gconsObjeto
{
    function __construct()
    {
    }

/**
* GET LAST ID: NUMERADOR
* 
* @return 
*/
    public static function getLastidObjCons()
    {
    	$filtro="";
    	$consulta = "SELECT idcnsobjeto FROM gasconsumoobjetos ORDER BY idcnsobjeto desc LIMIT 1";

        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute();
			// no se estaba devolviendl el resultado en formato JSON
			// con esta linea se logro...
			// usar en vez de return echo, aunque no se si funcionara con ANDROID
            return $comando->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            return ($e->getMessage());
        }
    }    


    /**
     * Retorna en la fila especificada de la tabla 'vappCategoria'
     *
     * @param $idCategoria Identificador del registro
     * @return array Datos del registro
     */
    public static function getAll()
    {
    	$filtro="";
    	// idcnsobjeto, descripcionObjetoCons, objcnsTipo 
        $consulta = "SELECT idcnsobjeto, descripcionObjetoCons, objcnsTipo 
        				FROM gasconsumoobjetos ";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute();
			// no se estaba devolviendl el resultado en formato JSON
			// con esta linea se logro...
			// usar en vez de return echo, aunque no se si funcionara con ANDROID
            return $comando->fetchAll(PDO::FETCH_ASSOC);
			//echo json_encode($cmd);

        } catch (PDOException $e) {
            return ($e->getMessage());
        }
    }
    
    public static function xgetAll($filtro)
    {
    	$xfiltro="where descripcionObjetoCons like '%$filtro%'";
        $consulta = "SELECT descripcionObjetoCons
	     						FROM gasconsumoobjetos $xfiltro
	     			ORDER BY descripcionObjetoCons";
        //echo "<br>$consulta<br>";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute();
			// no se estaba devolviendl el resultado en formato JSON
			// con esta linea se logro...
			// usar en vez de return echo, aunque no se si funcionara con ANDROID
            return $comando->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            return ($e->getMessage());
        }
    }    

    public static function getAllResumen($filtro,$xpalabraClave)
    {
	$xfiltro="";
  	if($filtro != '9999')
 		   	$xfiltro="where descripcionObjetoCons like '%$filtro%'";
	// este pisa el filtro anterior...	
  	if($xpalabraClave != '')
 		   	$xfiltro="where descripcionObjetoCons like '$xpalabraClave'";

        $consulta = "SELECT descripcionObjetoCons
	     						FROM gasconsumoobjetos $xfiltro
	     			ORDER BY descripcionObjetoCons";
        //echo "<br>$consulta<br>";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute();
			// no se estaba devolviendl el resultado en formato JSON
			// con esta linea se logro...
			// usar en vez de return echo, aunque no se si funcionara con ANDROID
            return $comando->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            return ($e->getMessage());
        }
    }        
    /**
     * Retorna en la fila especificada de la tabla 'vappCategoria'
     *
     * @param $idCategoria Identificador del registro
     * @return array Datos del registro
     */

        
    
   public static function contar()
    {
        // tipoid, tablaPertenece, descripciontipo FROM gastipos WHERE 1
        $consulta = "SELECT count(*) FROM gasconsumoobjetos ";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute();

            return $comando->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            return $e;
        }
    }
    /**
     * Obtiene los campos de una categoria con un identificador
     * determinado
     *
     * @param $idcategoria Identificador de la categoria
     * @return mixed
     */
    public static function getById($idcnsobjeto)
    {
        // tipoid, tablaPertenece, descripciontipo FROM gastipos WHERE 1
        // Consulta de la categoria
        $consulta = " Select idcnsobjeto, descripcionObjetoCons, objcnsTipo 
        				 FROM gasconsumoobjetos
								WHERE idcnsobjeto=$idcnsobjeto  ";

        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($idcnsobjeto));
            // Capturar primera fila del resultado
            return $comando->fetchAll(PDO::FETCH_ASSOC);
            //echo json_encode($row);

        } catch (PDOException $e) {
            // Aquí puedes clasificar el error dependiendo de la excepción
            // para presentarlo en la respuesta Json
            return -1;
        }
    }

    /**
     * Actualiza un registro de la bases de datos basado
     * en los nuevos valores relacionados con un identificador
     *
     * @param $idcategoria      identificador
     * @param $nombre      nuevo titulo
     * 
     */
    public static function update($idcnsobjeto, $descripcionObjetoCons, $objcnsTipo)
    {
        // Creando consulta UPDATE
        $consulta = "UPDATE gasconsumoobjetos
        				SET descripcionObjetoCons ='$descripcionObjetoCons' ,
        					objcnsTipo     = '$objcnsTipo'
        					WHERE idcnsobjeto = $idcnsobjeto";
//		echo "$consulta";
        // Preparar la sentencia
        $cmd = Database::getInstance()->getDb()->prepare($consulta);
        // Relacionar y ejecutar la sentencia
        $cmd->execute(array($idcnsobjeto, $descripcionObjetoCons, $objcnsTipo));

        //return $cmd;
		echo json_encode($cmd);
    }

    /**
     * Insertar un nuevo categoria
     *
     * @param $idcategoria      titulo del nuevo registro
     * @param $nombre descripción del nuevo registro
     * @return PDOStatement
     */
    public static function insert($idcnsobjeto, $descripcionObjetoCons, $objcnsTipo){
        // Sentencia INSERT
        // tipoid, tablaPertenece, descripciontipo FROM gastipos WHERE 1
        $comando = "INSERT INTO gasconsumoobjetos (idcnsobjeto, descripcionObjetoCons, objcnsTipo)
        				VALUES ($idcnsobjeto, '$descripcionObjetoCons', '$objcnsTipo')";
		//echo "<br> $comando <br>";
        // Preparar la sentencia
        $sentencia = Database::getInstance()->getDb()->prepare($comando);
        	return $sentencia->execute(array($idcnsobjeto, $descripcionObjetoCons, $objcnsTipo));
    }

    /**
     * Eliminar el registro con el identificador especificado
     *
     * @param $idcategoria identificador de la categoria
     * @return bool Respuesta de la eliminación
     */
     
    public static function delete($idcnsobjeto)
    {
        // Sentencia DELETE
        $comando = "DELETE FROM gasconsumoobjetos
        					WHERE idcnsobjeto = $idcnsobjeto";


        // Preparar la sentencia
        $sentencia = Database::getInstance()->getDb()->prepare($comando);

        return $sentencia->execute(array($idcnsobjeto));
    }
}
?>

