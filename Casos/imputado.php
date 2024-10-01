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
        header("Location: /Casos/impudatos.php");
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

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
            margin-top: 30px;
            align-self: center;
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

        label {
            display: block;
            margin-bottom: 5px;
            color: #666;
            font-size: 14px;
        }

        input[type="text"],
        input[type="date"],
        select,
        textarea {
            width: 95%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        input[type="text"]:focus,
        input[type="date"]:focus,
        select:focus,
        textarea:focus {
           
            border-color: #66afe9;
            outline: none;
            box-shadow: 0px 0px 5px rgba(102, 175, 233, 0.5);
        }

        textarea {
            height: 100px;
            resize: none;
        }

        .button-group {
            display: flex;
            justify-content: space-between;
        }

        button {
            background-color: #007bff;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .button-group button[disabled] {
            background-color: #cccccc;
            cursor: not-allowed;
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
    <script>
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

<script>
        




        let currentStep = 0;

        // Mostrar la siguiente sección
        function showStep(step) {
            const steps = document.querySelectorAll(".step");
            steps.forEach((s, index) => {
                s.classList.toggle("active", index === step);
            });

            const progressSteps = document.querySelectorAll(".progress-step");
            progressSteps.forEach((p, index) => {
                p.classList.toggle("active", index <= step);
            });

            currentStep = step;

            document.getElementById("prevBtn").disabled = step === 0;
            document.getElementById("nextBtn").textContent = step === steps.length - 1 ? "Registrar" : "Siguiente";
        }

        // Ir al siguiente o anterior paso
        function changeStep(n) {
            const steps = document.querySelectorAll(".step");
            if (currentStep + n < 0 || currentStep + n >= steps.length) {
                return;
            }

            if (n > 0 && !validateStep()) return; // Validar antes de avanzar

            currentStep += n;
            showStep(currentStep);
        }

        // Validar que los campos de cada paso estén completos
        function validateStep() {
            const activeStep = document.querySelector(".step.active");
            const inputs = activeStep.querySelectorAll("input, select, textarea");
            for (const input of inputs) {
                if (!input.checkValidity()) {
                    input.reportValidity();
                    return false;
                }
            }
            return true;
        }

        document.addEventListener("DOMContentLoaded", function() {
            showStep(0); // Mostrar el primer paso al cargar la página
        });
    </script>
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

    <form action="" method="POST">
        <div class="progress-bar">
            <div class="progress-step"></div>
            <div class="progress-step"></div>
            <div class="progress-step"></div>
        </div>

        <!-- Paso 1 -->
        <div class="step active">
            <h1>Datos Generales</h1>

            <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" name="apellido" required><br>

        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br>

        <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
        <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required><br>

        <label for="dui">DUI:</label>
        <input type="text" id="dui" name="dui" pattern="\d{8}-\d{1}" title="El formato debe ser 00000000-0" required><br>

        </div>

        <!-- Paso 2 -->
        <div class="step">
        <h1>Direccion</h1>


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
        <textarea id="direccion" name="direccion" required></textarea>
        </div>

        <!-- Paso 3 -->
        <div class="step">

        <h1>Origenes</h1>
            <label for="madre">Nombre de la Madre:</label>
            <input type="text" id="madre" name="madre" required>

            <label for="padre">Nombre del Padre:</label>
            <input type="text" id="padre" name="padre" required>

            <label for="pandilla">Pandilla:</label>
            <input type="text" id="pandilla" name="pandilla" required>

            <label for="alias">Alias:</label>
            <input type="text" id="alias" name="alias" required>
        </div>

        <div class="button-group">
            <button type="button" id="prevBtn" onclick="changeStep(-1)" disabled>Anterior</button>
            <button type="submit" id="nextBtn" onclick="changeStep(1)">Siguiente</button>
           
        </div>
    </form>
</body>
</html>

