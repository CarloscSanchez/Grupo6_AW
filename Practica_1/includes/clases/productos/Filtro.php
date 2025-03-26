<?php
require_once __DIR__ . '/../../Formulario.php';
require_once __DIR__ . '/../../Aplicacion.php';

class Filtro extends Formulario
{
    public function __construct() {
        parent::__construct('formFiltro', ['method' => 'get']);
    }

    public function gestiona($datos = [])
    {
        // Procesar los datos enviados por el formulario
        $this->errores = [];

        if (!$this->formularioEnviado($datos)) {
            // Si el formulario no ha sido enviado, generar el formulario inicial
            return $this->generaFormulario($datos);
        }

        // Procesar el formulario
        $this->procesaFormulario($datos);

        // Siempre generar el formulario después de procesarlo
        return $this->generaFormulario($datos);
    }

    protected function generaCamposFormulario(&$datos)
    {
        // Obtener los valores enviados por el formulario
        $buscar = htmlspecialchars($datos['buscar'] ?? '');
        $generosSeleccionados = $datos['genero'] ?? [];

        // Lista de géneros disponibles
        $generos = ['Ficción', 'Realismo mágico', 'Ciencia ficción', 'Distopía', 'Romance', 'Clásico', 'Fantasía', 'Aventura'];

        // Generar los checkboxes para los géneros
        $htmlGeneros = '';
        foreach ($generos as $genero) {
            $checked = in_array($genero, $generosSeleccionados) ? 'checked' : '';
            $htmlGeneros .= "<label><input type='checkbox' name='genero[]' value='$genero' $checked> $genero</label>";
        }

        // Generar el formulario
        return <<<EOF
            <form method="get" action="">
                <input type="text" name="buscar" placeholder="Buscar por título o autor" value="$buscar">
                <h3>Géneros</h3>
                $htmlGeneros
                <button type="submit">Aplicar filtros</button>
            </form>
        EOF;
    }

    protected function procesaFormulario(&$datos)
    {
        $buscar = htmlspecialchars(trim($datos['buscar'] ?? ''));
        $generos = $datos['genero'] ?? [];

        $filtros = [];
        $parametros = [];

        if ($buscar) {
            $filtros[] = "(titulo LIKE ? OR autor LIKE ?)";
            $parametros[] = "%$buscar%";
            $parametros[] = "%$buscar%";
        }

        if (!empty($generos)) {
            $placeholders = implode(',', array_fill(0, count($generos), '?'));
            $filtros[] = "genero IN ($placeholders)";
            $parametros = array_merge($parametros, $generos);
        }

        $where = $filtros ? 'WHERE ' . implode(' AND ', $filtros) : '';
        return ['where' => $where, 'parametros' => $parametros];
    }

    public function procesaFiltro()
    {
        // Obtener la conexión a la BD
        $conn = Aplicacion::getInstance()->getConexionBd();

        // Busca el usuario actual
        $usuario = Usuario::buscaUsuario($_SESSION['nombre']);
        $idUsuario = $usuario->getId();

        // Procesar los filtros
        $datos = $_GET; // Obtener los datos enviados por el formulario
        $resultadoFiltro = $this->procesaFormulario($datos); // Procesar los datos
        $where = $resultadoFiltro['where'] ?? '';
        $parametros = $resultadoFiltro['parametros'] ?? [];

        // Para no mostrar los libros del usuario actual
        if (!empty($where)) {
            $where .= " AND idpropietario != ?";
        } else {
            $where = "WHERE idpropietario != ?";
        }
        $parametros[] = $idUsuario;


        // Construir la consulta SQL
        $sql = "SELECT * FROM libros 
                LEFT JOIN usuarios ON usuarios.idusuario = libros.idpropietario 
                $where";
        $stmt = $conn->prepare($sql);

        if (!empty($parametros)) {
            $tipos = str_repeat('s', count($parametros)); // Asume que todos los parámetros son strings
            $stmt->bind_param($tipos, ...$parametros);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        // Devolver los resultados como un array
        $libros = [];
        while ($libro = $result->fetch_assoc()) {
            $libros[] = $libro;
        }

        $stmt->close();
        return $libros;
    }
}