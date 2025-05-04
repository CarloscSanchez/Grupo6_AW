<?php

namespace includes\clases\productos;

use \includes\formulario as Formulario;
use \includes\clases\productos\Evento as Evento;

class FormularioEditarEvento extends Formulario
{
    private $evento;

    public function __construct() {
        parent::__construct(
            'formEditarEvento', [
                'urlRedireccion' => 'admin.php',
                'enctype' => 'multipart/form-data'
            ]
        );

        // Obtener el ID del evento desde la URL
        $idEvento = $_GET['id'] ?? null;
        if (!$idEvento) {
            throw new \Exception("No se ha proporcionado un ID de evento.");
        }

        // Cargar los datos del evento
        $this->evento = Evento::buscaPorId($idEvento);
        if (!$this->evento) {
            throw new \Exception("No se encontró el evento con ID: $idEvento");
        }
    }
    
    protected function generaCamposFormulario(&$datos)
    {
        // Si no hay datos en $datos, usa los datos del evento
        $nombre = $datos['nombre'] ?? $this->evento->getNombre();
        $fecha = $datos['fecha'] ?? $this->evento->getFecha();
        $hora = $datos['hora'] ?? $this->evento->getHora();
        $lugar = $datos['lugar'] ?? $this->evento->getLugar();
        $genero = $datos['genero'] ?? $this->evento->getGenero();

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombre', 'fecha', 'hora', 'lugar', 'genero'], $this->errores, 'span', array('class' => 'error'));

        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <div class="input-group">
                <label for="nombre">Nombre del evento:</label>
                <input type="text" id="nombre" name="nombre" value="$nombre" required>
                {$erroresCampos['nombre']}
            </div>

            <div class="input-group">
                <label for="fecha">Fecha:</label>
                <input type="date" id="fecha" name="fecha" value="$fecha" required>
                {$erroresCampos['fecha']}
            </div>

            <div class="input-group">
                <label for="hora">Hora:</label>
                <input type="time" id="hora" name="hora" value="$hora" required>
                {$erroresCampos['hora']}
            </div>

            <div class="input-group">
                <label for="lugar">Lugar:</label>
                <input type="text" id="lugar" name="lugar" value="$lugar" required>
                {$erroresCampos['lugar']}
            </div>

            <div class="input-group">
                <label for="genero">Género (opcional):</label>
                <input type="text" id="genero" name="genero" value="$genero">
                {$erroresCampos['genero']}
            </div>

            <div>
                <button type="submit" class="btn-submit">Guardar cambios</button>
                <button class="btn-cancel" type="button" onclick="window.location.href='admin.php'">Cancelar</button>
            </div>
        </fieldset>
        EOF;

        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];

        // Validar campos
        $nombre = htmlspecialchars(trim($datos['nombre'] ?? ''));
        $fecha = htmlspecialchars(trim($datos['fecha'] ?? ''));
        $hora = htmlspecialchars(trim($datos['hora'] ?? ''));
        $lugar = htmlspecialchars(trim($datos['lugar'] ?? ''));
        $genero = htmlspecialchars(trim($datos['genero'] ?? ''));

        if (!$nombre) $this->errores['nombre'] = 'El nombre no puede estar vacío.';
        if (!$fecha) $this->errores['fecha'] = 'La fecha no puede estar vacía.';
        if (!$hora) $this->errores['hora'] = 'La hora no puede estar vacía.';
        if (!$lugar) $this->errores['lugar'] = 'El lugar no puede estar vacío.';

        // Si no hay errores, actualizar el evento
        if (count($this->errores) === 0) {
            // Actualizar los datos del evento con los nuevos valores utilizando el método setter
            $this->evento->setNombre($nombre);
            $this->evento->setFecha($fecha);
            $this->evento->setHora($hora);
            $this->evento->setLugar($lugar);
            $this->evento->setGenero($genero);

            if (!Evento::actualiza($this->evento)) {
                $this->errores[] = "Error al actualizar el evento.";
            }
        }
    }
}