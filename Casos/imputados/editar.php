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
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-container {
            background-color: white;
            padding: 20px;
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
    </style>
</head>
<body>
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




