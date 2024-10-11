<?php
// Conexión a la base de datos
$servername = "localhost";  // Cambia según tu configuración
$username = "root";         // Cambia según tu configuración
$password = "";             // Cambia según tu configuración
$dbname = "legalcc"; // Cambia según tu configuración

// Parámetros de cifrado
$encryption_key = 'LegalCC';  // Clave de cifrado
$ciphering = "AES-128-CTR";   // Algoritmo de cifrado
$options = 0;                 // Opciones para openssl
$encryption_iv = '1234567891011121';  // Vector de inicialización (IV)

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Comprobar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir datos del formulario


    $id = $_POST['id'];
    $apellido = $_POST['apellido'];
    $nombre = $_POST['nombre'];
    $casos_id = (int)$_POST['casos'];

    $declaracion = $_POST['declaracion'];

    $id_encrypted = openssl_encrypt($id, $ciphering, $encryption_key, $options, $encryption_iv);
    $apellido_encrypted = openssl_encrypt($apellido, $ciphering, $encryption_key, $options, $encryption_iv);
    $nombre_encrypted = openssl_encrypt($nombre, $ciphering, $encryption_key, $options, $encryption_iv);
    $declaracion_encrypted = openssl_encrypt($declaracion, $ciphering, $encryption_key, $options, $encryption_iv);



    $sql = "INSERT INTO declaraciones (apellido, nombre, casos_id, declaracion) 
                VALUES ('$apellido_encrypted', '$nombre_encrypted', $casos_id, '$declaracion_encrypted')";


        if ($conn->query($sql) === TRUE) {
            header("Location: /Casos/victima/tabla_de_victima.php?declaracion=exito");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Debe seleccionar un caso válido.";
    }


// Cerrar conexión
$conn->close();
?>
