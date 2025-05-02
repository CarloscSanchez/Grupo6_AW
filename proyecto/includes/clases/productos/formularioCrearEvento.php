<?php

namespace includes\clases\productos;

use \includes\formulario as Formulario;

class FormularioCrearEvento extends Formulario
{
    public function __construct() {
        parent::__construct(
            'formCrearEvento', [
                'urlRedireccion' => 'perfil.php'
            ]
        );
    }

    protected function generaCamposFormulario(&$datos)
    {
        $nombre = $datos['nombre'] ?? '';
        $fecha = $datos['fecha'] ?? '';
        $hora = $datos['hora'] ?? '';
        $lugar = $datos['lugar'] ?? '';
        $genero = $datos['genero'] ?? '';

        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombre', 'fecha', 'hora', 'lugar', 'genero'], $this->errores, 'span', ['class' => 'error']);

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
                <button type="submit" class="btn-submit">Crear evento</button>
                <button class="btn-cancel" type="button" onclick="window.location.href='admin.php'">Cancelar</button>
            </div>
        </fieldset>
        EOF;

        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];

        $nombre = htmlspecialchars(trim($datos['nombre'] ?? ''));
        $fecha = htmlspecialchars(trim($datos['fecha'] ?? ''));
        $hora = htmlspecialchars(trim($datos['hora'] ?? ''));
        $lugar = htmlspecialchars(trim($datos['lugar'] ?? ''));
        $genero = htmlspecialchars(trim($datos['genero'] ?? ''));

        if (!$nombre) $this->errores['nombre'] = 'El nombre no puede estar vacío.';
        if (!$fecha) $this->errores['fecha'] = 'La fecha no puede estar vacía.';
        if (!$hora) $this->errores['hora'] = 'La hora no puede estar vacía.';
        if (!$lugar) $this->errores['lugar'] = 'El lugar no puede estar vacío.';

        if (count($this->errores) === 0) {
            $evento = Evento::crea($nombre, $fecha, $hora, $lugar, $genero);

            if (!$evento) {
                $this->errores[] = "Error al guardar el evento.";
            }
        }
    }
}