<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "legalcc";

// Clave y método de cifrado
$encryption_key = 'LegalCC'; // Debe coincidir con la clave utilizada para el cifrado
$ciphering = "AES-128-CTR";
$options = 0;
$encryption_iv = '1234567891011121'; // Debe coincidir con el IV utilizado para el cifrado

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Comprobar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Procesar el formulario después de que se envía
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $apellido = $_POST['apellido'];
    $nombre = $_POST['nombre'];
    $casos = $_POST['casos'];

    $declaracion = $_POST['declaracion'];

    // Cifrar los datos
    $id_encrypted = openssl_encrypt($id, $ciphering, $encryption_key, $options, $encryption_iv);
    $apellido_encrypted = openssl_encrypt($apellido, $ciphering, $encryption_key, $options, $encryption_iv);
    $nombre_encrypted = openssl_encrypt($nombre, $ciphering, $encryption_key, $options, $encryption_iv);
    $casos_encrypted = openssl_encrypt($casos, $ciphering, $encryption_key, $options, $encryption_iv);
    $declaracion_encrypted = openssl_encrypt($declaracion, $ciphering, $encryption_key, $options, $encryption_iv);

    // Prepara la consulta SQL
    $sql = "INSERT INTO declaraciones (id, apellido, nombre, casos, declaracion) VALUES (?, ?, ?, ?, ?)";

    // Usar declaraciones preparadas para evitar inyecciones SQL
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssis", $id_encrypted, $apellido_encrypted, $nombre_encrypted, $casos_encrypted, $declaracion_encrypted);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "Registro guardado exitosamente.";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Cerrar la declaración y la conexión
    $stmt->close();
    $conn->close();
}


?>