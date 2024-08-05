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
      header("Location: Iniciar_Sesion.php"); // Redirigir al usuario a la página de inicio de sesión
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
    <title>Editar Audiencia</title>

    <style>
        body {
            font-family: Arial, sans-serif;
           
            margin: 0;
           
        }
        .container {
            max-width: 1000px;
    margin: 0px auto;
    padding: 0px;
    font-family: Bahnschrift, Arial, sans-serif; /* Agregamos Bahnschrift como primera opción */
    margin-top: 40px;
        }
 
        label {
        font-weight: bold;
        
    }

    h2 {
        text-align: center;
    }
    
    input[type="text"],
    input[type="date"],
    input[type="time"],
    select,
    textarea {
        width: 100%;
        padding: 8px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;

        }
        input[type="submit"] {
        width: 20%;
background-color: #1E90FF;
color: white;
padding: 10px;
border: none;
border-radius: 4px;
cursor: pointer;
font-size: 16px;
float: right;

    }
    input[type="submit"]:hover {
        background-color: #242975;
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

h1{
 font-size: 22px;
 
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

  </a>
         <li><a href="/Formularios/Perfil.php">Perfil</a></li>
        <li><a href="/Pagina_principal.php">Inicio</a></li>
        <li><a href="/Audiencias/Buscar_Audiencias.php">Audiencias</a></li>
        <li><a href="/Casos/Agregar_Casos.php">Casos</a></li>
        <li><a href="?logout">Cerrar Sesion</a></li>
      
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

// Si se envió el formulario de edición, actualizar la audiencia en la base de datos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recopilar datos del formulario
    $id = $_POST["id"];
    $titulo = $_POST["titulo"];
    $caso = $_POST["caso"];
    $modalidad = $_POST["modalidad"];
    $fecha = $_POST["fecha"];
    $hora = $_POST["hora"];
    $imputado = $_POST["imputado"];
    $victima = $_POST["victima"];
    $delito = $_POST["delito"];
    $descripcion = $_POST["descripcion"];
    $juzgado = $_POST["juzgado"];
    $abogado = $_POST["abogado"];
    $fiscal = $_POST["fiscal"];
    $sala = $_POST["sala"];
    $juez_suplente = $_POST["juez_suplente"];
    
    
    // Actualizar la audiencia en la base de datos
    $sql = "UPDATE audiencias SET titulo='$titulo', caso='$caso', modalidad='$modalidad', fecha='$fecha', hora='$hora', imputado='$imputado', victima='$victima', delito='$delito', descripcion='$descripcion', juzgado='$juzgado', abogado='$abogado', fiscal='$fiscal', sala='$sala', juez_suplente='$juez_suplente' WHERE id=$id";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: ver_audiencia.php?id=$id");
        exit();
    } else {
        echo "Error al actualizar la audiencia: " . $conn->error;
    }
}


// Obtener el ID de la audiencia de la URL
$id = $_GET["id"];

// Consulta para obtener la información de la audiencia específica
$sql_audiencia = "SELECT * FROM audiencias WHERE id = $id";
$result_audiencia = $conn->query($sql_audiencia);

