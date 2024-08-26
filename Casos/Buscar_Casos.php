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

<?php
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

// Consulta para obtener los casos con sus documentos
$sql = "SELECT casos.*, GROUP_CONCAT(documentos.nombre_archivo) AS archivos_documento 
        FROM casos 
        LEFT JOIN documentos ON casos.referencia = documentos.caso_referencia 
        GROUP BY casos.id";

$result = $conn->query($sql);
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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

    .table-container {
    margin: 0 auto;
    max-width: 800px;
    height: 400px;
    margin-top: 10px;
    overflow-y: auto;
}

.table-container2 {
    margin: 0 auto;
    max-width: 800px;
}

.custom-table {
    display: flex;
    flex-direction: column;
    border: 1px solid #ddd;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.table-header,
.table-row {
    display: flex;
}

.table-cell {
    flex: 1;
    padding: 12px;
    border-bottom: 1px solid #ddd;
}

.table-header {
    font-weight: bold;
    background-color: #f2f2f2;
}

.no-data {
    padding: 12px;
    text-align: center;
}



 /* Estilo para el campo de entrada de texto */
#inputBusqueda {
  padding: 10px;
        width: 700px; /* Ancho aumentado a 400px */
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
        transition: border-color 0.3s ease;
        margin-top: 50px; /* Añadir margen superior */
}

/* Estilo cuando el campo de entrada está enfocado */
#inputBusqueda:focus {
  outline: none;
        border-color: #66afe9;
}

/* Placeholder */
#inputBusqueda::placeholder {
  color: #999;
}

/* Estilo para el contenedor del campo de entrada */
.container {
  margin: 0 auto;
    
}

.edit-button {
  display: inline-block;
  background-color: white;
  color: black;
  padding: 10px 20px;
  text-decoration: none;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-family: Bahnschrift;
  position: relative;
    display: inline-block;
    
}

.edit-button:hover {
  background-color: #0056b3;
  color: white;
  font-family: Bahnschrift;
}



.edit-button:hover .tooltiptext {
    visibility: visible;
    opacity: 1;
    background-color: black; 
  font-family: Bahnschrift;
  color: white;
}


.edit-button .tooltiptext {
    visibility: hidden;
    width: 120px;
    background-color: black;
    color: #fff;
    text-align: center;
    border-radius: 5px;
    padding: 5px 0;

    /* Posicionamiento */
    position: absolute;
    z-index: 1;
    bottom: 125%; /* Ajusta según la posición deseada */
    left: 50%;
    margin-left: -60px;

    /* Flecha */
    opacity: 0;
    transition: opacity 0.3s;
}

.edit-button:hover .tooltiptext {
    visibility: visible;
    opacity: 1;
}



/*___________Archive___________*/


.archive-button {
  display: inline-block;
  background-color: white;
  color: black;
  padding: 10px 20px;
  text-decoration: none;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-family: Bahnschrift;
  position: relative;
    display: inline-block;
    
}

.archive-button:hover {
  background-color: #0056b3;
  color: white;
  font-family: Bahnschrift;
}



.archive-button:hover .tooltiptext2 {
    visibility: visible;
    opacity: 1;
    background-color: black; 
  font-family: Bahnschrift;
  color: white;
}


.archive-button .tooltiptext2 {
    visibility: hidden;
    width: 120px;
    background-color: black;
    color: #fff;
    text-align: center;
    border-radius: 5px;
    padding: 5px 0;

    /* Posicionamiento */
    position: absolute;
    z-index: 1;
    bottom: 125%; /* Ajusta según la posición deseada */
    left: 50%;
    margin-left: -60px;

    /* Flecha */
    opacity: 0;
    transition: opacity 0.3s;
}

.archive-button:hover .tooltiptext2 {
    visibility: visible;
    opacity: 1;
}


/*_____Agregar Casos_____*/

.archive-button {
  display: inline-block;
  background-color: white;
  color: black;
  padding: 10px 20px;
  text-decoration: none;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-family: Bahnschrift;
  position: relative;
    display: inline-block;
    
}

.archive-button:hover {
  background-color: #0056b3;
  color: white;
  font-family: Bahnschrift;
}



.archive-button:hover .tooltiptext2 {
    visibility: visible;
    opacity: 1;
    background-color: black; 
  font-family: Bahnschrift;
  color: white;
}


.archive-button .tooltiptext2 {
    visibility: hidden;
    width: 120px;
    background-color: black;
    color: #fff;
    text-align: center;
    border-radius: 5px;
    padding: 5px 0;

    /* Posicionamiento */
    position: absolute;
    z-index: 1;
    bottom: 125%; /* Ajusta según la posición deseada */
    left: 50%;
    margin-left: -60px;

    /* Flecha */
    opacity: 0;
    transition: opacity 0.3s;
}

.archive-button:hover .tooltiptext2 {
    visibility: visible;
    opacity: 1;
}

/*_____Agregar Casos_____*/


