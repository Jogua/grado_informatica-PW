<?php

require_once 'Database.php';
require_once 'Cancion.php';
require_once 'Comentario.php';
require_once 'Compra.php';

class Disco extends Database {

    public $id = null;
    public $nombre;
    public $artista;
    public $portada;
    public $precio;
    public $productora;
    public $idGenero;
    private $genero = null;
    private $comentarios = null;

    public function __construct($datos = null) {
	if ($datos) {
	    $this->id = $datos['id'];
	    $this->nombre = $datos['nombre'];
	    $this->artista = $datos['artista'];
	    $this->portada = $datos['portada'];
	    $this->precio = $datos['precio'];
	    $this->productora = $datos['productora'];
	    $this->idGenero = $datos['idGenero'];
	}
    }

    public static function getTable() {
	return 'disco';
    }

    public function guardar() {
	$table = static::getTable();
	$nombre = normalizaBD($this->nombre);
	$artista = normalizaBD($this->artista);
	$portada = normalizaBD($this->portada);
	$productora = normalizaBD($this->productora);
	$sql = "INSERT INTO $table (nombre, artista, portada, precio, productora, idGenero) ";
	$sql.= "VALUES ('$nombre','$artista', '$portada', $this->precio, '$productora', $this->idGenero);";
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
	    $artista = normalizaBD($this->artista);
	    $portada = normalizaBD($this->portada);
	    $productora = normalizaBD($this->productora);
	    $sql = "UPDATE $table SET nombre='$nombre', artista='$artista', portada='$portada', precio=$this->precio, productora='$productora', idGenero=$this->idGenero WHERE id=$this->id";
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
	$disco = null;
	$table = static::getTable();
	$sql = "SELECT * FROM $table WHERE id=$id";
	$conexion = static::conectar();
	if ($conexion) {
	    $respuesta = $conexion->query($sql)->fetch();
	    if ($respuesta) {
		$disco = new Disco($respuesta);
	    }
	    static::desconectar($conexion);
	}
	return $disco;
    }

    public function addCancion($titulo, $musica) {
	if ($this->id == null) {
	    $this->guardar();
	}
	$cancion = new Cancion();
	$cancion->nombre = $titulo;
	$cancion->musicaDemo = $musica;
	$cancion->idDisco = $this->id;
	return $cancion->guardar();
    }

    public static function getArtistas($nombre) {
	$respuesta = null;
	$table = static::getTable();
	$sql = "SELECT DISTINCT artista FROM $table WHERE artista LIKE '$nombre%'";
	$conexion = static::conectar();
	if ($conexion) {
	    $respuesta = $conexion->query($sql)->fetchAll();
	    static::desconectar($conexion);
	}
	return $respuesta;
    }

    public static function findByIdGenero($idGenero) {
	$discos = [];
	$table = static::getTable();
	$sql = "SELECT * FROM $table WHERE idGenero=$idGenero ORDER BY id DESC";
	$conexion = static::conectar();
	if ($conexion) {
	    $resultado = $conexion->query($sql);
	    while ($fila = $resultado->fetch()) {
		$disco = new Disco($fila);
		array_push($discos, $disco);
	    }
	    static::desconectar($conexion);
	}
	return $discos;
    }
    
    public static function getDiscosByComentarios(){
	$discos = [];
	$table = static::getTable();
	$sql = "SELECT $table.* FROM $table LEFT JOIN comentario ON id=idDisco GROUP BY id ORDER BY COUNT(idDisco) DESC, nombre ASC, artista ASC";
	$conexion = static::conectar();
	if ($conexion) {
	    $resultado = $conexion->query($sql);
	    while ($fila = $resultado->fetch()) {
		$disco = new Disco($fila);
		array_push($discos, $disco);
	    }
	    static::desconectar($conexion);
	}
	return $discos;
    }
    
    public static function getDiscosByCompra(){
	$discos = [];
	$table = static::getTable();
	$sql = "SELECT $table.* FROM $table LEFT JOIN compra ON id=idDisco GROUP BY id ORDER BY COUNT(idDisco) DESC, nombre ASC, artista ASC";
	$conexion = static::conectar();
	if ($conexion) {
	    $resultado = $conexion->query($sql);
	    while ($fila = $resultado->fetch()) {
		$disco = new Disco($fila);
		array_push($discos, $disco);
	    }
	    static::desconectar($conexion);
	}
	return $discos;
    }

    public function getDemo() {
	$cancion = Cancion::findDemoByIdDisco($this->id);
	if ($cancion) {
	    return $cancion->musicaDemo;
	}
	return "";
    }

    public function getNombreGenero() {
	if ($this->genero == null) {
	    $this->genero = Genero::findById($this->idGenero);
	}
	return $this->genero->nombre;
    }

    public function getIconoGenero() {
	if ($this->genero == null) {
	    $this->genero = Genero::findById($this->idGenero);
	}
	return $this->genero->icono;
    }

    public function getValoracion() {
	$media = 0;
	if ($this->getNumeroComentarios() > 0) {
	    $suma = 0;
	    foreach ($this->comentarios as $comentario) {
		$suma += $comentario->valoracion;
	    }
	    $media = $suma / $this->getNumeroComentarios();
	}
	return $media;
    }

    public function getCanciones() {
	return Cancion::findByIdDisco($this->id);
    }

    public function getNumeroComentarios() {
	if ($this->comentarios == null) {
	    $this->comentarios = Comentario::findByIdDisco($this->id);
	}
	return count($this->comentarios);
    }
    
    public function getNumeroComentariosString(){
	$num = $this->getNumeroComentarios();
	if($num == 0){
	    return "No hay comentarios";
	}else if($num == 1){
	    return "1 comentario";
	}else{
	    return $num . " comentarios";
	}
    }

    public function getComentarios() {
	if ($this->comentarios == null) {
	    $this->comentarios = Comentario::findByIdDisco($this->id);
	}
	return $this->comentarios;
    }
    
    public function addComentario($idUsuario, $comment, $valoracion){
	$comentario = new Comentario();
	$comentario->idUsuario = $idUsuario;
	$comentario->idDisco = $this->id;
	$comentario->comentario = $comment;
	$comentario->valoracion = $valoracion;
	$fecha = new DateTime("now", new DateTimeZone('Europe/Madrid'));
	$comentario->fecha = $fecha->format("Y-m-d H:i");
	return $comentario->guardar();
    }

    public function comprar($idUsuario){
	$compra = new Compra();
	$compra->idDisco = $this->id;
	$compra->idUsuario = $idUsuario;
	$fecha = new DateTime("now", new DateTimeZone('Europe/Madrid'));
	$compra->fecha = $fecha->format("Y-m-d");
	return $compra->guardar();
    }
}

?>