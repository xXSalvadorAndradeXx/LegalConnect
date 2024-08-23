<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #242975;
            font-family: Bahnschrift;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .box {
            background-color: #E6F0FF;
            border: 2px solid #1E90FF; 
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
            border: 2px solid #1E90FF; 
            background-color: #1E90FF; 
            border-radius: 10px;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
            width: 100%;
            max-width: 200px;
        }

        .box button:hover {
            background-color: #0056b3;
        }

        .boton-registro {
            background-color: #007bff;
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
            background-color: #0056b3;
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
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
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
            color: #007bff;
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
    <h2>Registro de Usuario</h2>
    <form action="Proceso_registro.php" method="POST" enctype="multipart/form-data">
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
        
        <label for="correo" style="width: 100%;">Correo Electrónico:</label>
        <input type="email" id="correo" name="correo" required>

        <div class="password-container">
            <div class="password-field">
                <label for="contrasena">Contraseña:</label>
                <input type="password" id="contrasena" name="contrasena" required>
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
        <button type="submit" class="boton-registro">Registrarse</button>
        
        <p>¿Ya tienes cuenta? <a href="/Iniciar_Sesion.php">Iniciar Sesión</a></p>
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
</body>
</html>
