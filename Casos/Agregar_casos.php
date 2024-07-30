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

// Función para generar la referencia automática
function generarReferencia() {
    $fechaHora = date('Y-m-d-H-i-s');
    $existencia = rand(1000, 9999); // Número de existencia aleatorio
    return $fechaHora . "-" . $existencia;
}

// Procesamiento del formulario cuando se envía
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $referencia = generarReferencia();
    $victima = $_POST['victima'];
    $imputado = $_POST['imputado'];
    $tipoDelito = $_POST['tipo_delito'];

    // Insertar caso en la base de datos
    $sql = "INSERT INTO casos (referencia, victima, imputado, tipo_delito) VALUES ('$referencia', '$victima', '$imputado', '$tipoDelito')";

    if ($conn->query($sql) === TRUE) {
        header("Location: /Casos/casoguardado.php"); 

        // Procesar y guardar archivos de evidencia
        if(isset($_FILES['evidencia'])){
            $errors= array();
            foreach($_FILES['evidencia']['tmp_name'] as $key => $tmp_name ){
                $file_name = $_FILES['evidencia']['name'][$key];
                $file_size =$_FILES['evidencia']['size'][$key];
                $file_tmp =$_FILES['evidencia']['tmp_name'][$key];
                $file_type=$_FILES['evidencia']['type'][$key];
                if($file_size > 10000000000000){
                    $errors[]='El tamaño del archivo debe ser menor a 2 MB';
                }      
                $desired_dir="uploads"; // Directorio donde se guardarán los archivos
                if(empty($errors)==true){
                    if(is_dir($desired_dir)==false){
                        mkdir("$desired_dir", 0700); // Crea el directorio si no existe
                    }
                    if(is_dir("$desired_dir/".$file_name)==false){
                        move_uploaded_file($file_tmp,"$desired_dir/".$file_name); // Mueve el archivo a la ubicación deseada
                    }else{
                        $new_dir="$desired_dir/".$file_name.time();
                        rename($file_tmp,$new_dir);                
                    }
                    // Insertar información de la evidencia en la base de datos
                    $sql_evidencia = "INSERT INTO evidencias (caso_referencia, nombre_archivo, tipo_archivo, ubicacion_archivo) VALUES ('$referencia', '$file_name', '$file_type', '$desired_dir/$file_name')";
                    if ($conn->query($sql_evidencia) === TRUE) {
                        echo "Evidencia subida correctamente.";
                    } else {
                        echo "Error al subir la evidencia: " . $conn->error;
                    }
                }else{
                    print_r($errors);
                }
            }
        }
        
        
        // Guardar documento PDF o DOC
        if(isset($_FILES['documento'])){
            $file_name = $_FILES['documento']['name'];
            $file_size = $_FILES['documento']['size'];
            $file_tmp = $_FILES['documento']['tmp_name'];
            $file_type = $_FILES['documento']['type'];
            $desired_dir = "documentos"; // Directorio donde se guardarán los documentos

            // 
            if ($file_type == 'application/pdf' || $file_type == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' ) {
                if (move_uploaded_file($file_tmp, "$desired_dir/" . $file_name)) {
                    // Insertar información del documento en la base de datos
                    $sql_documento = "INSERT INTO documentos (caso_referencia, nombre_archivo, tipo_archivo, ubicacion_archivo) VALUES ('$referencia', '$file_name', '$file_type', '$desired_dir/$file_name')";
                    if ($conn->query($sql_documento) === TRUE) {
                        header("Location: /Casos/casoguardado.php"); 
                        exit();
                    } else {
                        echo "Error al subir el documento: " . $conn->error;
                    }
                } else {
                    echo "Error al subir el documento.";
                }
            } else {
                $error_message = "Tipo de archivo no admitido.";
                header("Location: /Casos/casoguardado.php?error=" . urlencode($error_message));
                exit();
               
            }
        }
        
    } else {
        echo "Error al agregar el caso: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Agregar Caso</title>
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


    body {
            font-family: Bahnschrift;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

    .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #fff;
            font-family: Bahnschrift;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow-y: auto; /* Agregamos scroll vertical */
            max-height: 500px; /* Establecemos una altura máxima */
            margin-top: 20px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            margin-top: 30px;
        }

        label {
            font-weight: bold;
        }

        input[type="text"], input[type="file"], button {
            width: 100%;
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button {
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        .add-evidence {
            display: flex;
            align-items: center;
        }

        .add-evidence button {
            margin-left: 10px;
            flex-shrink: 0;
        }


        .submit-btn {
            background-color: #007bff; /* Green */
            border: none;
            color: white;
            font-family: Bahnschrift;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        .submit-btn:hover {
            background-color: #0056b3; /* Darker Green on Hover */
            font-family: Bahnschrift;
        }
        .cancel-btn {
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

        .cancel-btn:hover {
            background-color: #0056b3; /* Darker Green on Hover */
            color: #fff;
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
            font-family: Bahnschrift;
            font-size: 16px;
            transition: background-color 0.3s, color 0.3s;
            margin-left: 1000px;
            margin-top: 80px;
        }

        #botonArribaIzquierda:hover {
            background-color: #0056b3;
            color: #fff;
            font-family: Bahnschrift;
        }


        
        .select-container label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        .select-container select {
            width: 100%;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
            font-size: 16px;
            box-sizing: border-box;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20viewBox%3D%220%200%204%205%22%3E%3Cpath%20fill%3D%22%23007bff%22%20d%3D%22M2%200L0%202h4L2%200zM2%205L0%203h4L2%205z%22/%3E%3C/svg%3E') no-repeat right 10px center;
            background-size: 12px;
        }
        .select-container select:focus {
            outline: none;
            border-color: #007bff;
        }
    </style>

</head>
<body>

<header class="main-header">

    <label for="btn-nav" class="btn-nav">&#9776;</label>
    <input type="checkbox" id="btn-nav">
    <a href="/Formularios/Perfil.php">
<div class="circle-container">

    <img class="circle-image" src="/recursos/profile.png" alt="Tu imagen">

   </div>
  </a>
    <nav>
      <ul class="navigation">
<center>

        <li><a href="/Pagina_principal.php">Inicio</a></li>
        <li><a href="/Audiencias/Buscar_Audiencias.php">Audiencias</a></li>
        <li><a href="/Casos/Agregar_Casos.php">Casos</a></li>
        <li><a href="?logout">Cerrar Sesion</a></li>
        <h1>LegalConnect v.1</h1>
      </ul>
    </nav>
    </center>
  </header>



  <a id="botonArribaIzquierda" href="/Casos/Buscar_Casos.php">Historia de Casos</a>
<div class="container">
    <h2>Agregar Caso</h2>
    <form method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="victima">Víctima:</label>
        <input type="text" id="victima" name="victima" required>

        <label for="imputado">Imputado:</label>
        <input type="text" id="imputado" name="imputado">

        <div class="select-container">
            <label for="tipo_delito">Tipo de Delito:</label>
            <select id="tipo_delito" name="tipo_delito">
                <option value="robo">Robo</option>
                <option value="asalto">Asalto</option>
                <option value="fraude">Fraude</option>
                <option value="vandalismo">Vandalismo</option>
                <option value="homicidio">Homicidio</option>
            </select>
        </div>

        <label>Evidencia:</label>
        <input type="file" name="evidencia[]" multiple accept=".png ,.jpg,.jpeg">

        <label for="documento">Documento:</label>
        <input type="file" name="documento" accept=".pdf">

        <div class="button-container">
            <input type="submit" value="Agregar Caso" class="submit-btn">
            <input type="reset" value="Cancelar" class="cancel-btn">
        </div>
    </form>
</div>


    <script>
        function agregarCampoEvidencia() {
            var container = document.getElementById("evidencia-container");
            var input = document.createElement("input");
            input.type = "file";
            input.name = "evidencia[]";
            container.appendChild(document.createElement("br"));
            container.appendChild(input);
        }



        document.querySelector('a[href="?logout"]').addEventListener('click', function(event) {
    if (!confirm('¿Estás seguro de que deseas cerrar sesión?')) {
        event.preventDefault(); // Cancelar el evento de clic si el usuario no confirma
    }
});

    </script>
</body>
</html>



