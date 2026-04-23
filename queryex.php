<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejecutor de Consultas MySQL</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        textarea { width: 100%; height: 100px; margin-bottom: 10px; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .error { color: red; }
        .success { color: green; }
    </style>
</head>
<body>
    <h1>Ejecutor de Consultas MySQL</h1>
    
    <form method="post">
        <label for="query">Consulta SQL:</label><br>
        <textarea name="query" id="query" required><?php echo isset($_POST['query']) ? htmlspecialchars($_POST['query']) : ''; ?></textarea><br>
        <button type="submit">Ejecutar</button>
    </form>

    <?php
    include_once("conexion.php");

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['query'])) {
        $conn = new Conexion(); // usamos la clase como una instancia de mysqli

        $query = $_POST['query'];
        echo "<h3>Consulta ejecutada:</h3>";
        echo "<pre>" . htmlspecialchars($query) . "</pre>";

        $result = $conn->query($query);

        if ($result === TRUE) {
            echo "<p class='success'>Consulta ejecutada correctamente. Filas afectadas: " . $conn->affected_rows . "</p>";
        } elseif ($result) {
            echo "<h3>Resultados:</h3>";
            echo "<table><tr>";
            $fields = $result->fetch_fields();
            foreach ($fields as $field) {
                echo "<th>" . $field->name . "</th>";
            }
            echo "</tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                foreach ($row as $value) {
                    echo "<td>" . htmlspecialchars($value) . "</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
            $result->free();
        } else {
            echo "<p class='error'>Error en la consulta: " . $conn->error . "</p>";
        }

        $conn->close();
    }
    ?>
</body>
</html>
