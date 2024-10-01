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
$encryption_key = 'LegalCC'; // Cambia esta clave por una clave segura
$ciphering = "AES-128-CTR"; // Método de cifrado
$iv_length = openssl_cipher_iv_length($ciphering); // Longitud del IV
$options = 0;
$encryption_iv = '1234567891011121'; // Vector de inicialización (IV)

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}




// Procesar el formulario cuando se envíe
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $apellido = $_POST['apellido'];
    $nombre = $_POST['nombre'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $dui = $_POST['dui'];
    $departamento = $_POST['departamento'];
    $distrito = $_POST['distrito'];
    $direccion = $_POST['direccion'];
    $madre = $_POST['madre'];
    $padre = $_POST['padre'];
    $pandilla = $_POST['pandilla'];
    $alias = $_POST['alias'];

    // Encriptar los datos
    $apellido_encrypted = openssl_encrypt($apellido, $ciphering, $encryption_key, $options, $encryption_iv);
    $nombre_encrypted = openssl_encrypt($nombre, $ciphering, $encryption_key, $options, $encryption_iv);
    $dui_encrypted = openssl_encrypt($dui, $ciphering, $encryption_key, $options, $encryption_iv);
    $departamento_encrypted = openssl_encrypt($departamento, $ciphering, $encryption_key, $options, $encryption_iv);
    $distrito_encrypted = openssl_encrypt($distrito, $ciphering, $encryption_key, $options, $encryption_iv);
    $direccion_encrypted = openssl_encrypt($direccion, $ciphering, $encryption_key, $options, $encryption_iv);
    $madre_encrypted = openssl_encrypt($madre, $ciphering, $encryption_key, $options, $encryption_iv);
    $padre_encrypted = openssl_encrypt($padre, $ciphering, $encryption_key, $options, $encryption_iv);
    $pandilla_encrypted = openssl_encrypt($pandilla, $ciphering, $encryption_key, $options, $encryption_iv);
    $alias_encrypted = openssl_encrypt($alias, $ciphering, $encryption_key, $options, $encryption_iv);

    // Preparar y ejecutar la consulta SQL
    $sql = "INSERT INTO imputados (apellido, nombre, fecha_nacimiento, dui, departamento, distrito, direccion, madre, padre, pandilla, alias) 
            VALUES ('$apellido_encrypted', '$nombre_encrypted', '$fecha_nacimiento', '$dui_encrypted', '$departamento_encrypted', 
                    '$distrito_encrypted', '$direccion_encrypted', '$madre_encrypted', '$padre_encrypted', '$pandilla_encrypted', '$alias_encrypted')";

    if ($conn->query($sql) === TRUE) {
        echo "Registro guardado exitosamente con cifrado.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

  
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Registro</title>
    <script>
        // Función para actualizar los distritos dependiendo del departamento seleccionado
        function updateDistricts() {
            const departmentSelect = document.getElementById("departamento");
            const districtSelect = document.getElementById("distrito");

            const districtsByDepartment = {
                "San Salvador": ["Distrito 1", "Distrito 2", "Distrito 3"],
                "La Libertad": ["Distrito 1", "Distrito 2"],
                "Santa Ana": ["Distrito 1", "Distrito 2", "Distrito 3"],
                // Agregar los distritos según cada departamento
            };

            // Obtener el departamento seleccionado
            const selectedDepartment = departmentSelect.value;

            // Limpiar los distritos actuales
            districtSelect.innerHTML = "";

            // Llenar los nuevos distritos
            if (selectedDepartment in districtsByDepartment) {
                districtsByDepartment[selectedDepartment].forEach(function(district) {
                    const option = document.createElement("option");
                    option.value = district;
                    option.text = district;
                    districtSelect.appendChild(option);
                });
            }
        }
    </script>
</head>
<body>


<a href="tabladeimputados.php">Volver</a>
    <form action="" method="POST">
        <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" name="apellido" required><br>

        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br>

        <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
        <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required><br>

        <label for="dui">DUI:</label>
        <input type="text" id="dui" name="dui" pattern="\d{8}-\d{1}" title="El formato debe ser 00000000-0" required><br>

        <label for="departamento">Departamento:</label>
        <select id="departamento" name="departamento" onchange="updateDistricts()" required>
            <option value="">Seleccione un departamento</option>
            <option value="San Salvador">San Salvador</option>
            <option value="La Libertad">La Libertad</option>
            <option value="Santa Ana">Santa Ana</option>
            <!-- Agregar los otros 11 departamentos de El Salvador -->
        </select><br>

        <label for="distrito">Distrito:</label>
        <select id="distrito" name="distrito" required>
            <option value="">Seleccione un distrito</option>
        </select><br>

        <label for="direccion">Especificar Dirección:</label>
        <textarea id="direccion" name="direccion" required></textarea><br>

        <label for="madre">Nombre de la Madre:</label>
        <input type="text" id="madre" name="madre" required><br>

        <label for="padre">Nombre del Padre:</label>
        <input type="text" id="padre" name="padre" required><br>

        <label for="pandilla">Pandilla:</label>
        <input type="text" id="pandilla" name="pandilla" required><br>

        <label for="alias">Alias:</label>
        <input type="text" id="alias" name="alias" required><br>

        <button type="submit">Registrar</button>
    </form>
</body>
</html>