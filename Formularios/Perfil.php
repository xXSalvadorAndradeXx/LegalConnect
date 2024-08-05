<?php
// Iniciar sesión (si aún no se ha iniciado)
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    // Si el usuario no ha iniciado sesión, redirigirlo al formulario de inicio de sesión
    header("Location: Upss.php");
    exit();
}
if (isset($_GET['logout'])) {
    // Verificar si se ha confirmado la salida
    if ($_GET['logout'] == 'confirm') {
        session_destroy(); // Destruir todas las variables de sesión
        header("Location: /Iniciar_Sesion.php"); // Redirigir al usuario a la página de inicio de sesión
        exit();
    } else {
        // Si no se ha confirmado, redirigir al usuario a esta misma página con un parámetro 'confirm'
        header("Location: {$_SERVER['PHP_SELF']}?logout=confirm");
        exit();
    }
  }

// Obtener el ID de usuario de la sesión
$user_id = $_SESSION['user_id'];

// Conexión a la base de datos (ajusta estos valores según tu configuración)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "legalcc";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener los detalles del usuario de la base de datos
$sql = "SELECT nombre, apellido, telefono, tipo, correo FROM usuarios WHERE id = $user_id";
$result = $conn->query($sql);

// Cerrar conexión
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    

    <style>
.container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    font-family: Bahnschrift, Arial, sans-serif; /* Agregamos Bahnschrift como primera opción */
}

h1 {
    text-align: center;
    margin-bottom: 20px;
    color: #242975;
    font-family: Bahnschrift, Arial, sans-serif; /* Agregamos Bahnschrift como primera opción */
    font-size: 30px;
}

/* Estilos para la tarjeta de usuario */


:root {
  --main-color: #242975; /* Cambio de color principal */
  --accent-color: #2D6653; /* Nuevo color de acento */
}

* {
  padding: 0;
  margin: 0;
  box-sizing: border-box;
}

body {
  font-family: 'Roboto', sans-serif;
  
}

.main-header {
  background: var(--main-color); /* Usar el color principal */
  width: 100%;
  height: 50px;
  display: flex; /* Alinear el contenido del encabezado */
  align-items: center; /* Alinear verticalmente */
  justify-content: space-between; /* Espacio entre los elementos */
  padding: 0 20px; /* Agregar un poco de espacio alrededor del contenido */
}

nav {
  position: absolute;
  left: 0;
  top: 50px;
  width: 200px;
  height: calc(100vh - 50px);
  background: var(--accent-color); /* Usar el nuevo color de acento */
  transform: translateX(-100%);
  transition: .4s ease;
  background-color: #E6F0FF;
}

.navigation li {
  list-style: none;
  width: 100%;
  border-bottom: 1px solid rgba(255, 255, 255, 0.5);

  
}

.navigation a {
  color: #242975; /* Cambiar el color del texto a blanco */
  background-color: #E6F0FF;
  display: block;
  line-height: 3.5;
  padding: 15px 20px; /* Aumentar el espacio alrededor del texto */
  text-decoration: none;
  transition: .4s ease;
  font-family: Bahnschrift;
}

.navigation a:hover {
  background-color: #242975; /* Agregar un color de fondo al pasar el cursor */
  color: #E6F0FF;
  font-family: Bahnschrift;
}

#btn-nav {
  display: none;
}

#btn-nav:checked ~ nav {
  transform: translateX(0);
}

.btn-nav {
  color: #fff; /* Cambiar el color del botón a blanco */
  font-size: 20px; /* Reducir un poco el tamaño del botón */
  cursor: pointer;
  padding: 10px 15px; /* Ajustar el espacio alrededor del botón */
  transition: .2s ease;
  background: transparent; /* Hacer el botón transparente */
  border: none; /* Eliminar el borde del botón */
  outline: none; /* Eliminar el contorno del botón al hacer clic */
}

.btn-nav:hover {
  background: rgba(255, 255, 255, 0.1); /* Cambiar el color de fondo al pasar el cursor */
}


    h2{
      color: black;
      font-size: 10px;
      font-family: Bahnschrift;
      font-size: 10px;
    }

    .user-profile {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 300px;
}

/* Header */
.user-profile h2 {
    color: #333;
    font-size: 20px;
    border-bottom: 2px solid #ddd;
    padding-bottom: 10px;
    margin-bottom: 20px;
}

/* User Info */
.user-info p {
    color: #666;
    margin: 10px 0;
}

.user-info p strong {
    color: #333;
}

/* Highlighted Info */
.highlight {
    color: #1877f2;
    font-weight: bold;
    font-size: 1.1em;
}

/* Error Message */
.error-message {
    color: red;
    font-weight: bold;
}

