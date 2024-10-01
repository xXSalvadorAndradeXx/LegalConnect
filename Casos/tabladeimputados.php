<?php
// Datos de conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "legalcc"; // Asegúrate de tener esta base de datos creada

// Clave y método de cifrado
$encryption_key = 'LegalCC'; // Debe coincidir con la clave utilizada para el cifrado
$ciphering = "AES-128-CTR"; // Método de cifrado
$iv_length = openssl_cipher_iv_length($ciphering); // Longitud del IV
$options = 0;
$encryption_iv = '1234567891011121'; // Debe coincidir con el IV utilizado para el cifrado

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consultar los registros
$sql = "SELECT * FROM imputados";
$result = $conn->query($sql);

// Comprobar si hay registros
if ($result->num_rows > 0) {
    echo "<h1>Registros</h1>";
    echo "<table border='1'>
            <tr>
                <th>Apellido</th>
                <th>Nombre</th>
                <th>Fecha de Nacimiento</th>
                <th>DUI</th>
                <th>Departamento</th>
                <th>Distrito</th>
                <th>Dirección</th>
                <th>Madre</th>
                <th>Padre</th>
                <th>Pandilla</th>
                <th>Alias</th>
            </tr>";
    
    // Mostrar cada registro
    while ($row = $result->fetch_assoc()) {
        // Desencriptar los datos
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
        
        // Mostrar los datos desencriptados en la tabla
        echo "<tr>
                <td>$apellido</td>
                <td>$nombre</td>
                <td>$fecha_nacimiento</td>
                <td>$dui</td>
                <td>$departamento</td>
                <td>$distrito</td>
                <td>$direccion</td>
                <td>$madre</td>
                <td>$padre</td>
                <td>$pandilla</td>
                <td>$alias</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No hay registros encontrados.";
}

$conn->close();
?>
