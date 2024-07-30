<?php
session_start(); // Iniciar sesión

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    // Redirigir al usuario a la página de inicio de sesión si no ha iniciado sesión
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

// Resto del código aquí (contenido de la página principal)
//___________________________________________HTML Normal_____________________________________________________________________________________
?>

<!DOCTYPE html>
<html>
<head>
    <title>Detalles de Audiencia</title>

    <style>

.container {
    display: flex;
    flex-direction: column;
    width: 100%;
}



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
  overflow: hidden;
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
        width: 70px;
        height: 70px;
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

    .user-card {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    padding: 50px;
    margin-bottom: 20px;
    margin-left: 300px;
    font-family: Bahnschrift, Arial, sans-serif; /* Agregamos Bahnschrift como primera opción */
    margin-right: 300px;
    margin-top: 20px;
}


.user-card h2 {
    color: #333;
    font-size: 28px;
    margin-bottom: 15px;
    text-align: center;
}

.user-card p {
    color: #444;
    font-size: 18px;
    margin: 8px 0;
}

.user-card strong {
    font-weight: bold;
}

.user-card .details {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
}

.user-card .details > div {
    width: 48%;
    margin-bottom: 15px;
}

@media (max-width: 768px) {
    .user-card .details > div {
        width: 100%;
    }
}
/* Estilo para el botón */


/* Estilo para el enlace */
a {
  text-decoration: none; /* Sin decoración de texto */
}

/* Cambio de estilo para el enlace al pasar el ratón por encima */
a:hover {
  text-decoration: underline; /* Subrayado al pasar el ratón */
}

#botonArribaIzquierda {
            position: fixed;
            top: 20px;
            left: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border: 2px solid #007bff;
            border-radius: 5px;
            font-family: Arial, sans-serif;
            font-size: 16px;
            transition: background-color 0.3s, color 0.3s;
            margin-left: 889px;
            margin-top: 500px;
        }

        #botonArribaIzquierda:hover {
            background-color: #0056b3;
            color: #fff;
        }



        #botonRegresar {
            position: fixed;
            top: 20px;
            left: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border: 2px solid #007bff;
            border-radius: 5px;
            font-family: Arial, sans-serif;
            font-size: 16px;
            transition: background-color 0.3s, color 0.3s;
            margin-left: 280px;
            margin-top: 500px;
        }

        #botonRegresar:hover {
            background-color: #0056b3;
            color: #fff;
        }
    </style>
</head>
<body>

<header class="main-header">

    <label for="btn-nav" class="btn-nav">&#9776;</label>
    <input type="checkbox" id="btn-nav">
    
    <nav>
      <ul class="navigation">
<center>
<a href="/Formularios/Perfil.php">
<div class="circle-container">

    <img class="circle-image" src="recursos/profile.png" alt="Tu imagen">

   </div>
   </a>
        <li><a href="/Pagina_principal.php">Inicio</a></li>
        <li><a href="/Audiencias/Buscar_Audiencias.php">Audiencias</a></li>
        <li><a href="/Casos/Agregar_Casos.php">Casos</a></li>
        <li><a href="?logout">Cerrar Sesion</a></li>
        <h1>LegalConnect v.1</h1>
      </ul>
    </nav>
    </center>
  </header>

   
<?php
// Conexión a la base de datos MySQL
$servername = "localhost";
$username = "root";
$password = "";
$database = "legalcc";

$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

// Obtener el ID de la audiencia de la URL
$id = $_GET["id"];

// Consulta para obtener la información de la audiencia específica
$sql = "SELECT * FROM audiencias WHERE id = $id";
$result = $conn->query($sql);

// Mostrar la información de la audiencia
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();



} else {
    echo "No se encontró la audiencia.";
}



 
// Cerrar la conexión
$conn->close();
?>

<div class="user-card">
<h2>Detalles de Audiencia</h2>
    <div style="display: flex; justify-content: space-between; width: 100%;">
        <div style="width: 48%;">
            <p><strong>Título:</strong> <?php echo $row["titulo"]; ?></p>
        </div>
    </div>

    <div style="display: flex; justify-content: space-between; width: 100%;">
        <div style="width: 48%;">
            <p><strong>Caso:</strong> <?php echo $row["caso"]; ?></p>
        </div>
            
    <div style="width: 48%;">   
            <p><strong>Víctima:</strong> <?php echo $row["victima"]; ?></p>
        </div>
    <div style="width: 48%;"> 
            <p><strong>Imputado:</strong> <?php echo $row["imputado"]; ?></p>
        </div>
    </div>

    <div style="display: flex; justify-content: space-between; width: 100%;">
        <div style="width: 48%;">
            <p><strong>Descripción:</strong> <?php echo $row["descripcion"]; ?></p>
            </div>
    </div>

    <div style="display: flex; justify-content: space-between; width: 100%;">
        <div style="width: 48%;">
            <p><strong>Delito:</strong> <?php echo $row["delito"]; ?></p>
            </div>
    <div style="width: 48%;">   
            <p><strong>Fecha:</strong> <?php echo $row["fecha"]; ?></p>
            </div>
    <div style="width: 48%;">   
            <p><strong>Hora:</strong> <?php echo $row["hora"]; ?></p>
            </div>
    </div>

    <div style="display: flex; justify-content: space-between; width: 100%;">
        <div style="width: 48%;">    

            <p><strong>Modalidad:</strong> <?php echo $row["modalidad"]; ?></p>
     </div>
    <div style="width: 48%;">       
            <p><strong>Juzgado:</strong> <?php echo $row["juzgado"]; ?></p>
            </div>
    <div style="width: 48%;">
            <p><strong>Abogado:</strong> <?php echo $row["abogado"]; ?></p>
            </div>
    </div>    
    
    <div style="display: flex; justify-content: space-between; width: 100%;">
    <div style="width: 48%;"> 
            <p><strong>Fiscal:</strong> <?php echo $row["fiscal"]; ?></p>
            </div>
    <div style="width: 48%;">
            <p><strong>Juez:</strong> <?php echo $row["juez_suplente"]; ?></p>
            </div>
    <div style="width: 48%;">   
            <p><strong>Sala:</strong> <?php echo $row["sala"]; ?></p>

            </div>
    </div> 
</div>


    <?php


echo '<a id="botonArribaIzquierda" href="editar_audiencia.php?id=' . $id . '">Reprogramar Audiencias</a>';

echo '';

  
    ?>

    <a id="botonRegresar" href="/Audiencias/Buscar_Audiencias.php">Volver a la tabla</a>


</body>
</html>
