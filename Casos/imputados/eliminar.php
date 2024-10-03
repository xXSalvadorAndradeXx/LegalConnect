<?php
// Datos de conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "legalcc";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener el ID del registro a eliminar
$id = $_GET['id'];

// Eliminar el registro de la base de datos
$sql = "DELETE FROM imputados WHERE id='$id'";

if ($conn->query($sql) === TRUE) {
    header("Location: tabladeimputados.php?mensaje=exito2");
} else {
    echo "Error al eliminar el registro: " . $conn->error;
}

$conn->close();

// Redirigir de nuevo a la página principal después de eliminar

?>
