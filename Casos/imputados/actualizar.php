<?php
// Datos de conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "LegalCC";

// Clave y método de cifrado
$encryption_key = 'LegalCC'; // Debe coincidir con la clave utilizada para el cifrado
$ciphering = "AES-128-CTR";
$options = 0;
$encryption_iv = '1234567891011121'; // Debe coincidir con el IV utilizado para el cifrado

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Recibir los datos del formulario
$id = $_POST['id'];
$apellido = openssl_encrypt($_POST['apellido'], $ciphering, $encryption_key, $options, $encryption_iv);
$nombre = openssl_encrypt($_POST['nombre'], $ciphering, $encryption_key, $options, $encryption_iv);
$fecha_nacimiento = $_POST['fecha_nacimiento'];
$dui = openssl_encrypt($_POST['dui'], $ciphering, $encryption_key, $options, $encryption_iv);
$departamento = openssl_encrypt($_POST['departamento'], $ciphering, $encryption_key, $options, $encryption_iv);
$distrito = openssl_encrypt($_POST['distrito'], $ciphering, $encryption_key, $options, $encryption_iv);
$direccion = openssl_encrypt($_POST['direccion'], $ciphering, $encryption_key, $options, $encryption_iv);
$madre = openssl_encrypt($_POST['madre'], $ciphering, $encryption_key, $options, $encryption_iv);
$padre = openssl_encrypt($_POST['padre'], $ciphering, $encryption_key, $options, $encryption_iv);
$pandilla = openssl_encrypt($_POST['pandilla'], $ciphering, $encryption_key, $options, $encryption_iv);
$alias = openssl_encrypt($_POST['alias'], $ciphering, $encryption_key, $options, $encryption_iv);

// Actualizar los datos en la base de datos
$sql = "UPDATE imputados SET apellido='$apellido', nombre='$nombre', fecha_nacimiento='$fecha_nacimiento', dui='$dui', departamento='$departamento', distrito='$distrito', direccion='$direccion', madre='$madre', padre='$padre', pandilla='$pandilla', alias='$alias' WHERE id='$id'";

if ($conn->query($sql) === TRUE) {
    header("Location: /Casos/imputados/tabladeimputados.php?mensaje=exito");
} else {
    echo "Error al actualizar el registro: " . $conn->error;
}

$conn->close();
?>
