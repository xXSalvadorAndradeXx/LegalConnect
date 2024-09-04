

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


?>
    <?php
    // Suponiendo que tienes una conexión a la base de datos establecida
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

    // Obtener el id de la solicitud a editar
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Consulta para obtener los datos de la solicitud
        $sql = "SELECT * FROM solicitudes WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        } else {
            echo "No se encontró la solicitud.";
            exit;
        }
    } else {
        echo "ID no especificado.";
        exit;
    }

    // Cerrar la base de datos

    //____________________________________ HTML __________________________________________________
    $conn->close();
    ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>

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

.circle-container {
        width: 25px;
        height: 25px;
        border-radius: 50%; /* Esto hace que el borde sea redondeado, creando un círculo */
        overflow: hidden; /* Oculta cualquier contenido fuera del círculo */
        margin: 20px; /* Añade un margen de 10px alrededor del círculo */
        border: 2px solid #ccc; /* Agrega un borde para mayor claridad */
    }
    
    /* Estilo para la imagen */
    .circle-image {
        width: 100%; /* Ajusta el ancho de la imagen al 100% del contenedor */
        height: auto; /* Mantiene la proporción de la imagen */
    }
    h1{
      color: W;
      font-size: 10px;
      font-family: Bahnschrift;
    }
    h2{
      color: white;
      font-size: 20px;
      font-family: Bahnschrift;
    }

    .notification-icon {
    margin-top: 35px;
    margin-left: 1000px;
    top: 0;
    right: 0;
    /* Ajusta el color según sea necesario */
    color: white;
    border-radius: 50%;
    padding: 5px;
    font-size: 20px; /* Ajusta el tamaño del ícono según sea necesario */
    transform: translate(50%, -50%);
}








/* Diseño básico del formulario */
/* Diseño general del formulario */
#editarFormulario {
    max-width: 600px;
    margin: 40px auto;
    padding: 25px;
    border: 1px solid #e0e0e0;
    border-radius: 12px;
    background-color: #ffffff;
    font-family: 'Roboto', sans-serif;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: box-shadow 0.3s ease;
}

#editarFormulario:hover {
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
}

/* Estilo para las etiquetas */
#editarFormulario label {
    display: block;
    margin-bottom: 10px;
    font-weight: 500;
    color: #444;
    font-size: 14px;
}

/* Estilo para los campos de entrada */
#editarFormulario input[type="text"],
#editarFormulario input[type="date"],
#editarFormulario textarea,
#editarFormulario select {
    width: 100%;
    padding: 12px;
    margin-bottom: 20px;
    border: 1px solid #cccccc;
    border-radius: 6px;
    font-size: 15px;
    color: #333;
    background-color: #f8f8f8;
    transition: border-color 0.3s ease, background-color 0.3s ease;
}

#editarFormulario input[type="text"]:focus,
#editarFormulario input[type="date"]:focus,
#editarFormulario textarea:focus,
#editarFormulario select:focus {
    border-color: #007bff;
    background-color: #ffffff;
    outline: none;
}

/* Estilo para el área de texto */
#editarFormulario textarea {
    height: 120px;
    resize: vertical;
}

/* Estilo para el botón de enviar */
#editarFormulario .btn {
    display: inline-block;
    padding: 12px 24px;
    font-size: 16px;
    color: #ffffff;
    background-color: #007bff;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.3s ease;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

#editarFormulario .btn:hover {
    background-color: #0056b3;
    transform: translateY(-2px);
}

#editarFormulario .btn:active {
    background-color: #004494;
    transform: translateY(0);
}



    </style>
</head>
<body>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<header class="main-header">

    <label for="btn-nav" class="btn-nav">&#9776;</label>
    <input type="checkbox" id="btn-nav">

 


<?php if ($tipo_usuario === 'juez'): ?>  
  <a href="ver_solicitudes.php" class="notification-link">
    <i class="fas fa-bell notification-icon"></i>
</a>

  <?php endif; 

?>



    <a href="/Formularios/Perfil.php">
<div class="circle-container">

    <img class="circle-image" src="recursos/profile.png" alt="Tu imagen">

   </div>
  </a>
 
    <nav>
      <ul class="navigation">
