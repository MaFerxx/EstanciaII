<?php
class ConexionBD {
    public $conn; 

    public function __construct() {
        $server = "localhost";
        $username = "root";
        $password = "";
        $database = "bdEstancia";

        $this->conn = new mysqli($server, $username, $password, $database);
        if ($this->conn->connect_error) {
            die("Conexión fallida: " . $this->conn->connect_error);
        }
    }

    public function obtenerTipoUsuario($usuarioId) {
        $query = "SELECT id_rol FROM usuarios WHERE id_usuario = ?";
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            die("Error en la preparación de la consulta: " . $this->conn->error);
        }
        $stmt->bind_param("i", $usuarioId);
        $stmt->execute();
        $resultado = $stmt->get_result();
        if ($resultado->num_rows > 0) {
            $usuario = $resultado->fetch_assoc();
            return $usuario['id_rol']; // Devuelve 1 = Admin, 2 = Usuario, 3 = Empresa
        } else {
            return null; 
        }
    }

    public function consulta($sql, $parametros = [])
    {
        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            die("Error en la preparación de la consulta: " . $this->conn->error);
        }

        // Si hay parámetros, los vinculamos
        if (!empty($parametros)) {
            $types = str_repeat("s", count($parametros)); // Asumimos que todos son de tipo string, ajusta según sea necesario
            $stmt->bind_param($types, ...$parametros);
        }

        $stmt->execute();
        $resultado = $stmt->get_result();
        
        // Devolver los resultados como un array asociativo
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }
    public function cerrarConexion() {
        $this->conn->close();
    }
}
?>

