<?php
session_start(); // Iniciar sesión

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    // Redirigir al usuario a la página de inicio de sesión si no ha iniciado sesión
    header("Location: /Iniciar_Sesion.php");
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

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario con Guardado en Base de Datos</title>
    <style>
        .hidden { display: none; }
    </style>
    <script>
        function showSpecifyField(value) {
            const specifyField = document.getElementById("specifyGender");
            if (value === "otro") {
                specifyField.classList.remove("hidden");
            } else {
                specifyField.classList.add("hidden");
            }
        }

        function validateDOB() {
            const dob = new Date(document.getElementById("dob").value);
            const today = new Date();
            const age = today.getFullYear() - dob.getFullYear();
            const minAge = 12;

            if (age < minAge || (age === minAge && today < new Date(today.getFullYear(), dob.getMonth(), dob.getDate()))) {
                alert("Debes tener al menos 12 años.");
                return false;
            }
            return true;
        }

        function validateDUI() {
            const duiPattern = /^\d{8}-\d{1}$/;
            const dui = document.getElementById("dui").value;
            if (!duiPattern.test(dui)) {
                alert("Formato de DUI incorrecto. Debe ser 00000000-0.");
                return false;
            }
            return true;
        }

        function validateForm() {
            return validateDOB() && validateDUI();
        }
    </script>
</head>
<body>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Conexión a la base de datos
        $servername = "localhost";
        $username = "root"; // Cambia el nombre de usuario según tu configuración
        $password = ""; // Cambia la contraseña según tu configuración
        $dbname = "legalcc";


        $encryption_key = 'LegalCC'; // Cambia esta clave por una clave segura
$ciphering = "AES-128-CTR"; // Método de cifrado
$iv_length = openssl_cipher_iv_length($ciphering); // Longitud del IV
$options = 0;
$encryption_iv = '1234567891011121'; 
        // Crear conexión
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Verificar la conexión
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        function generarCodigoImputado() {
            $codigo = 'VIC ' . str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT) . '-' . 
                              str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT) . '-' . 
                              str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);
            return $codigo;
        }


        // Recibir datos del formulario
        $apellido = $_POST['apellido'];
        $nombre = $_POST['nombre'];
        $dob = $_POST['dob'];
        $dui = $_POST['dui'];
        $fecha_nacimiento = $_POST['fecha_nacimiento'];
        
        if ($_POST['genero'] === 'otro') {
            $sexo = $_POST['otroGenero'];  // Si selecciona "Otro", se guarda el valor del campo adicional
        } else {
            $sexo = $_POST['genero'];  // Si no, se guarda la opción seleccionada en el campo 'sexo'
        }


        $departamento = $_POST['departamento'];
        $distrito = $_POST['distrito'];
        $direccion = $_POST['direccion'];
        $madre = $_POST['madre'];
        $padre = $_POST['padre'];


        $apellido_encrypted = openssl_encrypt($apellido, $ciphering, $encryption_key, $options, $encryption_iv);
        $nombre_encrypted = openssl_encrypt($nombre, $ciphering, $encryption_key, $options, $encryption_iv);
        $dui_encrypted = openssl_encrypt($dui, $ciphering, $encryption_key, $options, $encryption_iv);
        $departamento_encrypted = openssl_encrypt($departamento, $ciphering, $encryption_key, $options, $encryption_iv);
        $distrito_encrypted = openssl_encrypt($distrito, $ciphering, $encryption_key, $options, $encryption_iv);
        $direccion_encrypted = openssl_encrypt($direccion, $ciphering, $encryption_key, $options, $encryption_iv);
        $madre_encrypted = openssl_encrypt($madre, $ciphering, $encryption_key, $options, $encryption_iv);
        $padre_encrypted = openssl_encrypt($padre, $ciphering, $encryption_key, $options, $encryption_iv);
        
        // Encriptar el campo 'sexo'
        $sexo_encrypted = openssl_encrypt($sexo, $ciphering, $encryption_key, $options, $encryption_iv);
    
        // Generar el código del imputado
        $codigo_imputado = generarCodigoImputado();







        // Insertar datos en la tabla
        $sql = "INSERT INTO victumas ( codigo, apellido, nombre, fecha_nacimiento, dui, sexo, departamento, distrito, direccion, madre, padre )
        VALUES ('$codigo_imputado', '$apellido_encrypted', '$nombre_encrypted', '$fecha_nacimiento', '$dui_encrypted', '$sexo_encrypted', 
                '$departamento_encrypted', '$distrito_encrypted', '$direccion_encrypted', '$madre_encrypted', '$padre_encrypted')";

        if ($conn->query($sql) === TRUE) {
            header("Location: /Casos/victima/tabla_de_victima.php?mensaje=exito");
        } else {
            echo "<p>Error: " . $sql . "<br>" . $conn->error . "</p>";
        }

        // Cerrar conexión
        $conn->close();
    }
    ?>

    <form method="post" onsubmit="return validateForm()">
        <h2>Paso 1</h2>
        <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" name="apellido" required><br><br>

        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br><br>

        <label for="dob">Fecha de nacimiento:</label>
        <input type="date" id="dob" name="dob" required><br><br>

        <label for="dui">DUI:</label>
        <input type="text" id="dui" name="dui" required pattern="\d{8}-\d{1}" title="Formato: 00000000-0"><br><br>

        <label for="genero">Género:</label>
        <select id="genero" name="genero" onchange="showSpecifyField(this.value)" required>
            <option value="masculino">Masculino</option>
            <option value="femenino">Femenino</option>
            <option value="otro">Otro</option>
        </select><br><br>

        <div id="specifyGender" class="hidden">
            <label for="otroGenero">Especificar género:</label>
            <input type="text" id="otroGenero" name="otroGenero"><br><br>
        </div>

        <h2>Paso 2</h2>
        <label for="departamento">Departamento:</label>
        <input type="text" id="departamento" name="departamento" required><br><br>

        <label for="distrito">Distrito:</label>
        <input type="text" id="distrito" name="distrito" required><br><br>

        <label for="direccion">Especificar dirección:</label>
        <input type="text" id="direccion" name="direccion" required><br><br>

        <h2>Paso 3</h2>
        <label for="madre">Nombre de la madre:</label>
        <input type="text" id="madre" name="madre" required><br><br>

        <label for="padre">Nombre del padre:</label>
        <input type="text" id="padre" name="padre" required><br><br>

        <button type="submit">Enviar</button>
    </form>
</body>
</html>
