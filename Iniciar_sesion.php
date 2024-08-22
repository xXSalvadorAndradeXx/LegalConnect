<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #242975;
            font-family: Arial, sans-serif;
            color: #fff;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            font-family: Bahnschrift;
            border-radius: 10px;
            background-color: #E6F0FF;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 80px;
            max-width: 400px;
            max-height: 500px;
            width: 100%;
        }

        h2 {
            font-family: Bahnschrift;
            text-align: center;
            margin-bottom: 20px;
            color: #000;
        }

        label {
            font-family: Bahnschrift;
            display: block;
            margin-bottom: 5px;
            color: #000;
        }

        .password-container {
            position: relative;
            width: 100%;
            margin-bottom: 10px;
        }

        input[type="email"],
        input[type="password"] {
            font-family: Bahnschrift;
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            color: #000;
            box-sizing: border-box;
        }
        input[type="text"] {
            font-family: Bahnschrift;
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            color: #000;
            box-sizing: border-box;
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

        button {
            font-family: Bahnschrift;
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            background-color: #42a5f5;
            color: #fff;
            cursor: pointer;
        }

        button:hover {
            background-color: #2196f3;
        }

        .error {
            font-family: Bahnschrift;
            color: red;
            text-align: center;
            margin-top: 10px;
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
    </style>
</head>
<body>

<div class="container">
    <h2>Iniciar Sesión</h2>
    
    <form action="Proceso_Sesion.php" method="POST">
        <label for="correo">Correo Electrónico:</label>
        <input type="email" id="correo" name="correo" required>
        
        <label for="contrasena">Contraseña:</label>
        <div class="password-container">
            <input type="password" id="contrasena" name="contrasena" required>
            <i class="fas fa-eye toggle-password" id="togglePassword"></i>
        </div>
        
        <p id="error-msg" class="error"></p>
     
        <button type="submit">Iniciar Sesión</button>
    </form>
    <center>
    <p>¿No tienes cuenta? <a href="/Registro_usuario.php">Regístrate Ya</a></p>
    </center>
</div>

<script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordField = document.getElementById('contrasena');

    togglePassword.addEventListener('click', function () {
        // Cambiar el tipo de input de password a text o viceversa
        const type = passwordField.type === 'password' ? 'text' : 'password';
        passwordField.type = type;

        // Cambiar el icono
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
    });

    const urlParams = new URLSearchParams(window.location.search);
    const error = urlParams.get('error');

    if (error) {
        const errorMessage = document.getElementById('error-msg');
        errorMessage.textContent = 'Correo electrónico o contraseña incorrectos.';

        setTimeout(function() {
            errorMessage.textContent = '';
        }, 5000);
    }
</script>

</body>
</html>

