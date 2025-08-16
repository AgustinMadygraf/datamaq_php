<!--datamaq_php/formato.php-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Formato</title>
    <link rel="stylesheet" type="text/css" href="CSS/bootstrap.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon">
    <link rel="icon" href="assets/img/favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<br>formato.php:14
<?php
    echo "<br>formato.php:16";
    require_once __DIR__ . '/datamaq_php/backend/views/header.php';
    echo "<br>formato.php:18";
    require_once __DIR__ . '/datamaq_php/backend/config/error_config.php';

    // Incluir la clase Database para gestionar la conexión
    require_once __DIR__ . '/datamaq_php/backend/core/Database.php';
    $database = Database::getInstance();
    $conexion = $database->getConnection();

    // Obtener los datos de produccion_bolsas_aux
    $sql = "SELECT * FROM `produccion_bolsas_aux`";
    $result = $conexion->query($sql);
    $rawdata = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $rawdata[] = $row;
        }
    }
?>
    <br>
    <br>
    <div class="container">
        <h1 class="text-center"> Últimos formatos</h1>
        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Ancho bobina en mm</th>
                    <th>ID_formato</th>
                    <th>formato</th> <!-- Ayuda acá -->
                    <th>Desde</th>                    
                    <th>Hasta</th>                    
                </tr>
            </thead>
            <tbody>

    <?php
    foreach ($rawdata as $row) {
        // Preparar la consulta para obtener el formato basado en ID_formato
        $sqlFormato = "SELECT formato FROM tabla_1 WHERE ID_formato = ?";
        $formato = '';
        if ($stmt = $conexion->prepare($sqlFormato)) {
            $stmt->bind_param("i", $row['ID_formato']);
            $stmt->execute();
            $stmt->bind_result($formato);
            $stmt->fetch();
            $stmt->close();
        }
        
        // Imprimir la fila con el formato obtenido
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['ID']) . "</td>";
        echo "<td>" . htmlspecialchars($row['ancho_bobina']) . "</td>";
        echo "<td>" . htmlspecialchars($row['ID_formato']) . "</td>";
        echo "<td>" . htmlspecialchars($formato) . "</td>";
        echo "<td>" . htmlspecialchars($row['Fecha']) . "</td>"; 
        echo "<td>" . date("Y-m-d H:i:s") . "</td>";
        echo "</tr>";
    }
    ?>
            </tbody>
        </table>
    </div>

    <br><br><br>
    <br><br><br>
    <br><br><br>
    <div class="container">
        <h1 class="text-center"> Agregar cambio de formato</h1>
        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Ancho de Bobina en mm</th>
                    <th>ID de Formato</th>
                    <th>Formato</th>
                    <th>Fecha</th>
                </tr>
        </thead>
        <tbody>
    <tr>
        <form action="includes/procesar_1.php" method="post">
            <td><input type="number" name="ancho_bobina" required></td>        
            <td><input type="number" name="ID_formato" required value="<?php echo $ID_formato;?>"></td>
            <td>
                <select name="formato">
                    <option value="1">Formato 1</option>
                    <option value="2">Formato 2</option>
                    <option value="3">Formato 3</option>
                    <option value="4">Formato 4</option>
                    <option value="5">Formato 5</option>
                    <option value="6">Formato 6</option>
                    <option value="7">Formato 7</option>
                    <option value="8">Formato 8</option>
                    <option value="9">Formato 9</option>
                    <option value="10">Formato 10</option>
                </select>
            </td>
            
            <td><input type="text" name="Fecha" value="<?php echo date("d-m-Y H:i:s"); ?>" readonly></td>            
            <td><input type="submit" value="Agregar"></td>
        </form>
    </tr>
    </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>