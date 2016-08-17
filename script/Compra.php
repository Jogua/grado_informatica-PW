<?php

require_once 'Database.php';
require_once 'Usuario.php';

class Compra extends Database {

    public $idUsuario;
    public $idDisco;
    public $fecha;

    public function __construct($datos = null) {
	if ($datos) {
	    $this->idUsuario = $datos['idUsuario'];
	    $this->idDisco = $datos['idDisco'];
	    $this->fecha = $datos['fecha'];
	}
    }

    public static function getTable() {
	return 'compra';
    }

    public function guardar() {
	try {
	    $table = static::getTable();
	    $sql = "INSERT INTO $table (idUsuario, idDisco, fecha) VALUES ($this->idUsuario,$this->idDisco, '$this->fecha');";
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
	return $this->guardar();
    }

}

?>