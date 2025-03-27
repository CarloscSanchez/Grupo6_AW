<?php
require_once __DIR__ . '/../Formulario.php';

class FormularioContacto extends Formulario
{
    public function __construct()
    {
        parent::__construct('formContacto', ['method' => 'get', 'action' => 'mailto:ismaluca@ucm.es', 'enctype' => 'text/plain', 'class' => 'contacto-form']);
    }

    /**
     * Genera los campos del formulario de contacto.
     *
     * @param array &$datos Datos enviados previamente por el usuario (si los hay).
     * @return string HTML de los campos del formulario.
     */
    protected function generaCamposFormulario(&$datos)
    {
        $nombre = htmlspecialchars($datos['Nombre'] ?? '');
        $email = htmlspecialchars($datos['Email'] ?? '');
        $motivo = $datos['Motivo'] ?? '';
        $consulta = htmlspecialchars($datos['Consulta'] ?? '');

        return <<<EOS
        <div class="contacto-input-group">
            <label for="nombre" class="contacto-label">Nombre:</label>
            <input type="text" id="nombre" name="Nombre" placeholder="Introduce tu nombre" class="contacto-input" value="$nombre" required>
        </div>

        <div class="contacto-input-group">
            <label for="correo" class="contacto-label">Correo:</label>
            <input type="email" id="correo" name="Email" placeholder="Introduce tu correo" class="contacto-input" value="$email" required>
        </div>

        <div class="contacto-input-group">
            <label class="contacto-label">Motivo de la consulta:</label>
            <div class="contacto-radio-group">
                <input type="radio" id="evaluacion" name="Motivo" value="Evaluacion" class="contacto-radio">
                <label for="evaluacion" class="contacto-radio-label">Evaluación</label>
                <input type="radio" id="sugerencias" name="Motivo" value="Sugerencias" class="contacto-radio">
                <label for="sugerencias" class="contacto-radio-label">Sugerencias</label>
                <input type="radio" id="criticas" name="Motivo" value="Críticas" class="contacto-radio">
                <label for="criticas" class="contacto-radio-label">Críticas</label>
            </div>
        </div>

        <div class="contacto-input-group">
            <label for="consulta" class="contacto-label">Escribe tu consulta:</label>
            <textarea id="consulta" name="Consulta" placeholder="Escribe aquí tu consulta..." rows="5" class="contacto-textarea" required>$consulta</textarea>
        </div>

        <div class="contacto-label">
            <input type="checkbox" id="checkbox" name="Checkbox" value="Aceptada" class="contacto-checkbox" required>
            <label for="checkbox" class="contacto-checkbox-label">He leído y acepto los términos y condiciones del servicio</label>
        </div>

        <div class="contacto-form-actions">
            <button type="submit" class="contacto-btn-enviar">Abrir cliente de correo</button>
        </div>
        EOS;
    }
}