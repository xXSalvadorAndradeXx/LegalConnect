<?php
// Conectar a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "legalcc"; // Tu base de datos

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener usuarios (por ejemplo, de tipo 'normal')
$sql = "SELECT id, nombre, apellido FROM usuarios"; // Sin WHERE para prueba

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Mostrar usuarios en formato HTML
    while($row = $result->fetch_assoc()) {
        echo '<div class="user" onclick="selectUser(' . $row["id"] . ')">';
        echo $row["nombre"] . " " . $row["apellido"];
        echo '</div>';
    }
} else {
    echo "No hay usuarios disponibles.";
}

$conn->close();
?>
