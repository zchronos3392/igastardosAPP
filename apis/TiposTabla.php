<?php

/**
 * Representa el la estructura de las categorias
 * almacenadas en la base de datos
 */
require_once 'database.php';

class gTipos
{
    function __construct()
    {
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
    	// `tipoid`, `tablaPertenece`, `descripciontipo` FROM `gastipos` WHERE 1
        $consulta = "select tipoid,tablaPertenece,descripciontipo FROM gastipos";
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
        $consulta = "SELECT count(*) FROM gastipos ";
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
    public static function getById($tablaPertenece)
    {
        // tipoid, tablaPertenece, descripciontipo FROM gastipos WHERE 1
        // Consulta de la categoria
        $consulta = " Select tipoid,tablaPertenece,descripciontipo FROM gastipos
					WHERE tablaPertenece='$tablaPertenece'  ";

        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($tablaPertenece));
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
    public static function update($tipoid,$tablaPertenece, $descripciontipo)
    {
        // tipoid, tablaPertenece, descripciontipo FROM gastipos WHERE 1
        // Creando consulta UPDATE
        $consulta = "UPDATE gastipos
        				SET descripciontipo ='$descripciontipo' ,
        					WHERE tipoid=$tipoid and
        						tablaPertenece = '$tablaPertenece'";
//		echo "$consulta";
        // Preparar la sentencia
        $cmd = Database::getInstance()->getDb()->prepare($consulta);
        // Relacionar y ejecutar la sentencia
        $cmd->execute(array($tipoid,$tablaPertenece, $descripciontipo));

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
    public static function insert($tablaPertenece, $descripciontipo){
        // Sentencia INSERT
        // tipoid, tablaPertenece, descripciontipo FROM gastipos WHERE 1
        $comando = "INSERT INTO gastipos (tablaPertenece, descripciontipo) 
        				VALUES ('$tablaPertenece', '$descripciontipo')";

        // Preparar la sentencia
        $sentencia = Database::getInstance()->getDb()->prepare($comando);

        return $sentencia->execute(
            array($tablaPertenece, $descripciontipo)
        );

    }

    /**
     * Eliminar el registro con el identificador especificado
     *
     * @param $idcategoria identificador de la categoria
     * @return bool Respuesta de la eliminación
     */
     
    public static function delete($tipoid,$tablaPertenece)
    {
        // Sentencia DELETE
        
        $comando = "DELETE FROM gastipos
        					WHERE tipoid=$tipoid and
        						tablaPertenece = '$tablaPertenece'";


        // Preparar la sentencia
        $sentencia = Database::getInstance()->getDb()->prepare($comando);

        return $sentencia->execute(array($tipoid,$tablaPertenece));
    }
}
?>

