<?php

require_once 'Database.php';

class Genero extends Database {

    public $id = null;
    public $nombre;
    public $icono;

    public function __construct($datos = null) {
	if ($datos) {
	    $this->id = $datos['id'];
	    $this->nombre = $datos['nombre'];
	    $this->icono = $datos['icono'];
	}
    }

    public static function getTable() {
	return 'genero';
    }

    public function guardar() {
	$table = static::getTable();
	$sql = "INSERT INTO $table (nombre, icono) VALUES ('$this->nombre','$this->icono');";
	$conexion = $this->conectar();
	if ($conexion) {
	    $conexion->query($sql);
	    $this->id = $conexion->lastInsertId();
	    $this->desconectar($conexion);
	    return true;
	}
	return false;
    }

    public function actualizar() {
	if ($this->id != null) {
	    $table = static::getTable();
	    $sql = "UPDATE $table SET nombre='$this->nombre', icono='$this->icono' WHERE id=$this->id";
	    $conexion = $this->conectar();
	    if ($conexion) {
		$conexion->query($sql);
		$this->desconectar($conexion);
		return true;
	    }
	} else {
	    return $this->guardar();
	}
	return false;
    }

    public static function findById($id) {
	$genero = null;
	$table = static::getTable();
	$sql = "SELECT * FROM $table WHERE id=$id";
	$conexion = static::conectar();
	if ($conexion) {
	    $respuesta = $conexion->query($sql)->fetch();
	    if ($respuesta) {
		$genero = new Genero($respuesta);
	    }
	    static::desconectar($conexion);
	}
	return $genero;
    }

    public static function getGeneros() {
	return static::getAll();
    }

}

?>