<?php

namespace includes\clases\productos;

use \includes\aplicacion as Aplicacion;

class Evento
{
    private $idevento;
    private $nombre;
    private $fecha;
    private $hora;
    private $lugar;
    private $genero;

    private function __construct($nombre, $fecha, $hora, $lugar, $genero = null, $idevento = null)
    {
        $this->idevento = $idevento;
        $this->nombre = $nombre;
        $this->fecha = $fecha;
        $this->hora = $hora;
        $this->lugar = $lugar;
        $this->genero = $genero;
    }

    public static function crea($nombre, $fecha, $hora, $lugar, $genero = null)
    {
        $evento = new self($nombre, $fecha, $hora, $lugar, $genero);
        return self::inserta($evento);
    }

    public static function getEventos()
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = "SELECT * FROM eventos ORDER BY fecha, hora";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();

        $eventos = [];
        while ($fila = $result->fetch_assoc()) {
            $eventos[] = new self(
                $fila['nombre'],
                $fila['fecha'],
                $fila['hora'],
                $fila['lugar'],
                $fila['genero'],
                $fila['idevento']
            );
        }
        $result->free();
        $stmt->close();
        return $eventos;
    }

    public static function buscaPorId($idevento)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = "SELECT * FROM eventos WHERE idevento = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $idevento);
        $stmt->execute();
        $result = $stmt->get_result();
        $fila = $result->fetch_assoc();
        $result->free();
        $stmt->close();

        if ($fila) {
            return new self(
                $fila['nombre'],
                $fila['fecha'],
                $fila['hora'],
                $fila['lugar'],
                $fila['genero'],
                $fila['idevento']
            );
        }
        return null;
    }

    public static function borra($idevento)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = "DELETE FROM eventos WHERE idevento = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $idevento);
        $resultado = $stmt->execute();
        $resultado->free();
        $stmt->close();
        return $resultado;
    }

    public static function actualiza($evento)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = "UPDATE eventos SET nombre = ?, fecha = ?, hora = ?, lugar = ?, genero = ? WHERE idevento = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param(
            "sssssi",
            $evento->nombre,
            $evento->fecha,
            $evento->hora,
            $evento->lugar,
            $evento->genero,
            $evento->idevento
        );
        $resultado = $stmt->execute();
        $resultado->free();
        $stmt->close();
        return $resultado;
    }

    private static function inserta($evento)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = "INSERT INTO eventos (nombre, fecha, hora, lugar, genero) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param(
            "sssss",
            $evento->nombre,
            $evento->fecha,
            $evento->hora,
            $evento->lugar,
            $evento->genero
        );

        if ($stmt->execute()) {
            $evento->idevento = $conn->insert_id;
            $stmt->close();
            return $evento;
        } else {
            error_log("Error al insertar evento: " . $stmt->error);
            $stmt->close();
            return false;
        }
    }

    // Getters
    public function getId() { return $this->idevento; }
    public function getNombre() { return $this->nombre; }
    public function getFecha() { return $this->fecha; }
    public function getHora() { return $this->hora; }
    public function getLugar() { return $this->lugar; }
    public function getGenero() { return $this->genero; }

    // Setters
    public function setNombre($nombre) { $this->nombre = $nombre; }
    public function setFecha($fecha) { $this->fecha = $fecha; }
    public function setHora($hora) { $this->hora = $hora; }
    public function setLugar($lugar) { $this->lugar = $lugar; }
    public function setGenero($genero) { $this->genero = $genero; }
}
