<?php

namespace includes\clases\intercambios;

use \includes\aplicacion as Aplicacion;

class Intercambio
{

    private $idintercambio;
    private $id_libro_ofrecido;
    private $id_libro_solicitado;
    private $id_solicitante;
    private $id_propietario;
    private $estado;
    private $fecha_intercambio;

    private function __construct($id_libro_solicitado, $id_solicitante, $id_propietario, $estado = null, $fecha_intercambio = null, $idintercambio = null, $id_libro_ofrecido = null)
    {
        $this->idintercambio = $idintercambio;
        $this->id_libro_ofrecido = $id_libro_ofrecido;
        $this->id_libro_solicitado = $id_libro_solicitado;
        $this->id_solicitante = $id_solicitante;
        $this->id_propietario = $id_propietario;
        $this->estado = $estado;
        $this->fecha_intercambio = $fecha_intercambio ?? date('Y-m-d');
    }

    public static function crea($id_libro_solicitado, $id_solicitante, $id_propietario)
    {
        $intercambio = new Intercambio($id_libro_solicitado, $id_solicitante, $id_propietario);
        return $intercambio->guarda();
    }

    public function guarda()
    {
        return self::inserta($this);
    }

    private static function inserta($intercambio){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = "INSERT INTO intercambios (id_libro_ofrecido, id_libro_solicitado, id_solicitante, id_propietario, estado, fecha_intercambio) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param(
            "iiiisi",
            $intercambio->id_libro_ofrecido,
            $intercambio->id_libro_solicitado,
            $intercambio->id_solicitante,
            $intercambio->id_propietario,
            $intercambio->fecha_intercambio,
            $intercambio->idintercambio
        );
        if ($stmt->execute()) {
            $intercambio->idintercambio = $conn->insert_id;
            $stmt->close();
            return $intercambio;
        } else {
            error_log("Error al insertar libro: " . $stmt->error);
            $stmt->close();
            return false;
        }
    }

    public static function buscaPorId($idintercambio)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = "SELECT * FROM intercambios WHERE idintercambio = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $idintercambio);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($fila = $resultado->fetch_assoc()) {
            return new Intercambio(
                $fila['id_libro_solicitado'],
                $fila['id_solicitante'],
                $fila['id_propietario'],
                $fila['estado'],
                $fila['fecha_intercambio'],
                $fila['idintercambio'],
                $fila['id_libro_ofrecido']
            );
        }
        return false;
    }

    public static function buscaIntercambiosRecibidos($id_usuario)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = "SELECT * FROM intercambios WHERE id_propietario = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $intercambios = [];

        while ($fila = $resultado->fetch_assoc()) {
            $intercambios[] = new Intercambio(
                $fila['id_libro_solicitado'],
                $fila['id_solicitante'],
                $fila['id_propietario'],
                $fila['estado'],
                $fila['fecha_intercambio'],
                $fila['idintercambio'],
                $fila['id_libro_ofrecido']
            );
        }
        return $intercambios;
    }

    public static function buscaIntercambiosSolicitados($id_usuario)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = "SELECT * FROM intercambios WHERE id_solicitante = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $intercambios = [];

        while ($fila = $resultado->fetch_assoc()) {
            $intercambios[] = new Intercambio(
                $fila['id_libro_solicitado'],
                $fila['id_solicitante'],
                $fila['id_propietario'],
                $fila['estado'],
                $fila['fecha_intercambio'],
                $fila['idintercambio'],
                $fila['id_libro_ofrecido']
            );
        }
        return $intercambios;
    }

    public static function aceptarIntercambio($id_libro, $idintercambio){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = "UPDATE intercambios SET estado = 'aceptado',id_libro_ofrecido = ? WHERE idintercambio = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $id_libro, $idintercambio);
        if ($stmt->execute()) {
            return true;
        } else {
            error_log("Error al aceptar intercambio: " . $stmt->error);
            return false;
        }
    }


    public function getId() { return $this->idintercambio; }
    public function getIdLibroOfrecido() { return $this->id_libro_ofrecido; }
    public function getIdLibroSolicitado() { return $this->id_libro_solicitado; }
    public function getIdSolicitante() { return $this->id_solicitante; }
    public function getIdPropietario() { return $this->id_propietario; }
    public function getEstado() { return $this->estado; }
    public function getFechaIntercambio() { return $this->fecha_intercambio;}

    public function setId($idintercambio) { $this->idintercambio = $idintercambio; }
    public function setIdLibroOfrecido($id_libro_ofrecido) { $this->id_libro_ofrecido = $id_libro_ofrecido; }
    public function setIdLibroSolicitado($id_libro_solicitado) { $this->id_libro_solicitado = $id_libro_solicitado; }
    public function setIdSolicitante($id_solicitante) { $this->id_solicitante = $id_solicitante; }
    public function setIdPropietario($id_propietario) { $this->id_propietario = $id_propietario; }
    public function setEstado($estado) { $this->estado = $estado; }
    public function setFechaIntercambio($fecha_intercambio) { $this->fecha_intercambio = $fecha_intercambio;}

}
