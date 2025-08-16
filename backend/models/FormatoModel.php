<?php
// filepath: backend/models/FormatoModel.php
class FormatoModel {
    private $conexion;

    public function __construct() {
        // Reutiliza la conexión mediante la configuración de conn.php
        require_once __DIR__ . '/../config/conn.php';
        $this->conexion = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME2);
        if (!$this->conexion) {
            die("Conexión fallida: " . mysqli_connect_error());
        }
    }

    public function getUltimoFormato() {
        $data = [
            'ID_formato'   => "No especificado",
            'ancho_bobina' => "No especificado",
            'formato'      => "No especificado"
        ];

        // Usamos consulta simple ya que no se reciben parámetros externos
        $sql = "SELECT pb.*, t.formato 
                FROM produccion_bolsas_aux pb 
                LEFT JOIN tabla_1 t ON pb.ID_formato = t.ID_formato 
                ORDER BY pb.ID DESC LIMIT 1";

        if ($stmt = mysqli_prepare($this->conexion, $sql)) {
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $data['ID_formato'] = $row['ID_formato'];
                $data['ancho_bobina'] = isset($row['ancho_bobina']) ? "{$row['ancho_bobina']} mm" : $data['ancho_bobina'];
                if (!empty($row['formato'])) {
                    $data['formato'] = $row['formato'];
                }
            }
            mysqli_stmt_close($stmt);
        } else {
            error_log("Error en la preparación de la consulta: " . mysqli_error($this->conexion));
        }
        return $data;
    }
}
?>