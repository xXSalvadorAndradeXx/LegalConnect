<?php
// Conectar a la base de datos (ajusta los parámetros según tu configuración)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "legalcc";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Recoger los datos del formulario
$usuario_id = $_POST['usuario_id'];
$juez_id = $_POST['juez_id'];
$razon = $_POST['razon'];
$fecha = $_POST['fecha'];
$hora = $_POST['hora'];

// Preparar y ejecutar la consulta SQL
$sql = "INSERT INTO solicitudes (usuario_id, juez_id, razon, fecha, hora, estado) VALUES (?, ?, ?, ?, ?, ?)";



$stmt = $conn->prepare($sql);
$stmt->bind_param("iissss", $usuario_id, $juez_id, $razon, $fecha, $hora, $estado);

$estado = "Pendiente";


if ($stmt->execute()) {
    header("Location: buscar_audiencias.php?mensaje=exito");
} else {
    echo "Error al guardar los datos: " . $stmt->error;
}

// Cerrar la conexión
$stmt->close();
$conn->close();
?>

