<?php

class Libro
{
    private $idlibro;
    private $titulo;
    private $autor;
    private $genero;
    private $editorial;
    private $idioma;
    private $estado;
    private $descripcion;
    private $imagen;
    private $idpropietario;
    private $disponible;
    private $fecha_publicacion;

    private function __construct($titulo, $autor, $genero, $editorial, $idioma, $estado, $descripcion, $imagen, $idpropietario, $disponible = true, $fecha_publicacion = null, $idlibro = null)
    {
        $this->idlibro = $idlibro;
        $this->titulo = $titulo;
        $this->autor = $autor;
        $this->genero = $genero;
        $this->editorial = $editorial;
        $this->idioma = $idioma;
        $this->estado = $estado;
        $this->descripcion = $descripcion;
        $this->imagen = $imagen;
        $this->idpropietario = $idpropietario;
        $this->disponible = $disponible;
        $this->fecha_publicacion = $fecha_publicacion ?? date('Y-m-d');
    }

    public static function crea($titulo, $autor, $genero, $editorial, $idioma, $estado, $descripcion, $imagen, $idpropietario)
    {
        $libro = new self($titulo, $autor, $genero, $editorial, $idioma, $estado, $descripcion, $imagen, $idpropietario);
        return self::inserta($libro);
    }

    public static function buscaPorId($idlibro)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = "SELECT * FROM libros WHERE idlibro = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $idlibro);
        $stmt->execute();
        $result = $stmt->get_result();
        $fila = $result->fetch_assoc();
        $stmt->close();

        if ($fila) {
            return new self(
                $fila['titulo'],
                $fila['autor'],
                $fila['genero'],
                $fila['editorial'],
                $fila['idioma'],
                $fila['estado'],
                $fila['descripcion'],
                $fila['imagen'],
                $fila['idpropietario'],
                $fila['disponible'],
                $fila['fecha_publicacion'],
                $fila['idlibro']
            );
        }
        return null;
    }

    public static function buscaPorPropietario($idpropietario)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = "SELECT * FROM libros WHERE idpropietario = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $idpropietario);
        $stmt->execute();
        $result = $stmt->get_result();
        $libros = [];
        while ($fila = $result->fetch_assoc()) {
            $libros[] = new self(
                $fila['titulo'],
                $fila['autor'],
                $fila['genero'],
                $fila['editorial'],
                $fila['idioma'],
                $fila['estado'],
                $fila['descripcion'],
                $fila['imagen'],
                $fila['idpropietario'],
                $fila['disponible'],
                $fila['fecha_publicacion'],
                $fila['idlibro']
            );
        }
        $stmt->close();
        return $libros;
    }

    public static function actualiza($libro)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = "UPDATE libros SET titulo = ?, autor = ?, genero = ?, editorial = ?, idioma = ?, estado = ?, descripcion = ?, imagen = ?, disponible = ? WHERE idlibro = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param(
            "ssssssssii",
            $libro->titulo,
            $libro->autor,
            $libro->genero,
            $libro->editorial,
            $libro->idioma,
            $libro->estado,
            $libro->descripcion,
            $libro->imagen,
            $libro->disponible,
            $libro->idlibro
        );
        $resultado = $stmt->execute();
        $stmt->close();
        return $resultado;
    }

    public static function borra($idlibro)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = "DELETE FROM libros WHERE idlibro = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $idlibro);
        $resultado = $stmt->execute();
        $stmt->close();
        return $resultado;
    }

    private static function inserta($libro)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = "INSERT INTO libros (titulo, autor, genero, editorial, idioma, estado, descripcion, imagen, idpropietario, disponible, fecha_publicacion) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param(
            "ssssssssiss",
            $libro->titulo,
            $libro->autor,
            $libro->genero,
            $libro->editorial,
            $libro->idioma,
            $libro->estado,
            $libro->descripcion,
            $libro->imagen,
            $libro->idpropietario,
            $libro->disponible,
            $libro->fecha_publicacion
        );
        if ($stmt->execute()) {
            $libro->idlibro = $conn->insert_id;
            $stmt->close();
            return $libro;
        } else {
            error_log("Error al insertar libro: " . $stmt->error);
            $stmt->close();
            return false;
        }
    }

    // Getters
    public function getId() { return $this->idlibro; }
    public function getTitulo() { return $this->titulo; }
    public function getAutor() { return $this->autor; }
    public function getGenero() { return $this->genero; }
    public function getEditorial() { return $this->editorial; }
    public function getIdioma() { return $this->idioma; }
    public function getEstado() { return $this->estado; }
    public function getDescripcion() { return $this->descripcion; }
    public function getImagen() { return $this->imagen; }
    public function getIdPropietario() { return $this->idpropietario; }
    public function getDisponible() { return $this->disponible; }
    public function getFechaPublicacion() { return $this->fecha_publicacion; }
}