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

// Resto del código aquí (contenido de la página principal)
//___________________________________________HTML Normal_____________________________________________________________________________________
?>

<?php
// Conexión a la base de datos MySQL
$servername = "localhost";
$username = "root";
$password = "";
$database = "legalcc";

$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión a la base de datos");
}

$sql = "SELECT referencia FROM casos";
$result = $conn->query($sql);

// Procesar el formulario cuando se envíe
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recopilar datos del formulario
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
    
    // Insertar datos en la base de datos
    $sql = "INSERT INTO audiencias (titulo, caso, modalidad, fecha, hora, imputado, victima, delito, descripcion, juzgado, abogado, fiscal, sala, juez_suplente)
    VALUES ('$titulo', '$caso', '$modalidad', '$fecha', '$hora', '$imputado', '$victima', '$delito', '$descripcion', '$juzgado', '$abogado', '$fiscal', '$sala', '$juez_suplente')";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: Buscar_Audiencias.php");
        exit;
    } else {
        echo "Error al registrar la audiencia: " . $conn->error;
    }
    
    // Cerrar la conexión
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registro de Audiencias</title>

    <style>

body {
            font-family: 'Bahnschrift', sans-serif;
            background-color: #e8f0fa;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            height: 100vh;
        }
        nav {
            background-color: #2c3e50;
            padding: 15px 0;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            gap: 40px;
        }
        ul li {
            position: relative;
        }

        .active {
          background-color:#374D63;
            transform: scale(1.05);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        ul li a {
            text-decoration: none;
            color: white;
            font-size: 18px;
            font-weight: bold;
            padding: 10px 30px;
            display: block;
            transition: background-color 0.3s ease, transform 0.2s ease;
            border-radius: 8px;
        }
        ul li a:hover {
            background-color:#374D65;
            transform: scale(1.05);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border: 1px solid #ddd;
        }
        /* Estilo del submenú "Cerrar sesión" */
        ul li ul {
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            background-color: #2c3e50;
            border-radius: 8px;
            display: none;
            min-width: 180px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        ul li ul li a {
            padding: 10px 15px;
            font-size: 16px;
            color: white;
        }
        ul li:hover ul {
            display: block;
        }
        ul li ul li a:hover {
            background-color:#374D63;
        }
        /* Contenido */
        .content {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 40px 20px;
        }
        h1 {
            color: #2c3e50;
            font-size: 48px;
            margin-bottom: 20px;
            letter-spacing: 2px;
        }
        p {
            color: #555;
            font-size: 20px;
            max-width: 600px;
            line-height: 1.6;
        }
        /* Responsive */
        @media (max-width: 768px) {
            ul {
                flex-direction: column;
                align-items: center;
            }
            ul li a {
                padding: 10px 20px;
                font-size: 16px;
            }
        }


    h1{
      color: W;
      font-size: 10px;
      font-family: Bahnschrift;
    }
    h2{
      color: black;
      font-size: 20px;
      font-family: Bahnschrift;
    }

    .container {
    margin-top: 20px;
    background-color: white;
   
    margin: auto 100px;
    border-radius: 5px;
    
    padding: 10px;
    font-family: Bahnschrift, Arial, sans-serif; /* Agregamos Bahnschrift como primera opción */
}

    h2 {
        text-align: center;
    }
    label {
        font-weight: bold;
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


</style>

</head>
<body>

<nav>
        <ul>
            <li><a href="/Pagina_principal.php" class="active">Inicio</a></li>




            <li>
                <a href="/Casos/Agregar_casos.php">Casos</a>
                <ul>
                    <li><a href="casos/victima/tabla_de_victima.php">Victimas</a></li>
                    <li><a href="casos/imputados/tabladeimputados.php">Imputados</a></li>
                    <li><a href="/archivados/casos_archivados.php">Archivados</a></li>
                </ul>
            
            
            </li>
            <li><a href="/Audiencias/Principal_audiencias.php">Audiencias</a></li>
                  <?php if ($tipo_usuario === 'fiscal' || $tipo_usuario === 'abogado'): ?>  

            <li><a href="/Audiencias/ver_solicitudes.php">Mis Solicitudes</a></li>

            <?php endif; ?>

            <?php if ($tipo_usuario === 'juez'): ?>  

            <li><a href="/Audiencias/ver_solicitudes.php">Solicitudes</a></li>

            <?php endif; ?>
            <li><a href="/Formularios/asistencia.php">Asistencia</a></li>
            <li>
                <a href="/formularios/Perfil.php">Perfil</a>
                <ul>
                    <li><a href="?logout">Cerrar sesión</a></li>
                </ul>
            </li>
        </ul>
    </nav>




<div class="container">

<h2>Registro de Audiencias</h2>

<div style="display: flex; justify-content: space-between; width: 100%;">
    <div style="width: 48%;">
        <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
            <label>Tipo de Audiencia:</label><br>
            <input type="text" name="titulo" required><br><br>
        </div>
      
<div style="width: 48%;">
    <label>Seleccionar Caso:</label><br>
    <select name="caso">
        <?php
        // Verificar si hay resultados de la consulta
        if ($result->num_rows > 0) {
            // Imprimir cada opción del menú desplegable
            while($row = $result->fetch_assoc()) {
                echo "<option value='" . $row["referencia"] . "'>" . $row["referencia"] . "</option>";
            }
        } else {
            echo "<option value=''>No hay casos disponibles</option>";
        }
        ?>
    </select><br><br>
</div>
<?php
// Cerrar la conexión a la base de datos
$conn->close();
?> 
</div>
<div style="display: flex; justify-content: space-between; width: 100%;">
    <div style="width: 48%;">
            <label>Modalidad de Audiencias:</label><br>
            <select name="modalidad">
                <option value="Presencial">Presencial</option>
                <option value="Virtual">Virtual</option>
            </select><br><br>
        </div>
    <div style="width: 48%;">     
            <label>Seleccionar Fecha:</label><br>
            <input type="date" name="fecha" required><br><br>
        </div>
    <div style="width: 48%;"> 
            <label>Seleccionar Hora:</label><br>
            <input type="time" name="hora" required><br><br>
        </div>
</div>       

<div style="display: flex; justify-content: space-between; width: 100%;">
    <div style="width: 48%;">
        <label>Nombre del Imputado:</label><br>
        <input type="text" name="imputado" required><br><br>
    </div>
    <div style="width: 48%;">       
        <label>Nombre de la Víctima:</label><br>
        <input type="text" name="victima" required><br><br>
    </div>
    <div style="width: 48%;">       
        <label>Seleccionar Tipo de Delito:</label><br>
        <select name="delito">
            <option value="Homicidio">Homicidio</option>
            <option value="Violación">Violación</option>
            <option value="Hurto">Hurto</option>
        </select><br><br>
    </div>
</div>       
<div style="display: flex; justify-content: space-between; width: 100%;">
    <div style="width: 48%;">   
            <label>Descripción de la Audiencia:</label><br>
            <textarea name="descripcion" rows="4" cols="50"></textarea><br><br>
            </div>
</div>  
<div style="display: flex; justify-content: space-between; width: 100%;">
    <div style="width: 48%;">           
            <label>Seleccionar Juzgado:</label><br>
            <select name="juzgado">
                <option value="Juzgado 1">Juzgado 1</option>
                <option value="Juzgado 2">Juzgado 2</option>
                <option value="Juzgado 3">Juzgado 3</option>
            </select><br><br>
        </div>
    <div style="width: 48%;">           
            <label>Seleccionar Abogado:</label><br>
            <select name="abogado">
                <option value="Abogado 1">Abogado 1</option>
                <option value="Abogado 2">Abogado 2</option>
                <option value="Abogado 3">Abogado 3</option>
            </select><br><br>
        </div>
    <div style="width: 48%;">           
            <label>Seleccionar Fiscal:</label><br>
            <select name="fiscal">
                <option value="Fiscal 1">Fiscal 1</option>
                <option value="Fiscal 2">Fiscal 2</option>
                <option value="Fiscal 3">Fiscal 3</option>
            </select><br><br>
        </div>
</div>     

<div style="display: flex; justify-content: space-between; width: 100%;">
    <div style="width: 48%;"> 
            <label>Sala de Audiencias:</label><br>
            <select name="sala">
                <option value="Sala 1">Sala 1</option>
                <option value="Sala 2">Sala 2</option>
                <option value="Sala 3">Sala 3</option>
            </select><br><br>
        </div>
<div style="width: 48%;">               
            <label>Seleccionar Juez:</label><br>
            <select name="juez_suplente">
                <option value="Suplente 1">Juez 1</option>
                <option value="Suplente 2">Juez 2</option>
                <option value="Suplente 3">Juez 3</option>
            </select><br><br>
        </div>
</div>           
            <input type="submit" value="Registrar Audiencia">
        </form>


        <script>
    // Función para cargar los datos del caso seleccionado
    function cargarDatosCaso() {
        // Obtener el valor seleccionado del menú desplegable
        var casoSeleccionado = document.getElementsByName("caso")[0].value;

        // Realizar una solicitud AJAX para obtener los datos del caso seleccionado
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Convertir la respuesta JSON en un objeto JavaScript
                var datosCaso = JSON.parse(this.responseText);

                // Llenar los campos de texto con los datos del caso
                document.getElementsByName("imputado")[0].value = datosCaso.imputado;
                document.getElementsByName("victima")[0].value = datosCaso.victima;
                document.getElementsByName("delito")[0].value = datosCaso.tipo_delito;
            }
        };
        xhr.open("GET", "obtener_datos_caso.php?caso=" + casoSeleccionado, true);
        xhr.send();
    }

    // Adjuntar la función cargarDatosCaso al evento de cambio del menú desplegable
    document.getElementsByName("caso")[0].addEventListener("change", cargarDatosCaso);
</script>
</body>
</html>


