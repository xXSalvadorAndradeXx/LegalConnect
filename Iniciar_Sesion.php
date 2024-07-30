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
        <p id="error-msg" class="error"></p>
     
        <button type="submit">Iniciar Sesión</button>
    </form>
    <center>
    <p>¿No tienes cuenta? <a href="/Registro_usuario.php">Registrate Ya</a>
    </center>
</div>


<script>
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

