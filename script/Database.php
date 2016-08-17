<?php

abstract class Database {

    protected static $dnsDB = "mysql:host=localhost;dbname=tienda_musica;charset=utf8";
    protected static $usernameDB = "root";
    protected static $passwordDB = "";

    protected static function conectar() {
	try {
	    $conexion = new PDO(static::$dnsDB, static::$usernameDB, static::$passwordDB);
	    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    return $conexion;
	} catch (PDOException $e) {
	    echo "Conexión fallida: " . $e->getMessage();
	    return null;
	}
    }

    protected static function desconectar($conexion) {
	$conexion = null;
    }

    abstract static public function getTable();

    abstract public function guardar();

    abstract public function actualizar();

    public static function getAll() {
	$respuesta = null;
	$table = static::getTable();
	$sql = "SELECT * FROM $table";
	$conexion = static::conectar();
	if ($conexion) {
	    $respuesta = $conexion->query($sql);
	    static::desconectar($conexion);
	}
	return $respuesta;
    }

    public static function count() {
	$respuesta = null;
	$table = static::getTable();
	$sql = "SELECT COUNT(*) FROM $table";
	$conexion = static::conectar();
	if ($conexion) {
	    $respuesta = $conexion->query($sql);
	    static::desconectar($conexion);
	}
	return $respuesta;
    }
}

function normalizaBD($cadena) {
    $reemplazar = array(
	"'" => "''"
    );
    $cadena = utf8_decode(trim($cadena));
    $cadena = strtr($cadena, $reemplazar);
    return utf8_encode($cadena);
}

?>