// Mostrar el formulario de edición de la audiencia
if ($result_audiencia->num_rows > 0) {
    $row = $result_audiencia->fetch_assoc();

    // Consulta para obtener los casos
    $sql_cases = "SELECT referencia FROM casos";
    $result_cases = $conn->query($sql_cases);

    // Variable para almacenar la referencia del caso seleccionado (si es que hay uno seleccionado)
    $selected_case = ""; // Esto debe ser establecido previamente según el caso seleccionado
    ?>
    <div class="container">


    
    </div>
   <center><h1>Reprogramacion</h1></center>
<div class="container">
    
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

<div style="display: flex; justify-content: space-between; width: 100%;">
    <div style="width: 48%;">
        <label for="titulo">Título de Audiencia:</label><br>
        <input type="text" id="titulo" name="titulo" value="<?php echo $row['titulo']; ?>"><br>
        </div>
    <div style="width: 48%;">       
        <label for="caso">Seleccionar Caso:</label><br>
        <select id="caso" name="caso">
        <?php
// Obtener la referencia del caso seleccionado (si existe)
$selected_case = $row['caso'];

// Verificar si hay resultados de la consulta
if ($result_cases->num_rows > 0) {
    // Imprimir cada opción del menú desplegable
    while($row_case = $result_cases->fetch_assoc()) {
        $referencia = $row_case["referencia"];
        // Verificar si la referencia coincide con el caso seleccionado
        $selected = ($referencia == $selected_case) ? "selected" : "";
        echo "<option value='$referencia' $selected>$referencia</option>";
    }
} else {
    echo "<option value=''>No hay casos disponibles</option>";
}
?>

    </div>
</div>

</div>
<div style="display: flex; justify-content: space-between; width: 100%;">
    <div style="width: 48%;">    
        <label for="fecha">Fecha:</label><br>
        <input type="date" id="fecha" name="fecha" value="<?php echo $row['fecha']; ?>"><br>
        </div> 
    <div style="width: 48%;">  
        <label for="hora">Hora:</label><br>
        <input type="time" id="hora" name="hora" value="<?php echo $row['hora']; ?>"><br>
     </div>
     <div style="width: 48%;">
    <label for="modalidad">Modalidad de Audiencia:</label><br>
    <select id="modalidad" name="modalidad">
        <option value="Presencial" <?php if ($row['modalidad'] == 'Presencial') echo 'selected'; ?>>Presencial</option>
        <option value="Virtual" <?php if ($row['modalidad'] == 'Virtual') echo 'selected'; ?>>Virtual</option>
    </select><br>
    </div>
</div>    

<div style="display: flex; justify-content: space-between; width: 100%;">
    <div style="width: 48%;">
        <label for="imputado">Imputado:</label><br>
        <input type="text" id="imputado" name="imputado" value="<?php echo $row['imputado']; ?>"><br>
        </div>
    <div style="width: 48%;">        
        <label for="victima">Víctima:</label><br>
        <input type="text" id="victima" name="victima" value="<?php echo $row['victima']; ?>"><br>
        </div>
    <div style="width: 48%;">         
        <label for="delito">Tipo de Delito:</label><br>
        <select id="delito" name="delito">
            <option value="Homicidio" <?php if ($row['delito'] == 'Homicidio') echo 'selected'; ?>>Homicidio</option>
            <option value="Violacion" <?php if ($row['delito'] == 'Violacion') echo 'selected'; ?>>Violación</option>
            <option value="Hurto" <?php if ($row['delito'] == 'Hurto') echo 'selected'; ?>>Hurto</option>
        </select><br>
        </div>
</div>
<div style="display: flex; justify-content: space-between; width: 100%;">
    <div style="width: 48%;">
        <label for="descripcion">Descripción de la Audiencia:</label><br>
        <textarea id="descripcion" name="descripcion"><?php echo $row['descripcion']; ?></textarea><br>
        </div>
</div>       

<div style="display: flex; justify-content: space-between; width: 100%;">
    <div style="width: 48%;">     
        <label for="juzgado">Seleccionar Juzgado:</label><br>
        <select id="juzgado" name="juzgado">
            <option value="Juzgado 1" <?php if ($row['juzgado'] == 'Juzgado 1') echo 'selected'; ?>>Juzgado 1</option>
            <option value="Juzgado 2" <?php if ($row['juzgado'] == 'Juzgado 2') echo 'selected'; ?>>Juzgado 2</option>
            <option value="Juzgado 3" <?php if ($row['juzgado'] == 'Juzgado 3') echo 'selected'; ?>>Juzgado 3</option>
        </select><br>
        </div>
    <div style="width: 48%;">         
        <label for="abogado">Seleccionar Abogado:</label><br>
        <select id="abogado" name="abogado">
            <option value="Abogado 1" <?php if ($row['abogado'] == 'Abogado 1') echo 'selected'; ?>>Abogado 1</option>
            <option value="Abogado 2" <?php if ($row['abogado'] == 'Abogado 2') echo 'selected'; ?>>Abogado 2</option>
            <option value="Abogado 3" <?php if ($row['abogado'] == 'Abogado 3') echo 'selected'; ?>>Abogado 3</option>
        </select><br>
        </div>
    <div style="width: 48%;">       
        <label for="fiscal">Seleccionar Fiscal:</label><br>
        <select id="fiscal" name="fiscal">
            <option value="Fiscal 1" <?php if ($row['fiscal'] == 'Fiscal 1') echo 'selected'; ?>>Fiscal 1</option>
            <option value="Fiscal 2" <?php if ($row['fiscal'] == 'Fiscal 2') echo 'selected'; ?>>Fiscal 2</option>
            <option value="Fiscal 3" <?php if ($row['fiscal'] == 'Fiscal 3') echo 'selected'; ?>>Fiscal 3</option>
        </select><br>
        </div>
</div>       
<div style="display: flex; justify-content: space-between; width: 100%;">
    <div style="width: 48%;">     
        <label for="sala">Sala de Audiencias:</label><br>
        <select id="sala" name="sala">
            <option value="Sala 1" <?php if ($row['sala'] == 'Sala 1') echo 'selected'; ?>>Sala 1</option>
            <option value="Sala 2" <?php if ($row['sala'] == 'Sala 2') echo 'selected'; ?>>Sala 2</option>
            <option value="Sala 3" <?php if ($row['sala'] == 'Sala 3') echo 'selected'; ?>>Sala 3</option>
        </select><br>
        </div>
    <div style="width: 48%;">     
        <label for="juez_suplente">Juez Suplente:</label><br>
        <select id="juez_suplente" name="juez_suplente">
            <option value="Suplente 1" <?php if ($row['juez_suplente'] == 'Suplente 1') echo 'selected'; ?>>Suplente 1</option>
            <option value="Suplente 2" <?php if ($row['juez_suplente'] == 'Suplente 2') echo 'selected'; ?>>Suplente 2</option>
            <option value="Suplente 3" <?php if ($row['juez_suplente'] == 'Suplente 3') echo 'selected'; ?>>Suplente 3</option>
        </select><br>
        </div>
</div>       
<input type="submit" value="Guardar Cambios" style="width: 200px; height: 50px;">

    </form>
</div>
    <?php
} else {
    echo "No se encontró la audiencia.";
}

// Cerrar la conexión
$conn->close();
?>

</body>
</html>

