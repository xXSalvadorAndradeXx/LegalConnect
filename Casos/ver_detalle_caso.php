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
      header("Location: Cerrardo.php"); // Redirigir al usuario a la página de inicio de sesión
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
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Caso</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .evidencia img {
            max-width: 100%;
            height: auto;
            margin-bottom: 10px;
        }
        .documento iframe {
            width: 100%;
            height: 500px;
            border: none;
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
            margin-left: 1000px;
            margin-top: 400px;
        }

        #botonArribaIzquierda:hover {
            background-color: #0056b3;
            color: #fff;
        }

        .edit-btn {
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
            margin-left: 1000px;
            margin-top: 80px;
}

.edit-btn:hover {
    background-color: #0056b3;
}







.card {
    border: 1px solid #ccc;
    border-radius: 10px; /* Aumenté el radio del borde para hacerlo más suave */
    padding: 20px;
    margin: 20px auto;
    max-width: 500px; /* Ajusté el ancho máximo para adaptarlo a pantallas más grandes */
    background-color: #ffffff; /* Cambié el color de fondo para que sea más nítido */
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); /* Hice la sombra más pronunciada */
}

/* Estilos para el título */
.card h3 {
    color: #333;
    font-size: 1.5em; /* Aumenté el tamaño del título para hacerlo más prominente */
    text-align: center;
    margin-bottom: 15px; /* Agregué un margen inferior para separarlo del contenido */
}

/* Estilos para los párrafos */
.card p {
    color: #666;
    font-size: 1.1em; /* Aumenté ligeramente el tamaño de la fuente */
    line-height: 1.4; /* Ajusté el espaciado entre líneas para mejorar la legibilidad */
    margin-bottom: 15px;
}

/* Estilos específicos para los elementos fuertes dentro de los párrafos */
.card p strong {
    color: #000;
    font-weight: bold; /* Agregué negrita para resaltar los elementos fuertes */
}


.card2 {
    border: 1px solid #ccc;
    border-radius: 10px; /* Aumenté el radio del borde para hacerlo más suave */
    padding: 20px;
    margin: 20px auto;
    max-width: 800px; /* Ajusté el ancho máximo para adaptarlo a pantallas más grandes */
    background-color: #ffffff; /* Cambié el color de fondo para que sea más nítido */
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); /* Hice la sombra más pronunciada */
}

/* Estilos para el título */
.card2 h3 {
    color: #333;
    font-size: 1.5em; /* Aumenté el tamaño del título para hacerlo más prominente */
    text-align: center;
    margin-bottom: 15px; /* Agregué un margen inferior para separarlo del contenido */
}

/* Estilos para los párrafos */
.card2 p {
    color: #666;
    font-size: 1.1em; /* Aumenté ligeramente el tamaño de la fuente */
    line-height: 1.4; /* Ajusté el espaciado entre líneas para mejorar la legibilidad */
    margin-bottom: 15px;
}