#botonArribaIzquierda {
    position: fixed;
    top: 400px;
    left: 20px;
    padding: 10px 20px;
    background-color: white;
    color: black;
    text-decoration: none;
    border-radius: 5px;
    margin-top: 60px;
    font-family: Arial, sans-serif;
    font-size: 16px;
    margin-left: 1200px;
    transition: background-color 0.3s, color 0.3s;
    display: inline-block; /* Asegura que el tooltip se posicione correctamente */
}

#botonArribaIzquierda:hover {
    background-color: #0056b3;
    color: #fff;
}

/* Estilos para el tooltip */
#botonArribaIzquierda .tooltiptext {
    visibility: hidden;
    width: 120px;
    background-color: black;
    color: #fff;
    text-align: center;
    border-radius: 5px;
    padding: 5px 0;
    position: absolute;
    z-index: 1;
    bottom: 125%; /* Ajusta la posición del tooltip */
    left: 50%;
    margin-left: -60px;
    opacity: 0;
    transition: opacity 0.3s;
    font-family: Arial, sans-serif;
}

#botonArribaIzquierda:hover .tooltiptext {
    visibility: visible;
    opacity: 1;
}

/*____Archivo____*/

#botonArribaIzquierda3 {
    position: fixed;
    top: 400px;
    left: 20px;
    padding: 10px 20px;
    background-color: white;
    color: black;
    text-decoration: none;
    border-radius: 5px;
    margin-top: 60px;
    font-family: Arial, sans-serif;
    font-size: 16px;
    margin-left: 1270px;
    transition: background-color 0.3s, color 0.3s;
    display: inline-block; /* Asegura que el tooltip se posicione correctamente */
}

#botonArribaIzquierda3:hover {
    background-color: #0056b3;
    color: #fff;
}

/* Estilos para el tooltip */
#botonArribaIzquierda3 .tooltiptext {
    visibility: hidden;
    width: 120px;
    background-color: black;
    color: #fff;
    text-align: center;
    border-radius: 5px;
    padding: 5px 0;
    position: absolute;
    z-index: 1;
    bottom: 125%; /* Ajusta la posición del tooltip */
    left: 50%;
    margin-left: -60px;
    opacity: 0;
    transition: opacity 0.3s;
    font-family: Arial, sans-serif;
}

#botonArribaIzquierda3:hover .tooltiptext {
    visibility: visible;
    opacity: 1;
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

  <a id="botonArribaIzquierda" href="/Casos/Agregar_casos.php">
    <i class="fas fa-plus"></i>
    <span class="tooltiptext">Agregar Caso</span>
</a>
<a id="botonArribaIzquierda3" href="/Archivados/casos_archivados.php">
    <i class="fas fa-archive"></i>
    <span class="tooltiptext">Casos Archivados</span>
</a>


  <div class="container">
<center>
 
  </center>
  <div class="container">
<center>                                                     
  <input type="text" id="inputBusqueda" onkeyup="buscarCasos()" placeholder="Buscar casos..." >
  </center>
  <div class="table-container">
    <div class="custom-table" id="casosTabla">
        <div class="table-header">
            <div class="table-cell">Referencia</div>
            <div class="table-cell">Víctima</div>
            <div class="table-cell">Imputado</div>
            <div class="table-cell">Tipo de Delito</div>
            <div class="table-cell">Documentos</div>
            <div class="table-cell">Fecha</div>
            <div class="table-cell">Acciones</div>
        </div>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<div class='table-row'>";
                echo "<div class='table-cell referencia'>" . $row["referencia"] . "</div>";
                echo "<div class='table-cell'>" . $row["victima"] . "</div>";
                echo "<div class='table-cell'>" . $row["imputado"] . "</div>";
                echo "<div class='table-cell'>" . $row["tipo_delito"] . "</div>";
                
                echo "<div class='table-cell'>";
                if (!empty($row["archivos_documento"])) {
                    $archivos_documento = explode(",", $row["archivos_documento"]);
                    foreach ($archivos_documento as $archivo) {
                        echo "<a href='documentos/" . $archivo . "' target='_blank'>" . $archivo . "</a><br>";
                    }
                } else {
                    echo "Sin documentos";
                }
                
                echo "</div>";
                echo "<div class='table-cell'>" . $row["fecha_creacion"] . "</div>";
                echo "<div class='table-cell'>";
                //echo "<button class='delete-button' onclick=\"eliminarCaso('" . $row["referencia"] . "')\">Eliminar</button>";
                echo "<center>
        <a class='edit-button' href='ver_detalle_caso.php?referencia=" . $row['referencia'] . "'>
            <i class='fas fa-info-circle'></i>
            <span class='tooltiptext'>Detalles de Caso</span>
        </a>
      </center>";

        
      echo "<center>";
      echo "<button class='archive-button' onclick=\"archivarCaso('" . $row['referencia'] . "')\">
              <i class='fas fa-archive'></i>
              <span class='tooltiptext2'>Archivar caso</span>
            </button>";
      echo "</center>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<div class='no-data' colspan='6'>No hay casos registrados.</div>";
        }
        ?>
    </div>
</div>