/* Edit Profile Button */
.edit-profile-btn {
    display: inline-block;
    background-color: #1877f2;
    color: #fff;
    padding: 10px 20px;
    border-radius: 5px;
    text-decoration: none;
    text-align: center;
    margin-top: 20px;
}

.edit-profile-btn:hover {
    background-color: #145dbf;
}


.circle-container {
        width: 90px;
        height: 90px;
        border-radius: 50%; /* Esto hace que el borde sea redondeado, creando un círculo */
        overflow: hidden; /* Oculta cualquier contenido fuera del círculo */
        margin: 50px; /* Añade un margen de 10px alrededor del círculo */
        border: 2px solid #ccc; /* Agrega un borde para mayor claridad */
       
    }
    
    /* Estilo para la imagen */
    .circle-image {
        width: 100%; /* Ajusta el ancho de la imagen al 100% del contenedor */
        height: auto; /* Mantiene la proporción de la imagen */
    }


    .chat {
  display: none;
  border: 2px solid #ccc;
  border-radius: 10px;
  width: 350px;
  height: 490px;
  overflow: hidden;
  position: fixed;
  top: 30px; /* Ajusta este valor según la distancia desde la parte superior que desees */
  right: 10px; /* Ajusta este valor según la distancia desde la derecha que desees */
  cursor: move;
}

#mostrarChat {
      background-color: #242975; /* Color de fondo */
      border: none; /* Sin borde */
      color: white; /* Color del texto */
      padding: 15px 32px; /* Espacio interior */
      text-align: center; /* Alineación del texto */
      text-decoration: none; /* Sin decoración de texto */
      display: inline-block; /* Mostrar como un bloque */
      font-size: 16px; /* Tamaño de fuente */
      margin: 4px 2px; /* Márgenes */
      cursor: pointer; /* Cursor al pasar por encima */
      border-radius: 8px; /* Radio de borde */
    }
    #mostrarChat:hover {
      background-color: cadetblue; /* Cambio de color al pasar el cursor */
    }

    </style>
</head>
<body>

<header class="main-header">

    <label for="btn-nav" class="btn-nav">&#9776;</label>
    <input type="checkbox" id="btn-nav">

  
  <button id="mostrarChat">Mostrar Chat</button>
    <nav>
      <ul class="navigation">
<center>

        <li><a href="/Pagina_principal.php">Inicio</a></li>
        <li><a href="/Audiencias/Buscar_Audiencias.php">Audiencias</a></li>
        <li><a href="/Casos/Agregar_casos.php">Casos</a></li>
        <li><a href="?logout">Cerrar Sesion</a></li>
     
      </ul>
    </nav>
    </center>
  </header>
  <div class="container">
    
<center>
    <div class="user-profile">
    <h2>Datos de Usuario</h2>
    <?php if ($result->num_rows > 0): ?>
        <?php $row = $result->fetch_assoc(); ?>
        <div class="user-info">

       
        <div class="circle-container">

    <img class="circle-image" src="/recursos/profile.png" alt="Tu imagen">

   </div>
            <p class="highlight"><strong></strong> <?php echo $row['nombre']; ?></strong> <?php echo $row['apellido']; ?></p></p>

            <p class="highlight"><strong>Profesión:</strong> <?php echo $row['tipo']; ?></p>
            <p><strong></strong> <?php echo $row['correo']; ?></p>
            <p><strong></strong> <?php echo $row['telefono']; ?></p>
          

    <?php else: ?>
        <p class="error-message">Error: No se encontraron detalles del usuario.</p>
    <?php endif; ?>
    <a href="/Formularios/Editar_Perfil.php" class="edit-profile-btn">Editar Perfil</a>
</div>

</center>

<div id="draggable" class="chat">
    <iframe src="/chat/chat.php" width="350" height="490" frameborder="10"></iframe>
</div>





<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>


document.querySelector('a[href="?logout"]').addEventListener('click', function(event) {
    if (!confirm('¿Estás seguro de que deseas cerrar sesión?')) {
        event.preventDefault(); // Cancelar el evento de clic si el usuario no confirma
    }
});

document.addEventListener("DOMContentLoaded", function() {
  // Obtener referencia al elemento de chat y al botón
  var chat = document.getElementById("draggable");
  var botonMostrar = document.getElementById("mostrarChat");

  // Agregar evento de clic al botón
  botonMostrar.addEventListener("click", function() {
    // Si el chat está oculto, mostrarlo; si no, ocultarlo
    if (chat.style.display === "none") {
      chat.style.display = "block";
    } else {
      chat.style.display = "none";
    }
  });
});

   
</script>

</script>
</body>
</html>


