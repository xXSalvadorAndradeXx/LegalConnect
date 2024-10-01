<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #2c3e50;
            font-family: Bahnschrift;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .box {
            background-color: #ecf0f1;
          
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 50px;
            max-width: 800px;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .box h2 {
            margin-top: 0;
            text-align: center;
        }

        .box form {
            display: flex;
            flex-direction: column;
            width: 100%;
        }

        .box label {
            margin-bottom: 10px;
            font-weight: bold;
        }

        .box input,
        .box select {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
            outline: none;
            width: 100%;
        }

        .box button {
            padding: 10px 0;
            font-size: 16px;
            background-color: #2c3e50;
            border-radius: 10px;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
            width: 100%;
            max-width: 200px;
        }

        .box button:hover {
            background-color: #374D63;
        }

        .boton-registro {
            background-color: #2c3e50;
            color: white;
            padding: 10px 0;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            max-width: 200px;
        }

        .boton-registro:hover {
            background-color: #374D63;
        }

        .barra-negra {
            width: 80%;
            height: 2px;
            background-color:  #1E90FF;
            margin: 10px 0;
        }

        .letras {
            font-size: 12px;
            color: white;
        }

        p {
            font-size: 16px;
            color: #333;
            margin-bottom: 20px;
        }

        a {
            color: blue;
            
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
            color: #2c3e50;
        }

        .popup {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            max-width: 300px;
            text-align: center;
        }

        .popup.error {
            background-color: #d9534f;
            color: #fff;
        }

        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: black;
            font-size: 18px;
        }
        .password-container {
            display: flex;
            justify-content: space-between;
            width: 100%;
        }

        .password-field {
            position: relative;
            width: 48%;
        }

        img {
            transition: transform 0.3s;
        }

        img:hover {
            transform: scale(1.05);
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









        
    </style>
</head>
<body>
<?php
$error_message = isset($_GET['mensaje']) ? $_GET['mensaje'] : null;
?>

<?php if ($error_message !== null): ?>
    <div class="popup error">
        <p><?php echo $error_message; ?></p>
    </div>
<?php endif; ?>

<div class="box">
    <image src="recursos/inicio.png" alt="Descripción de la imagen" width="190" height="150">

   
    <form action="Proceso_registro.php" method="POST" enctype="multipart/form-data">

<!-- Barra de progreso -->
<div class="progress-bar">
    <div class="progress-step"></div>
    <div class="progress-step"></div>
    <div class="progress-step"></div>
</div>

<!-- Paso 1 -->
<div class="step active">
    <div style="display: flex; justify-content: space-between; width: 100%;">
        <div style="width: 48%;">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>
        </div>
        <div style="width: 48%;">
            <label for="apellido">Apellido:</label>
            <input type="text" id="apellido" name="apellido" required>
        </div>
    </div>
</div>

<!-- Paso 2 -->
<div class="step">
    <div style="display: flex; justify-content: space-between; width: 100%;">
        <div style="width: 48%;">
            <label for="telefono">Teléfono:</label>
            <input type="tel" id="telefono" name="telefono" required>
        </div>
        <div style="width: 48%;">
            <label for="tipo">Oficio:</label>
            <select id="tipo" name="tipo" required>
                <option value="" disabled selected hidden></option>
                <option value="abogado">Abogado</option>
                <option value="juez">Juez</option>
                <option value="fiscal">Fiscal</option>
            </select>
        </div>
    </div>
</div>

<!-- Paso 3 -->
<div class="step">
    <label for="correo" style="width: 100%;">Correo Electrónico:</label>
    <input type="email" id="correo" name="correo" required>

    <div class="password-container">
        <div class="password-field">
            <label for="contrasena">Contraseña:</label>
            <input type="password" id="contrasena" name="contrasena" required minlength="8" maxlength="20" 
                pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%^&+=]).{8,}" 
                title="Debe contener al menos 8 caracteres, incluyendo una mayúscula, una minúscula, un número y un carácter especial (@, #, $, %, ^, &, +, =)">
            <span class="toggle-password" onclick="togglePasswordVisibility('contrasena', 'togglePassword1')">
                <i class="fas fa-eye" id="togglePassword1"></i>
            </span>
        </div>

        <div class="password-field">
            <label for="confirmar_contrasena">Confirmar Contraseña:</label>
            <input type="password" id="confirmar_contrasena" name="confirmar_contrasena" required>
            <span class="toggle-password" onclick="togglePasswordVisibility('confirmar_contrasena', 'togglePassword2')">
                <i class="fas fa-eye" id="togglePassword2"></i>
            </span>
        </div>
    </div>
</div>

<!-- Controles del formulario -->
<div class="button-group">
    <button type="button" id="prevBtn" onclick="changeStep(-1)">Anterior</button>
    <button type="submit" id="nextBtn" onclick="changeStep(1)">Siguiente</button>
</div>

<p>¿Ya tienes cuenta? <a href="/Iniciar_Sesion.php">Iniciar Sesión</a></p>
<center>
    <p>LegalConnect © 2024. Todos los Derechos Reservados.</p>
</center>
</form>



</div>

   

<script>
    function togglePasswordVisibility(inputId, iconId) {
        const passwordField = document.getElementById(inputId);
        const toggleIcon = document.getElementById(iconId);

        if (passwordField.type === "password") {
            passwordField.type = "text";
            toggleIcon.classList.remove("fa-eye");
            toggleIcon.classList.add("fa-eye-slash");
        } else {
            passwordField.type = "password";
            toggleIcon.classList.remove("fa-eye-slash");
            toggleIcon.classList.add("fa-eye");
        }
    }

    document.getElementById("tipo").addEventListener("change", function() {
        if (this.value === "") {
            this.setCustomValidity("Por favor, selecciona un oficio válido.");
        } else {
            this.setCustomValidity("");
        }
    });

    document.getElementById("contrasena").addEventListener("input", function() {
        var confirmarContrasenaInput = document.getElementById("confirmar_contrasena");
        if (this.value !== confirmarContrasenaInput.value) {
            confirmarContrasenaInput.setCustomValidity("Las contraseñas no coinciden");
        } else {
            confirmarContrasenaInput.setCustomValidity("");
        }
    });

    document.getElementById("confirmar_contrasena").addEventListener("input", function() {
        var contrasenaInput = document.getElementById("contrasena");
        if (this.value !== contrasenaInput.value) {
            this.setCustomValidity("Las contraseñas no coinciden");
        } else {
            this.setCustomValidity("");
        }
    });
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
</body>
</html>