<!-- Modal para confirmar archivado -->
<!-- Modal para confirmar archivado -->
<div id="archiveModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <p>Se descargarán las evidencias y documentos. ¿Estás seguro de que deseas archivar este caso?</p>
    <button id="confirmArchive" class="modal-button"><i class="fas fa-check"></i></button>
    <button id="cancelArchive" class="modal-button2">X</button>
  </div>
</div>

<!-- Contenedor de notificación -->
<div id="notification" class="notification">
  <p id="notificationMessage"></p>
</div>


<style>
/* Estilos para el modal */
.modal {
  display: none; /* Oculto por defecto */
  position: fixed;
  z-index: 1000;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0, 0, 0, 0.4);
}

.modal-content {
  background-color: white;
  margin: 15% auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
  max-width: 400px;
  border-radius: 10px;
  font-family: Bahnschrift;
  text-align: center;
}

.modal-content p {
  margin-bottom: 20px;
  font-size: 16px;
}

.modal-button {
  background-color: white;
  color: black;
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-family: Bahnschrift;
  margin: 5px;
}

.modal-button:hover {
  background-color: #003f7f;
  color: white;
  
}


.modal-button2 {
  background-color: #0056b3;
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-family: Bahnschrift;
  margin: 5px;
}

.modal-button2:hover {
  background-color: #003f7f;
}
.close {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
  cursor: pointer;
}

.close:hover,
.close:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}

/* Estilos para la notificación */
.notification {
  display: none; /* Oculto por defecto */
  position: fixed;
  bottom: 20px;
  right: 20px;
  background-color: #0056b3;
  color: white;
  padding: 15px;
  border-radius: 5px;
  font-family: Bahnschrift;
  z-index: 1001;
}

.notification.show {
  display: block;
}


</style>




<script>


function archivarCaso(referencia) {
    // Mostrar el modal
    var modal = document.getElementById("archiveModal");
    modal.style.display = "block";

    // Obtener botones del modal
    var confirmBtn = document.getElementById("confirmArchive");
    var cancelBtn = document.getElementById("cancelArchive");
    var closeBtn = document.getElementsByClassName("close")[0];

    // Cuando el usuario confirma el archivado
    confirmBtn.onclick = function() {
        modal.style.display = "none";

        // Mostrar notificación
        showNotification("El caso ha sido archivado exitosamente.");

        // Simular la redirección después de un corto tiempo
        setTimeout(function() {
            window.location.href = "archivar_caso.php?referencia=" + referencia;
        }, 1000); // Cambiar a 0 o eliminar para redirigir inmediatamente
    }

    // Cuando el usuario cancela el archivado o cierra el modal
    cancelBtn.onclick = closeBtn.onclick = function() {
        modal.style.display = "none";
    }

    // Cerrar el modal si el usuario hace clic fuera de él
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
}

function showNotification(message) {
    var notification = document.getElementById("notification");
    var notificationMessage = document.getElementById("notificationMessage");
    
    notificationMessage.innerText = message;
    notification.classList.add("show");

    // Ocultar la notificación después de 3 segundos
    setTimeout(function() {
        notification.classList.remove("show");
    }, 3000);
}




function ordenarPorReferencia() {
    var table, rows, switching, i, x, y, shouldSwitch;
    table = document.getElementById("casosTabla");
    switching = true;

    // Hacer un bucle hasta que no haya más cambios
    while (switching) {
        switching = false;
        rows = table.getElementsByClassName("table-row");

        // Bucle a través de todas las filas de la tabla (excepto el encabezado)
        for (i = 0; i < (rows.length - 1); i++) {
            shouldSwitch = false;

            // Obtener los dos elementos que se compararán
            x = rows[i].getElementsByClassName("referencia")[0];
            y = rows[i + 1].getElementsByClassName("referencia")[0];

            // Verificar si las dos filas deben cambiar de lugar
            if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                shouldSwitch = true;
                break;
            }
        }

        if (shouldSwitch) {
            // Hacer el cambio y marcar que se ha hecho un cambio
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
        }
    }
}

// Ejecutar la función de ordenación al cargar la página
window.onload = function() {
    ordenarPorReferencia();
};










function buscarCasos() {
    var input, filter, table, rows, cells, i, j, cellValue, shouldDisplay;
    input = document.getElementById("inputBusqueda");
    filter = input.value.toLowerCase();
    table = document.getElementById("casosTabla");
    rows = table.getElementsByClassName("table-row");

    for (i = 0; i < rows.length; i++) {
        cells = rows[i].getElementsByClassName("table-cell");
        shouldDisplay = false;

        for (j = 0; j < cells.length; j++) {
            if (cells[j]) {
                cellValue = cells[j].textContent || cells[j].innerText;
                if (cellValue.toLowerCase().indexOf(filter) > -1) {
                    shouldDisplay = true;
                    break;
                }
            }
        }

        if (shouldDisplay) {
            rows[i].style.display = "";
        } else {
            rows[i].style.display = "none";
        }
    }
}


function eliminarCaso(referencia) {
    if (confirm("¿Estás seguro de que deseas eliminar este caso?")) {
        // Redireccionar a la página de eliminación con la referencia del caso
        window.location.href = "eliminar_caso.php?referencia=" + referencia;
    }
}


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
    
</body>
</html>
