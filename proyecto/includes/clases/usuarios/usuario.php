<?php

namespace includes\clases\usuarios;

use \includes\aplicacion as Aplicacion;

class Usuario
{


    public const ADMIN_ROLE = 'admin';

    public const USER_ROLE = 'normal';

    public static function login($nombreUsuario, $password)
    {
        $usuario = self::buscaUsuario($nombreUsuario);
        if ($usuario && $usuario->compruebaPassword($password)) {
            return $usuario;
        }
        return false;
    }
    
    public static function crea($nombreUsuario, $password, $correo, $rol)
    {
        $user = new Usuario($nombreUsuario, self::hashPassword($password), $correo, $rol);
        return $user->guarda();
    }

    public static function buscaUsuario($nombreUsuario)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM usuarios U WHERE U.nombre='%s'", $conn->real_escape_string($nombreUsuario));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Usuario($fila['nombre'], $fila['contraseña'], $fila['correo'], $fila['idusuario'],  $fila['imagen'], $fila['tipo']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function buscarPorCorreo($correo)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM usuarios U WHERE U.correo='%s'", $conn->real_escape_string($correo));
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Usuario($fila['nombre'], $fila['contraseña'], $fila['correo'], $fila['idusuario'], $fila['imagen'], $fila['tipo']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    public static function buscaPorId($idUsuario)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM usuarios WHERE idusuario=%d", $idUsuario);
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            $fila = $rs->fetch_assoc();
            if ($fila) {
                $result = new Usuario($fila['nombre'], $fila['contraseña'], $fila['correo'], $fila['idusuario'], $fila['imagen'], $fila['tipo']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }
    
    public static function buscaPorTipo($tipo)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM usuarios WHERE tipo='%s'", $conn->real_escape_string($tipo));
        $rs = $conn->query($query);
        $result = [];
        if ($rs) {
            while ($fila = $rs->fetch_assoc()) {
                $result[] = new Usuario($fila['nombre'], $fila['contraseña'], $fila['correo'], $fila['idusuario'], $fila['imagen'], $fila['tipo']);
            }
            $rs->free();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }

    private static function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    private static function cargaRoles($usuario)
    {
        $roles=[];
            
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT RU.rol FROM RolesUsuario RU WHERE RU.usuario=%d"
            , $usuario->idusuario
        );
        $rs = $conn->query($query);
        if ($rs) {
            $roles = $rs->fetch_all(MYSQLI_ASSOC);
            $rs->free();

            $usuario->roles = [];
            foreach($roles as $rol) {
                $usuario->roles[] = $rol['rol'];
            }
            return $usuario;

        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return false;
    }
   
    private static function inserta($usuario)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("INSERT INTO usuarios(nombre, correo, contraseña) VALUES ('%s', '%s', '%s')"
            , $conn->real_escape_string($usuario->nombre)
            , $conn->real_escape_string($usuario->correo)
            , $conn->real_escape_string($usuario->password)
        );
        if ( $conn->query($query) ) {
            $usuario->idusuario = $conn->insert_id;
            $result = $usuario;
            // $result = self::insertaRoles($usuario);
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }
   
    private static function insertaRoles($usuario)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        foreach($usuario->roles as $rol) {
            $query = sprintf("INSERT INTO RolesUsuario(usuario, rol) VALUES (%d, %d)"
                , $usuario->idusuario
                , $rol
            );
            if ( ! $conn->query($query) ) {
                error_log("Error BD ({$conn->errno}): {$conn->error}");
                return false;
            }
        }
        return $usuario;
    }
    
    public static function actualiza($usuario)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = "UPDATE usuarios SET nombre=?, correo=?, contraseña=?, imagen=? WHERE idusuario=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param(
            "ssssi",
            $usuario->nombre,
            $usuario->correo,
            $usuario->password,
            $usuario->urlImagen,
            $usuario->idusuario
        );
        if ($stmt->execute()) {
            $result = $usuario;
            $stmt->close();
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

        return $result;
    }
   
    private static function borraRoles($usuario)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM RolesUsuario RU WHERE RU.usuario = %d"
            , $usuario->idusuario
        );
        if ( ! $conn->query($query) ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return $usuario;
    }
    
    private static function borra($usuario)
    {
        return self::borraPorId($usuario->idusuario);
    }
    
    private static function borraPorId($idUsuario)
    {
        if (!$idUsuario) {
            return false;
        } 
        /* Los roles se borran en cascada por la FK
         * $result = self::borraRoles($usuario) !== false;
         */
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM usuarios WHERE idusuario = %d"
            , $idUsuario
        );
        if ( ! $conn->query($query) ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return true;
    }

    private $idusuario;

    private $nombre;

    private $password;

    private $correo;

    private $roles;

    private function __construct($nombre, $password, $correo, $id = null, $url=null, $roles = [])
    {
        $this->idusuario = $id;
        $this->nombre = $nombre;
        $this->password = $password;
        $this->correo = $correo;
        $this->urlImagen = $url;
        $this->roles = is_array($roles) ? $roles : [$roles]; 
    }

    public function getId()
    {
        return $this->idusuario;
    }

    public function getNombreUsuario()
    {
        return $this->nombre;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getCorreo()
    {
        return $this->correo;
    }

    public function getUrlImagen()
    {
        return $this->urlImagen;
    }

    public function añadeRol($role)
    {
        $this->roles[] = $role;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }
    public function setCorreo($correo)
    {
        $this->correo = $correo;
    }
    public function setUrlImagen($url)
    {
        $this->urlImagen = $url;
    }
    

    public function tieneRol($role)
    {
        // if ($this->roles == null) {
        //     self::cargaRoles($this);
        // }
        // return array_search($role, $this->roles) !== false;

        // Comprueba si el usuario tiene el rol indicado
        echo $this->roles;
        return in_array($role, $this->roles);
    }

    public function compruebaPassword($password)
    {
        return password_verify($password, $this->password);
    }

    public function cambiaPassword($nuevoPassword)
    {
        $this->password = self::hashPassword($nuevoPassword);
    }
    
    public function guarda()
    {
        //if ($this->idusuario !== null) {
        //    return self::actualiza($this);
        //}
        return self::inserta($this);
    }
    
    public function borrate()
    {
        if ($this->idusuario !== null) {
            return self::borra($this);
        }
        return false;
    }
}