/* Estilos específicos para los elementos fuertes dentro de los párrafos */
.card2 p strong {
    color: #000;
    font-weight: bold; /* Agregué negrita para resaltar los elementos fuertes */
}
button {
    display: inline-block;
    padding: 10px 20px;
    background-color: #007bff;
    color: #fff;
    border: none;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

button:hover {
  background-color: #0056b3;
}



.modal {
            display: none; 
            position: fixed; 
            z-index: 1; 
            padding-top: 100px; 
            left: 0;
            top: 0;
            width: 100%; 
            height: 100%; 
            overflow: auto; 
            background-color: rgb(0,0,0); 
            background-color: rgba(0,0,0,0.9); 
        }

        .modal-content {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
        }

        .close {
            position: absolute;
            top: 15px;
            right: 35px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            transition: 0.3s;
        }

        .close:hover,
        .close:focus {
            color: #bbb;
            text-decoration: none;
            cursor: pointer;
        }

    </style>
</head>
<body>

<header class="main-header">

    <label for="btn-nav" class="btn-nav">&#9776;</label>
    <input type="checkbox" id="btn-nav">
    <h2>LegalConnect</h2>
    <nav>
      <ul class="navigation">
<center>
<a href="/Formularios/Perfil.php">
<div class="circle-container">

    <img class="circle-image" src="recursos/profile.png" alt="Tu imagen">

   </div>
  </a>
        <li><a href="#">Inicio</a></li>
        <li><a href="/Audiencias/Buscar_Audiencias.php">Audiencias</a></li>
        <li><a href="/Casos/Buscar_Casos.php">Casos</a></li>
        <li><a href="?logout">Cerrar Sesion</a></li>
        <h1>LegalConnect v.1</h1>
      </ul>
    </nav>
    </center>
  </header>


  <div id="myModal" class="modal">
    <span class="close">&times;</span>
    <video class="modal-content" id="video01" controls>
        <source src='ruta_del_video.mp4' type='video/mp4'>
        Your browser does not support the video tag.
    </video>
</div>

  <a id="botonArribaIzquierda" href="/Casos/Buscar_Casos.php">Historial de Casos</a>

    <div class="container">
        <?php
        // Verificar si se proporcionó una referencia de caso válida en la URL
        if (isset($_GET['referencia'])) {
            // Conexión a la base de datos
            $servername = "localhost";
            $username = "root";
            $password = "";
            $database = "legalcc";

            $conn = new mysqli($servername, $username, $password, $database);

            // Verificar conexión
            if ($conn->connect_error) {
                die("Conexión fallida: " . $conn->connect_error);
            }

            // Obtener la referencia del caso desde la URL
            $referencia = $_GET['referencia'];


            echo "<a href='editar_caso.php?referencia=$referencia' class='edit-btn'>Editar Caso</a>";


            // Consulta para obtener los detalles del caso
            $sql = "SELECT * FROM casos WHERE referencia = '$referencia'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                // Mostrar los detalles del caso
                echo "<center>";
                echo "<div class='card'>";
                echo "<h3>Detalles del Caso</h3>";
                echo "<p><strong>Generalidades</strong>";
                echo "<p><strong>Referencia:</strong> " . $row["referencia"] . "</p>";
                echo "<p><strong>Víctima:</strong> " . $row["victima"] . "</p>";
                echo "<p><strong>Imputado:</strong> " . $row["imputado"] . "</p>";
                echo "<p><strong>Tipo de Delito:</strong> " . $row["tipo_delito"] . "</p>";
                echo "</center>";

                // Consulta para obtener la evidencia asociada al caso
                $sql_evidencia = "SELECT * FROM evidencias WHERE caso_referencia = '$referencia'";
                $result_evidencia = $conn->query($sql_evidencia);
                if ($result_evidencia->num_rows > 0) {
                  echo "<div class='card2'>";
                    echo "<div class='evidencia'>";
                    echo "<h3>Evidencia</h3>";
                    
                    while($row_evidencia = $result_evidencia->fetch_assoc()) {
                        // Obtener la extensión del archivo
                        $extension = pathinfo($row_evidencia["nombre_archivo"], PATHINFO_EXTENSION);
                        // Mostrar cada archivo de evidencia según su tipo
                        if ($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png' || $extension == 'gif') {
                            // Archivo de imagen
                            echo "<div class='card2'>";
                            echo "<h3>Imagenes</h3>";
                            echo "<img src='" . $row_evidencia["ubicacion_archivo"] . "' alt='Evidencia' width='200' height='200'>";
                            echo "</div class='card2'>";
                        } elseif ($extension == 'mp4' || $extension == 'webm' || $extension == 'ogg') {
                            // Archivo de video
                            echo "<div class='card2'>";
                            echo "<h3>Video</h3>";
                            echo "<video controls>";
                            echo "<source src='" . $row_evidencia["ubicacion_archivo"] . "' type='video/" . $extension . " '>";
                            echo "Your browser does not support the video tag.";
                            echo "</video>";
                            echo '<button id="myBtn">Abrir en grande</button>';

                            echo "</div class='card2'>";
                           
                        } elseif ($extension == 'mp3' || $extension == 'ogg' || $extension == 'wav') {
                            // Archivo de audio
                            echo "<div class='card2'>";
                            echo "<h3>Audio</h3>";
                            echo "<center>";
                            echo "<audio controls>";
                            echo "<source src='" . $row_evidencia["ubicacion_archivo"] . "' type='audio/" . $extension . "'>";

                            echo "Your browser does not support the audio tag.";
                            echo "</audio>";
                            echo "</center>";
                            echo "</div class='card2'>";
                          
                            
                        } else {
                            // Otros tipos de archivos
                            echo "<p>No se puede mostrar la evidencia.</p>";
                        }
                    }
                    echo "</>";
                } else {
                    echo "<p>No hay evidencia asociada a este caso.</p>";
                }
                echo "</div class='card2'>";
                echo "</div class='card2'>";
                echo "<div class='card2'>";
                // Consulta para obtener el documento asociado al caso
                $sql_documento = "SELECT * FROM documentos WHERE caso_referencia = '$referencia'";
                $result_documento = $conn->query($sql_documento);
                if ($result_documento->num_rows > 0) {
                    echo "<div class='documento'>";
                    echo "<h3>Documento</h3>";
                    while($row_documento = $result_documento->fetch_assoc()) {
                        // Mostrar el documento en un iframe
                        echo "<iframe src='" . $row_documento["ubicacion_archivo"] . "'></iframe>";
                    }
                    echo "</div>";
                } else {
                    echo "<p>No hay documento asociado a este caso.</p>";
                }
                echo "</>"; // Cierre de la tarjeta de detalles del caso
            } else {
                echo "<p>No se encontraron detalles para la referencia de caso proporcionada.</p>";
            }

            $conn->close();
        } else {
            echo "<p>No se proporcionó una referencia de caso válida.</p>";
        }

        
        
        ?>
    </div>

    <script>


var modal = document.getElementById("myModal");

    // Get the button that opens the modal
    var btn = document.getElementById("myBtn");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the modal 
    btn.onclick = function() {
        modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    </script>
</body>
</html>
