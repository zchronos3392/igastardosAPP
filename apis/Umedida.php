<?php

/**
 * Representa el la estructura de las categorias
 * almacenadas en la base de datos
 */
require_once 'database.php';

class UnidadesMedidas
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
        $consulta = "select unidadmedidaid, descripcionumedida,nombreAbr FROM gasumedidas";
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
    		
        $consulta = "SELECT count(*) FROM gasumedidas ";
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
    public static function getById($unidadmedidaid)
    {
        // Consulta de la categoria
        $consulta = " Select unidadmedidaid, descripcionumedida,nombreAbr FROM gasumedidas
					WHERE unidadmedidaid=$unidadmedidaid  ";

        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($unidadmedidaid));
            // Capturar primera fila del resultado
            $row = $comando->fetch(PDO::FETCH_ASSOC);
            return $row;
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
    public static function update($unidadmedidaid, $descripcionumedida,$nombreAbr)
    {
        // Creando consulta UPDATE
        $consulta = "UPDATE gasumedidas
        				SET descripcionumedida ='$descripcionumedida',
        					nombreAbr ='$nombreAbr'
        					WHERE unidadmedidaid=$unidadmedidaid ";
//		echo "$consulta";
        // Preparar la sentencia
        $cmd = Database::getInstance()->getDb()->prepare($consulta);
        // Relacionar y ejecutar la sentencia
        $cmd->execute(array($unidadmedidaid, $descripcionumedida));

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
    public static function insert($descripcionumedida,$nombreAbr){
        // Sentencia INSERT
         
        $comando = "INSERT INTO gasumedidas (descripcionumedida,nombreAbr) 
        				VALUES ('$descripcionumedida','$nombreAbr')";

        // Preparar la sentencia
        $sentencia = Database::getInstance()->getDb()->prepare($comando);

        return $sentencia->execute(
            array($descripcionumedida)
        );

    }

    /**
     * Eliminar el registro con el identificador especificado
     *
     * @param $idcategoria identificador de la categoria
     * @return bool Respuesta de la eliminación
     */
    public static function delete($unidadmedidaid)
    {
        // Sentencia DELETE
        
        $comando = "DELETE FROM gasumedidas 
			        WHERE unidadmedidaid=$unidadmedidaid";

        // Preparar la sentencia
        $sentencia = Database::getInstance()->getDb()->prepare($comando);

        return $sentencia->execute(array($unidadmedidaid));
    }
}

?>