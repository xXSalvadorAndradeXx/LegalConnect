<?php

session_start(); // Iniciar sesión

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    // Redirigir al usuario a la página de inicio de sesión si no ha iniciado sesión
    header("Location: Upss.php"); 
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
// Conexión a la base de datos
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

$sql = "
    SELECT 
        ar.id, 
        u.nombre AS nombre_usuario, 
        u.apellido AS apellido_usuario, 
        j.nombre AS nombre_juez, 
        j.apellido AS apellido_juez, 
        ar.razon, 
        ar.fecha_sugerida, 
        ar.estado, 
        ar.fecha_creacion,
        ar.respuesta,
        ar.caso_id
       
    FROM 
        solicitudes ar
    JOIN 
        usuarios u ON ar.usuario_id = u.id
    JOIN 
        usuarios j ON ar.juez_id = j.id
";

$result = $conn->query($sql);


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla de Solicitudes</title>
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
  font-family: Bahnschrift;
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

/* Estilo para la tabla */
table {
    width: calc(70% - 40px); /* Ajusta el ancho para incluir el margen */
    border-collapse: collapse;
 
    margin: 20px auto; /* Espacio arriba y abajo, y centrado horizontalmente */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Sombra para darle profundidad */
    border-radius: 8px; /* Bordes redondeados */
    overflow: hidden; /* Asegura que los bordes redondeados se apliquen correctamente */
}

/* Estilo para las celdas de la tabla */
th, td {
  
    border: 1px solid #ddd;
    padding: 12px 15px; /* Mayor padding para mejorar la legibilidad */
    text-align: left;
}

/* Estilo para los encabezados */
th {

    background-color: #f4f4f4; /* Color de fondo más suave */
    color: #333; /* Color del texto */
    font-weight: bold; /* Negrita para los encabezados */
}

/* Estilo para las filas alternas */
tr:nth-child(even) {
    background-color: #f9f9f9; /* Color de fondo alterno para filas pares */
}

/* Estilo para las filas al pasar el mouse por encima */
tr:hover {
    background-color: #f1f1f1; /* Color de fondo al pasar el mouse */
}

.btn-regresar {
    font-family: 'Bahnschrift', sans-serif;
    background-color: #4CAF50; /* Color verde */
    color: white; /* Texto blanco */
    padding: 10px 20px; /* Espaciado interno */
    border: none; /* Sin bordes */
    border-radius: 5px; /* Bordes redondeados */
    margin-left: 1000px;

    cursor: pointer; /* Manito al pasar por encima */
    text-transform: uppercase; /* Texto en mayúsculas */
    font-size: 16px; /* Tamaño de la fuente */
    transition: background-color 0.3s ease; /* Animación en el color de fondo */
}

.btn-regresar:hover {
    background-color: #45a049; /* Color verde más oscuro al pasar el mouse */
}






    </style>
</head>
<body>

<header class="main-header">

    <label for="btn-nav" class="btn-nav">&#9776;</label>
    <input type="checkbox" id="btn-nav">
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












<center>
    <h1>Tabla de Solicitudes</h1>
    
</center>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Juez</th>
                <th>Audiencia ID</th>
                <th>Razón</th>
                <th>Fecha Sugerida</th>
                <th>Estado</th>
                <th>Respuesta</th>
                <th>Fecha de Solicitud</th>

                <?php if ($tipo_usuario === 'juez'): ?>   
                             <th>Acciones</th>
           <?php endif;  ?>
            
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                // Salida de cada fila
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
             
                    echo "<td>" . $row['nombre_usuario'] . " " . $row['apellido_usuario'] . "</td>";
                    echo "<td>" . $row['nombre_juez'] . " " . $row['apellido_juez'] . "</td>";
                    echo "<td>" . $row["caso_id"] . "</td>";

                
                    echo "<td>" . $row["razon"] . "</td>";
                    echo "<td>" . $row["fecha_sugerida"] . "</td>";
                    echo "<td>" . $row["estado"] . "</td>";
                    echo "<td>" . $row["respuesta"] . "</td>";
                    echo "<td>" . $row["fecha_creacion"] . "</td>";
                    
                   
                     if ($tipo_usuario === 'juez' ): ?>   
                        <td><a href='responder_solicitud.php?id=" . $row["id"] . "' class='btn'>Responder Solicitud</a></td>
                        </tr>
                        <?php endif; 
                          
                        
       }
   } else {
                echo "<tr><td colspan='7'>No hay solicitudes disponibles</td></tr>";
            }

            
            $conn->close();
            ?>
        </tbody>
    </table>


    <a onclick="goBack()" class="btn-regresar"> Return <i class="fa fa-return">  </i></a>

</body>


<script>


function goBack() {
    window.history.back();
}

</script>
</html>
