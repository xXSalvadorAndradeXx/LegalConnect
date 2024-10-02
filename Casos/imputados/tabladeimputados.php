<?php
session_start(); // Iniciar sesión

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    // Redirigir al usuario a la página de inicio de sesión si no ha iniciado sesión
    header("Location: Iniciar_Sesion.php");
    exit();
}


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

// Obtener la información del usuario desde la base de datos
$user_id = $_SESSION['user_id'];
$sql = "SELECT tipo FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($tipo_usuario);
$stmt->fetch();
$stmt->close();
$conn->close();

if (isset($_GET['logout'])) {
  // Verificar si se ha confirmado la salida
  if ($_GET['logout'] == 'confirm') {
      session_destroy(); // Destruir todas las variables de sesión
      header("Location: Iniciar_Sesion.php"); // Redirigir al usuario a la página de inicio de sesión
      exit();
  } else {
      // Si no se ha confirmado, redirigir al usuario a esta misma página con un parámetro 'confirm'
      header("Location: {$_SERVER['PHP_SELF']}?logout=confirm");
      exit();
  }
}

// Resto del código aquí (contenido de la página principal)
//___________________________________________HTML Normal_____________________________________________________________________________________
?>

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
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registros Imputados</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
        .logout-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #d9534f;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .logout-btn:hover {
            background-color: #c9302c;
        }
        .confirmation {
            margin-top: 20px;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Registros de Imputados</h1>
<?php

if ($result->num_rows > 0) {
    echo "<h1>Registros</h1>";
    echo "<table border='1'>
            <tr>
                <th>ID</th>
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
                <th>Acciones</th>
            </tr>";
    
    // Mostrar cada registro
    while ($row = $result->fetch_assoc()) {
        // Desencriptar los datos
        $id = $row['id'];
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
                <td>$id</td>
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
                <td><a href='editar.php?id=$id'>Editar</a></td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No hay registros encontrados.";
}

$conn->close();
?>
      
      
        
    </div>
</body>
</html>










