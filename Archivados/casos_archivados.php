<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Casos Archivados</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }
        h1 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        a {
            color: #007BFF;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<h1>Casos Archivados</h1>

<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "legalcc";

$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consultar los casos archivados
$sql = "SELECT * FROM casos_archivados";
$result = $conn->query($sql);

// Verificar si hay resultados
if ($result->num_rows > 0) {
    echo "<table>
            <tr>
                <th>Referencia</th>
                <th>Víctima</th>
                <th>Imputado</th>
                <th>Tipo de Delito</th>
                <th>Fecha de Creación</th>
                <th>Tiempo para Prescribir</th>
                <th>Acciones</th>
            </tr>";
    // Mostrar cada caso archivado
    while($row = $result->fetch_assoc()) {
        // Asumimos que 'archivos_documento' contiene la ruta o el nombre del archivo
        $archivo = htmlspecialchars($row['archivos_documento']);
        $ruta_documento = "Casos/documentos/" . $archivo; // Cambia esta ruta según corresponda

        echo "<tr>
                <td>" . htmlspecialchars($row['referencia']) . "</td>
                <td>" . htmlspecialchars($row['victima']) . "</td>
                <td>" . htmlspecialchars($row['imputado']) . "</td>
                <td>" . htmlspecialchars($row['tipo_delito']) . "</td>
                <td>" . htmlspecialchars($row['fecha_creacion']) . "</td>
                <td>" . htmlspecialchars($row['fecha_expiracion']) . "</td>
                <td>
                    <a href='restaurar_caso.php?referencia=" . urlencode($row['referencia']) . "'>
                        <button class='btn-restaurar'>Restaurar</button>
                    </a>
                </td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No hay casos archivados.</p>";
}

// Cerrar la conexión
$conn->close();
?>

</body>
</html>

