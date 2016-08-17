<?php

require_once 'Database.php';
require_once 'Usuario.php';

class Comentario extends Database {

    public $idUsuario;
    public $idDisco;
    public $comentario;
    public $valoracion;
    public $fecha;
    private $usuario = null;

    public function __construct($datos = null) {
	if ($datos) {
	    $this->idUsuario = $datos['idUsuario'];
	    $this->idDisco = $datos['idDisco'];
	    $this->comentario = $datos['comentario'];
	    $this->valoracion = $datos['valoracion'];
	    $this->fecha = $datos['fecha'];
	}
    }

    public static function getTable() {
	return 'comentario';
    }

    public function guardar() {
	try {
	    $table = static::getTable();
	    $sql = "INSERT INTO $table (idUsuario, idDisco, comentario, valoracion, fecha) VALUES ($this->idUsuario,$this->idDisco, '$this->comentario', $this->valoracion, '$this->fecha');";
	    $conexion = $this->conectar();
	    if ($conexion) {
		$conexion->query($sql);
		$this->desconectar($conexion);
		return true;
	    }
	    return false;
	} catch (Exception $exc) {
	    return false;
	}
    }

    public function actualizar() {
	$table = static::getTable();
	$sql = "UPDATE $table SET comentario='$this->comentario', valoracion=$this->valoracion, fecha='$this->fecha' WHERE idUsuario=$this->idUsuario AND idDisco=$this->idDisco";
	$conexion = $this->conectar();
	if ($conexion) {
	    $conexion->query($sql);
	    $this->desconectar($conexion);
	    return true;
	}
	return false;
    }

    public static function findByIdDisco($idDisco) {
	$comentarios = [];
	$table = static::getTable();
	$sql = "SELECT * FROM $table WHERE idDisco=$idDisco ORDER BY fecha DESC";
	$conexion = static::conectar();
	if ($conexion) {
	    $resultado = $conexion->query($sql);
	    while ($fila = $resultado->fetch()) {
		$comentario = new Comentario($fila);
		array_push($comentarios, $comentario);
	    }
	    static::desconectar($conexion);
	}
	return $comentarios;
    }

    public function getValoracion() {
	return $this->valoracion;
    }

    public function getNombreUsuario() {
	if ($this->usuario == null) {
	    $this->usuario = Usuario::findById($this->idUsuario);
	}
	return $this->usuario->usuario;
    }

    public function getFecha() {
	$fecha = new DateTime($this->fecha, new DateTimeZone('Europe/Madrid'));
	return $fecha->format("d-m-Y H:i");
    }

    public function getTexto() {
	return $this->comentario;
    }

}

?>