<?php
session_start(); // Iniciar sesión

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    // Redirigir al usuario a la página de inicio de sesión si no ha iniciado sesión
    header("Location: ./Iniciar_Sesion.php");
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



<?php
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Registro</title>
    <style>
        body {
            font-family: 'Bahnschrift', sans-serif;
            background-color: #e8f0fa;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        .form-container {
            background-color: white;
            padding: 20px;
            margin: 30px auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            max-width: 600px;
            width: 100%;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }

        input[type="text"] {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        input[type="submit"], button {
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover, button:hover {
            background-color: #218838;
        }

        @media (max-width: 600px) {
            .form-container {
                padding: 15px;
            }

            input[type="text"] {
                font-size: 14px;
            }

            input[type="submit"] {
                font-size: 14px;
            }
        }

        .step {
            display: none;
        }

        .step.active {
            display: block;
        }

        .progress-bar {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .progress-step {
            width: 100%;
            height: 10px;
            background-color: #e0e0e0;
            position: relative;
            margin: 0 5px;
        }

        .progress-step.active {
            background-color: #007bff;
        }

        .button-group {
            display: flex;
            justify-content: space-between;
        }








        nav {
            background-color: #2c3e50;
            padding: 15px 0;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            gap: 40px;
        }
        ul li {
            position: relative;
        }
        ul li a {
            text-decoration: none;
            color: white;
            font-size: 18px;
            font-weight: bold;
            padding: 10px 30px;
            display: block;
            transition: background-color 0.3s ease, transform 0.2s ease;
            border-radius: 8px;
        }
        ul li a:hover {
            background-color:#374D63;
            transform: scale(1.05);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        /* Estilo del submenú "Cerrar sesión" */
        ul li ul {
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            background-color: #2c3e50;
            border-radius: 8px;
            display: none;
            min-width: 180px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        ul li ul li a {
            padding: 10px 15px;
            font-size: 16px;
            color: white;
        }
        ul li:hover ul {
            display: block;
        }
        ul li ul li a:hover {
            background-color:#374D63;
        }
        /* Contenido */
        .content {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 40px 20px;
        }
        h1 {
            color: #2c3e50;
            font-size: 48px;
            margin-bottom: 20px;
            letter-spacing: 2px;
        }
        p {
            color: #555;
            font-size: 20px;
            max-width: 600px;
            line-height: 1.6;
        }
        /* Responsive */
        @media (max-width: 768px) {
            ul {
                flex-direction: column;
                align-items: center;
            }
            ul li a {
                padding: 10px 20px;
                font-size: 16px;
            }
        }












    </style>
</head>
<body>

<nav>
        <ul>
            <li><a href="/Pagina_principal.php">Inicio</a></li>
            <li>
                <a href="/Casos/Buscar_Casos.php">Casos</a>
                <ul>
                    <li><a href="casos/victima.php">Victimas</a></li>
                    <li><a href="casos/imputado.php">Imputados</a></li>
                    
                </ul>
            
            
            </li>
            <li><a href="/Audiencias/Buscar_Audiencias.php">Audiencias</a></li>
            <li><a href="apps.php">Aplicaciones</a></li>
            <?php if ($tipo_usuario === 'fiscal' || $tipo_usuario === 'abogado'): ?>  

            <li><a href="/Audiencias/ver_solicitudes.php">Mis Solicitudes</a></li>

            <?php endif; ?>

            <?php if ($tipo_usuario === 'juez'): ?>  

            <li><a href="/Audiencias/ver_solicitudes.php">Solicitudes</a></li>

            <?php endif; ?>
            
            <li>
                <a href="/formularios/Perfil.php">Perfil</a>
                <ul>
                    <li><a href="?logout">Cerrar sesión</a></li>
                </ul>
            </li>
        </ul>
    </nav>












    <div class="form-container">
        <div class="progress-bar">
            <div class="progress-step"></div>
            <div class="progress-step"></div>
            <div class="progress-step"></div>
        </div>

        <h2>Editar Registro</h2>
        <form method="post" action="actualizar.php">
            <!-- Paso 1 -->
            <div class="step active">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <label for="apellido">Apellido:</label>
                <input type="text" id="apellido" name="apellido" value="<?php echo $apellido; ?>" required>
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo $nombre; ?>" required>
                <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                <input type="text" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo $fecha_nacimiento; ?>" required>
            </div>

            <!-- Paso 2 -->
            <div class="step">
                <label for="dui">DUI:</label>
                <input type="text" id="dui" name="dui" value="<?php echo $dui; ?>" required>
                <label for="departamento">Departamento:</label>
                <input type="text" id="departamento" name="departamento" value="<?php echo $departamento; ?>" required>
                <label for="distrito">Distrito:</label>
                <input type="text" id="distrito" name="distrito" value="<?php echo $distrito; ?>" required>
                <label for="direccion">Dirección:</label>
                <input type="text" id="direccion" name="direccion" value="<?php echo $direccion; ?>" required>
                <label for="madre">Madre:</label>
                <input type="text" id="madre" name="madre" value="<?php echo $madre; ?>" required>
            </div>

            <!-- Paso 3 -->
            <div class="step">
                <label for="padre">Padre:</label>
                <input type="text" id="padre" name="padre" value="<?php echo $padre; ?>" required>
                <label for="pandilla">Pandilla:</label>
                <input type="text" id="pandilla" name="pandilla" value="<?php echo $pandilla; ?>" required>
                <label for="alias">Alias:</label>
                <input type="text" id="alias" name="alias" value="<?php echo $alias; ?>" required>
            </div>   

            <div class="button-group">
                <button type="button" id="prevBtn" onclick="changeStep(-1)">Anterior</button>
                <button type="button" id="nextBtn" onclick="changeStep(1)">Siguiente</button>
                <input type="submit" id="submitBtn" value="Registrar" style="display:none;">
            </div>
        </form>
    </div>

<script>
let currentStep = 0;

function showStep(step) {
    const steps = document.querySelectorAll(".step");

    // Mostrar solo el paso actual
    steps.forEach((s, index) => {
        s.classList.toggle("active", index === step);
    });

    const progressSteps = document.querySelectorAll(".progress-step");

    // Actualizar la barra de progreso
    progressSteps.forEach((p, index) => {
        p.classList.toggle("active", index <= step);
    });

    // Desactivar el botón "Anterior" si estamos en el primer paso
    document.getElementById("prevBtn").disabled = step === 0;

    // Cambiar el botón "Siguiente" en el último paso
    if (step === steps.length - 1) {
        document.getElementById("nextBtn").style.display = 'none';
        document.getElementById("submitBtn").style.display = 'inline-block';
    } else {
        document.getElementById("nextBtn").style.display = 'inline-block';
        document.getElementById("submitBtn").style.display = 'none';
    }
}

// Función para cambiar el paso
function changeStep(n) {
    const steps = document.querySelectorAll(".step");

    // Verificar límites de pasos
    if (currentStep + n < 0 || currentStep + n >= steps.length) {
        return;
    }

    // Validar el paso antes de avanzar
    if (n > 0 && !validateStep()) {
        return;
    }

    // Avanzar o retroceder en el paso
    currentStep += n;
    showStep(currentStep);
}

// Validar los campos del paso actual
function validateStep() {
    const activeStep = document.querySelector(".step.active");
    const inputs = activeStep.querySelectorAll("input");

    for (const input of inputs) {
        if (!input.checkValidity()) {
            input.reportValidity();
            return false;
        }
    }
    return true;
}

// Mostrar el primer paso al cargar la página
document.addEventListener("DOMContentLoaded", function() {
    showStep(0);
});
</script>
</body>
</html>




