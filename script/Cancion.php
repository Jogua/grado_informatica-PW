<?php

require_once 'Database.php';

class Cancion extends Database {

    public $id = null;
    public $nombre;
    public $musicaDemo;
    public $idDisco;

    public function __construct($datos = null) {
	if ($datos) {
	    $this->id = $datos['id'];
	    $this->nombre = $datos['nombre'];
	    $this->musicaDemo = $datos['musicaDemo'];
	    $this->idDisco = $datos['idDisco'];
	}
    }

    public static function getTable() {
	return 'cancion';
    }

    public function guardar() {
	$table = static::getTable();
	$nombre = normalizaBD($this->nombre);
	$musicaDemo = normalizaBD($this->musicaDemo);
	$sql = "INSERT INTO $table (nombre, musicaDemo, idDisco) VALUES ('$nombre','$musicaDemo', $this->idDisco);";
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
	    $nombre = normalizaBD($this->nombre);
	    $musicaDemo = normalizaBD($this->musicaDemo);
	    $sql = "UPDATE $table SET nombre='$nombre', musicaDemo='$musicaDemo', idDisco=$this->idDisco WHERE id=$this->id";
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
	$cancion = null;
	$table = static::getTable();
	$sql = "SELECT * FROM $table WHERE id=$id";
	$conexion = static::conectar();
	if ($conexion) {
	    $respuesta = $conexion->query($sql)->fetch();
	    if ($respuesta) {
		$cancion = new Cancion($respuesta);
	    }
	    static::desconectar($conexion);
	}
	return $cancion;
    }

    public static function findByIdDisco($idDisco) {
	$canciones = [];
	$table = static::getTable();
	$sql = "SELECT * FROM $table WHERE idDisco=$idDisco";
	$conexion = static::conectar();
	if ($conexion) {
	    $resultado = $conexion->query($sql);
	    while ($fila = $resultado->fetch()) {
		$cancion = new Cancion($fila);
		array_push($canciones, $cancion);
	    }
	    static::desconectar($conexion);
	}
	return $canciones;
    }

    public static function getCanciones() {
	return static::getAll();
    }

    public static function findDemoByIdDisco($idDisco) {
	$cancion = null;
	$table = static::getTable();
	$sql = "SELECT * FROM $table WHERE idDisco=$idDisco AND musicaDemo!=''";
	$conexion = static::conectar();
	if ($conexion) {
	    $resultado = $conexion->query($sql)->fetch();
	    if ($resultado) {
		$cancion = new Cancion($resultado);
	    }
	    static::desconectar($conexion);
	}
	return $cancion;
    }
}

?>