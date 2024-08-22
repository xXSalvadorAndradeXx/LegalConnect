<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
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

        input[type="email"],
        input[type="password"]
        {
            font-family: Bahnschrift;
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            color: #000;
        }
        button {
            font-family: Bahnschrift;
            width: 420px;
           
            padding: 10px;
            margin-bottom: 10px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            color: #000;
        }

        button {
            font-family: Bahnschrift;
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
        <input type="password" id="contrasena" name="contrasena" required>
        <span class="toggle-password" onclick="togglePasswordVisibility()">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                 <path d="M7.364 4C2.571 4 0 8 0 8s2.57 4 7.364 4c.518 0 1.016-.104 1.486-.298a2.5 2.5 0 0 1-1.047-1.524C7.477 10 7.143 10 7 10c-.143 0-.476 0-.804-.022a2.5 2.5 0 0 1-1.047 1.524A8.158 8.158 0 0 0 7.364 12C12.157 12 14.727 8 14.727 8s-2.57-4-7.364-4zM8 6.364a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3z"/>
                            </svg>
                        </span>


        <p id="error-msg" class="error"></p>
     
        <button type="submit">Iniciar Sesión</button>
    </form>
    <center>
    <p>¿No tienes cuenta? <a href="/Registro_usuario.php">Registrate Ya</a>
    </center>
</div>


<script>


function togglePasswordVisibility() {
    const passwordInput = document.getElementById("contrasena");
    const toggleIcon = document.querySelector(".toggle-password svg");

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        toggleIcon.classList.remove("bi-eye");
        toggleIcon.classList.add("bi-eye-slash");
    } else {
        passwordInput.type = "password";
        toggleIcon.classList.remove("bi-eye-slash");
        toggleIcon.classList.add("bi-eye");
    }
}
       const urlParams = new URLSearchParams(window.location.search);
        const error = urlParams.get('error');

        console.log('Error parameter:', error); // Agrega esto

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

