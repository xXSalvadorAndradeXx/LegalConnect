<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Botones en una Caja</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #2c3e50;
            font-family: 'Roboto', sans-serif;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            color: #ecf0f1;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .box {
            padding: 30px;
            border: 2px solid #3498db;
            border-radius: 15px;
            background-color: #ecf0f1;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        img {
            margin-bottom: 20px;
            border-radius: 10px;
            transition: transform 0.3s;
        }

        img:hover {
            transform: scale(1.05);
        }

        button {
            padding: 12px 20px;
            font-size: 16px;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            margin: 10px 0;
            transition: background-color 0.3s, box-shadow 0.3s;
            width: 100%;
        }

        #boton-arriba {
            background-color: #3498db;
            color: white;
        }

        #boton-abajo {
            background-color: #ecf0f1;
            color: #3498db;
            border: 2px solid #3498db;
        }

        #boton-arriba:hover {
            background-color: #2C3E50;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        #boton-abajo:hover {
            background-color: #2C3E50;
            color: white;
       
        }

        .barra-negra {
            width: 80%;
            height: 2px;
            background-color: #3498db;
            margin: 10px auto;
        }

        .letras {
            font-size: 14px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="box">
            <img src="recursos/inicio.png" alt="Descripción de la imagen" width="190" height="150">
            <button id="boton-arriba" onclick="window.location.href = '/Registro_usuario.php';">Registrarse</button>
            <div class="barra-negra"></div>
            <button id="boton-abajo" onclick="window.location.href = '/Iniciar_Sesion.php';">Iniciar Sesión</button>
        </div>
        <div class="letras">Legal Connect © 2024</div>
    </div>
</body>
</html>
