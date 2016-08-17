<?php

require_once 'Database.php';

class Usuario extends Database {

    public $id = null;
    public $nombre;
    public $apellidos;
    public $usuario;
    public $contrasenia;
    public $direccion;
    public $ciudad;
    public $provincia;
    public $codigoPostal;
    public $email;
    public $dni;
    public $visa;
    public $observaciones;
    public $rol;

    public function __construct($datos = null) {
	if ($datos) {
	    $this->id = $datos['id'];
	    $this->nombre = $datos['nombre'];
	    $this->apellidos = $datos['apellidos'];
	    $this->usuario = $datos['usuario'];
	    $this->contrasenia = $datos['contrasenia'];
	    $this->direccion = $datos['direccion'];
	    $this->ciudad = $datos['ciudad'];
	    $this->provincia = $datos['provincia'];
	    $this->codigoPostal = $datos['codigoPostal'];
	    $this->email = $datos['email'];
	    $this->dni = $datos['dni'];
	    $this->visa = $datos['visa'];
	    $this->observaciones = $datos['observaciones'];
	    $this->rol = $datos['rol'];
	}
    }

    public static function getTable() {
	return 'usuario';
    }

    public function guardar() {
	$table = static::getTable();
	$sql = "INSERT INTO $table (nombre, apellidos, usuario, contrasenia, direccion, ciudad, provincia, codigoPostal, email, dni, visa, observaciones) ";
	$sql.= "VALUES ('$this->nombre','$this->apellidos','$this->usuario','$this->contrasenia','$this->direccion','$this->ciudad','$this->provincia','$this->codigoPostal','$this->email','$this->dni','$this->visa','$this->observaciones');";
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
	    $sql = "UPDATE $table SET nombre='$this->nombre', apellidos='$this->apellidos', usuario='$this->usuario', contrasenia='$this->contrasenia', direccion='$this->direccion', ciudad='$this->ciudad', provincia='$this->provincia', codigoPostal='$this->codigoPostal', email='$this->email', dni='$this->dni', visa='$this->visa', observaciones='$this->observaciones' WHERE id=$this->id";
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
	$usuario = null;
	$table = static::getTable();
	$sql = "SELECT * FROM $table WHERE id=$id";
	$conexion = static::conectar();
	if ($conexion) {
	    $respuesta = $conexion->query($sql)->fetch();
	    if ($respuesta) {
		$usuario = new Usuario($respuesta);
	    }
	    static::desconectar($conexion);
	}
	return $usuario;
    }

    public static function findByUsername($username) {
	$usuario = null;
	$table = static::getTable();
	$sql = "SELECT * FROM $table WHERE usuario='$username'";
	$conexion = static::conectar();
	if ($conexion) {
	    $respuesta = $conexion->query($sql)->fetch();
	    if ($respuesta) {
		$usuario = new Usuario($respuesta);
	    }
	    static::desconectar($conexion);
	}
	return $usuario;
    }

    public function getDireccion() {
	$direccion = $this->direccion;
	if (strlen($this->direccion) != 0 && strlen($this->codigoPostal) != 0) {
	    $direccion .= ', ';
	}
	$direccion .= $this->codigoPostal;
	if (strlen($this->ciudad) != 0) {
	    $direccion .= ', ' . $this->ciudad;
	}
	if (strlen($this->provincia) != 0) {
	    $direccion .= ' (' . $this->provincia . ')';
	}
	return $direccion;
    }

    public function getVisa() {
	$visa = "";
	$array = explode("-", $this->visa);
	foreach ($array as $v) {
	    $visa.= $v . " ";
	}
	return $visa;
    }
}

?>