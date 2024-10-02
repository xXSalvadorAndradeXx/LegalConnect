<?php
// Datos de conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "legalcc";

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

// Obtener el ID del registro a editar
$id = $_GET['id'];

// Consultar los datos del registro por ID
$sql = "SELECT * FROM imputados WHERE id='$id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

// Desencriptar los datos para mostrarlos en el formulario
$apellido = openssl_decrypt($row['apellido'], $ciphering, $encryption_key, $options, $encryption_iv);
$nombre = openssl_decrypt($row['nombre'], $ciphering, $encryption_key, $options, $encryption_iv);
$fecha_nacimiento = $row['fecha_nacimiento'];
$dui = openssl_decrypt($row['dui'], $ciphering, $encryption_key, $options, $encryption_iv);
$departamento = openssl_decrypt($row['departamento'], $ciphering, $encryption_key, $options, $encryption_iv);
$distrito = openssl_decrypt($row['distrito'], $ciphering, $encryption_key, $options, $encryption_iv);
$direccion = openssl_decrypt($row['direccion'], $ciphering, $encryption_key, $options, $encryption_iv);
$madre = openssl_decrypt($row['madre'], $ciphering, $encryption_key, $options, $encryption_iv);
$padre = openssl_decrypt($row['padre'], $ciphering, $encryption_key, $options, $encryption_iv);
$pandilla = openssl_decrypt($row['pandilla'], $ciphering, $encryption_key, $options, $encryption_iv);
$alias = openssl_decrypt($row['alias'], $ciphering, $encryption_key, $options, $encryption_iv);

?>

<h2>Editar Registro</h2>
<form method="post" action="actualizar.php">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    Apellido: <input type="text" name="apellido" value="<?php echo $apellido; ?>"><br>
    Nombre: <input type="text" name="nombre" value="<?php echo $nombre; ?>"><br>
    Fecha de Nacimiento: <input type="text" name="fecha_nacimiento" value="<?php echo $fecha_nacimiento; ?>"><br>
    DUI: <input type="text" name="dui" value="<?php echo $dui; ?>"><br>
    Departamento: <input type="text" name="departamento" value="<?php echo $departamento; ?>"><br>
    Distrito: <input type="text" name="distrito" value="<?php echo $distrito; ?>"><br>
    Dirección: <input type="text" name="direccion" value="<?php echo $direccion; ?>"><br>
    Madre: <input type="text" name="madre" value="<?php echo $madre; ?>"><br>
    Padre: <input type="text" name="padre" value="<?php echo $padre; ?>"><br>
    Pandilla: <input type="text" name="pandilla" value="<?php echo $pandilla; ?>"><br>
    Alias: <input type="text" name="alias" value="<?php echo $alias; ?>"><br>
    <input type="submit" value="Actualizar">
</form>

<?php
$conn->close();
?>
