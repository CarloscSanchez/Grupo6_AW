<?php

namespace includes\clases\productos;

use \includes\formulario as Formulario;
use \includes\aplicacion as Aplicacion;
use \includes\clases\usuarios\usuario as Usuario;


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

        // Lista de géneros disponibles (ya organizada en categorías)
        $generos = [
            'Ficción' => [
                'Novela', 'Cuento', 'Ciencia ficción', 'Fantasía', 'Terror', 
                'Misterio y suspenso', 'Romance', 'Aventura', 'Histórica', 
                'Drama', 'Realismo mágico', 'Distopía'
            ],
            'No ficción' => [
                'Biografía y autobiografía', 'Ensayo', 'Historia', 'Filosofía', 
                'Psicología', 'Ciencia y divulgación científica', 'Autoayuda y desarrollo personal', 
                'Política', 'Economía', 'Viajes y exploración', 'Religión y espiritualidad'
            ],
            'Infantil y juvenil' => [
                'Cuentos infantiles', 'Literatura juvenil (Young Adult - YA)', 
                'Fábulas y cuentos clásicos', 'Libros ilustrados'
            ],
            'Poesía y teatro' => [
                'Poesía lírica', 'Dramaturgia', 'Teatro clásico y contemporáneo'
            ],
            'Cómics y novelas gráficas' => [
                'Manga', 'Superhéroes', 'Historieta europea', 'Novela gráfica independiente'
            ]
        ];

        // Generar los checkboxes para los géneros
        $htmlGeneros = '';
        foreach ($generos as $categoria => $listaGeneros) {
            $htmlGeneros .= "<h4>$categoria</h4>"; // Mostrar la categoría como un encabezado
            foreach ($listaGeneros as $genero) {
                $checked = in_array($genero, $generosSeleccionados) ? 'checked' : '';
                $htmlGeneros .= "<label><input type='checkbox' name='genero[]' value='$genero' $checked> $genero</label>";
            }
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

        $usuario = null;
        $idUsuario = null;

        // Busca el usuario actual si se ha iniciado sesión
        if (isset($_SESSION['nombre'])) {
            $usuario = Usuario::buscaUsuario($_SESSION['nombre']);
            $idUsuario = $usuario->getId();    
        }
        
      
        // Procesar los filtros
        $datos = $_GET; // Obtener los datos enviados por el formulario
        $resultadoFiltro = $this->procesaFormulario($datos); // Procesar los datos
        $where = $resultadoFiltro['where'] ?? '';  // Obtener la cláusula WHERE
        $parametros = $resultadoFiltro['parametros'] ?? []; // Obtener los parámetros 

        // Para no mostrar los libros del usuario actual, si está registrado
        if ($idUsuario !== null) {
            if (!empty($where)) {
                $where .= " AND idpropietario != ? AND disponible = 1";
            } else {
                $where = "WHERE idpropietario != ? AND disponible = 1";
            }
            $parametros[] = $idUsuario;
        }
        else {
            if (!empty($where)) {
                $where .= " AND disponible = 1";
            } else {
                $where = "WHERE disponible = 1";
            }
        }


        // Construir la consulta SQL
        $sql = "SELECT * FROM libros 
                LEFT JOIN usuarios ON usuarios.idusuario = libros.idpropietario 
                $where";
        $stmt = $conn->prepare($sql);

        // Vincular los parámetros
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
        $result->free();
        return $libros;
    }
}
