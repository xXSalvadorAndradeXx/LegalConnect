<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Casos Archivados</title>
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
    p{
        margin-left: 20%;
    }
  

        a {
            color: #007BFF;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .btn-restaurar{
            background-color: #fff; /* Green */
            border: none;
            color: black;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 8px;
            transition: background-color 0.3s ease;
            font-family: Bahnschrift;
        }

        .btn-restaurar:hover {
            background-color: #0056b3; /* Darker Green on Hover */
            color: #fff;
            font-family: Bahnschrift;
        }



  .table-container, .table-container2 {
    margin: 0 auto;
    max-width: 1000px;
}

.table-container {
    height: 400px;
    margin-top: 100px;
    overflow-y: auto;
}

.custom-table {
    display: flex;
    flex-direction: column;
    border: 1px solid #ddd;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.table-header, .table-row {
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

#botonArribaIzquierda {
            position: fixed;
            top: 400px;
            left: 20px;
            padding: 10px 20px;
            background-color: white;
            color: black;
            text-decoration: none;
            border-radius: 5px;
            font-family: Arial, sans-serif;
            font-size: 16px;
            transition: background-color 0.3s, color 0.3s;
            margin-left: 1200px;
            margin-top: 50px;
        }

        #botonArribaIzquierda:hover {
            background-color: #0056b3;
            color: #fff;
        }

    </style>
</head>
<body>

<header class="main-header">

    <label for="btn-nav" class="btn-nav">&#9776;</label>
    <input type="checkbox" id="btn-nav">
    <a href="/Formularios/Perfil.php">
<div class="circle-container">

    <img class="circle-image" src="Recursos/profile.png" alt="Tu imagen">

   </div>
  </a>
 
    <nav>
      <ul class="navigation">
<center>

        <li><a href="/Pagina_principal.php">Inicio</a></li>
        <li><a href="/Audiencias/Buscar_Audiencias.php">Audiencias</a></li>
        <li><a href="/Casos/Agregar_Casos.php">Casos</a></li>
        <li><a href="?logout">Cerrar Sesion</a></li>
        
      </ul>
    </nav>
    </center>
  </header>
  <center>
<h1>Casos Archivados</h1>
</center>


<a id="botonArribaIzquierda" href="/Casos/Buscar_Casos.php">
    <i class="fas fa-table"></i>
</a>
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

// Consultar los casos archivados
$sql = "SELECT * FROM casos_archivados";
$result = $conn->query($sql);

// Verificar si hay resultados
if ($result->num_rows > 0) {
    echo "<div class='table-container'><table class='custom-table'>
            <tr class='table-header'>
                <th class='table-cell'>Referencia</th>
                <th class='table-cell'>Víctima</th>
                <th class='table-cell'>Imputado</th>
                <th class='table-cell'>Tipo de Delito</th>
                <th class='table-cell'>Fecha de Creación</th>
                <th class='table-cell'>Tiempo para Prescribir</th>
                <th class='table-cell'>Acciones</th>
            </tr>";
    
    // Mostrar cada caso archivado
    while($row = $result->fetch_assoc()) {
        $archivo = htmlspecialchars($row['archivos_documento']);
        $ruta_documento = "Casos/documentos/" . $archivo; // Cambia esta ruta según corresponda

        echo "<tr class='table-row'>
                <td class='table-cell'>" . htmlspecialchars($row['referencia']) . "</td>
                <td class='table-cell'>" . htmlspecialchars($row['victima']) . "</td>
                <td class='table-cell'>" . htmlspecialchars($row['imputado']) . "</td>
                <td class='table-cell'>" . htmlspecialchars($row['tipo_delito']) . "</td>
                <td class='table-cell'>" . htmlspecialchars($row['fecha_creacion']) . "</td>
                <td class='table-cell'>" . htmlspecialchars($row['fecha_expiracion']) . "</td>
                <td class='table-cell'>
    <a href='restaurar_caso.php?referencia=" . urlencode($row['referencia']) . "'>
        <button class='btn-restaurar'>
            <i class='fas fa-undo'></i>
        </button>
    </a>
</td>

              </tr>";
    }
    echo "</table></div>";
} else {
    echo "<p class='no-data'>No hay casos archivados.</p>";
}

// Cerrar la conexión
$conn->close();
?>

<script>

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