<center>

        <li><a href="#">Inicio</a></li>
        <li><a href="/Audiencias/Buscar_Audiencias.php">Audiencias</a></li>
        <li><a href="/Casos/Agregar_Casos.php">Casos</a></li>
        <li><a href="?logout">Cerrar Sesion</a></li>

      
      </ul>
    </nav>
    </center>




    

   
  </header>

  <body>


  <form action="guardar_cambios.php" method="post" id="editarFormulario">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

        <label for="usuario_id">ID del Usuario:</label>
<input type="text" name="usuario_id" id="usuario_id" value="<?php echo $row['usuario_id']; ?>" required readonly>

<label for="juez_id">ID del Juez:</label>
<input type="text" name="juez_id" id="juez_id" value="<?php echo $row['juez_id']; ?>" required readonly>

<label for="caso_id">ID del Caso:</label>
<input type="text" name="caso_id" id="caso_id" value="<?php echo $row['caso_id']; ?>" required readonly>


        <label for="razon">Razón:</label>
        <textarea name="razon" id="razon" required><?php echo $row['razon']; ?></textarea>

        <label for="fecha_sugerida">Fecha Sugerida:</label>
        <input type="date" name="fecha_sugerida" id="fecha_sugerida" value="<?php echo $row['fecha_sugerida']; ?>" required>

        <label for="estado">Estado:</label>
        <select name="estado" id="estado" required>
            <option value="Pendiente" <?php if ($row['estado'] === 'Pendiente') echo 'selected'; ?>>Pendiente</option>
            <option value="Aceptada" <?php if ($row['estado'] === 'Aceptada') echo 'selected'; ?>>Aceptada</option>
            <option value="Rechazada" <?php if ($row['estado'] === 'Rechazada') echo 'selected'; ?>>Rechazada</option>
        </select>

        <div class="form-section" id="respuestaSection" style="display: none;">
          <label for="respuesta"><strong>Respuesta:</strong></label>
        <textarea id="respuesta" name="respuesta"><?php echo $row['respuesta']; ?></textarea></textarea>
</div>
        
        

        <button type="submit" class="btn">Guardar Cambios</button>
    </form>

    <button onclick="goBack()" class="btn-regresar" title="Regresar">
    <i class="fas fa-arrow-left"></i>
</button>


  </body>

<script>

function goBack() {
    window.history.back();
}
  

document.addEventListener("DOMContentLoaded", function() {
    const estadoSelect = document.getElementById("estado");
    const respuestaSection = document.getElementById("respuestaSection");
    const respuestaTextarea = document.getElementById("respuesta");

    // Función para mostrar u ocultar la sección de respuesta
    function toggleRespuestaSection() {
        if (estadoSelect.value === "Rechazada" || estadoSelect.value === "Aceptada") {
            respuestaSection.style.display = "block";
            respuestaTextarea.required = true;
        } else {
            respuestaSection.style.display = "none";
            respuestaTextarea.required = false;
            respuestaTextarea.value = "Sin Respuesta";
        }
    }

    // Verificar el valor inicial al cargar la página
    toggleRespuestaSection();

    // Añadir un evento listener al select para cuando el usuario cambie la opción
    estadoSelect.addEventListener("change", toggleRespuestaSection);
});










document.querySelector('a[href="?logout"]').addEventListener('click', function(event) {
    if (!confirm('¿Estás seguro de que deseas cerrar sesión?')) {
        event.preventDefault(); // Cancelar el evento de clic si el usuario no confirma
    }
});

document.addEventListener("DOMContentLoaded", function() {
  const btnNav = document.getElementById("btn-nav");
  const nav = document.querySelector("nav");

  // Función para abrir/cerrar el menú de navegación
  function toggleNav() {
    nav.classList.toggle("open");
  }

  // Evento click en el botón de navegación
  btnNav.addEventListener("click", function() {
    toggleNav();
  });

  // Evento click fuera del menú para cerrarlo
  document.addEventListener("click", function(event) {
    if (!nav.contains(event.target) && !btnNav.contains(event.target)) {
      nav.classList.remove("open");
    }
  });
});

</script>
    

</html>

  













 

    
</body>
</html>






