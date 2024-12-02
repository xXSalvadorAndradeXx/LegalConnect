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

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LegalConnect - Ayuda</title>
    <link rel="stylesheet" href="/estilos/menu.css">
    <style>
        /* Estilo general */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
            color: #333;
        }
        header {
            background-color: #4CAF50;
            color: white;
            padding: 1.5rem 2rem;
            text-align: center;
            border-bottom: 2px solid #fff;
        }
        main {
            padding: 2rem;
        }
        h1 {
            font-size: 2.5rem;
            margin: 0;
        }
        h2 {
            color: #333;
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
        }
        
        /* Sección de preguntas frecuentes */
        .faq {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
        }

        .question {
            font-weight: bold;
            font-size: 1.2rem;
            cursor: pointer;
            padding: 1rem;
            background-color: #f1f1f1;
            border-radius: 8px;
            margin-bottom: 1rem;
            transition: background-color 0.3s ease;
        }

        .question:hover {
            background-color: #e0e0e0;
        }

        .answer {
            display: none;
            margin-left: 2rem;
            font-size: 1rem;
            color: #555;
            padding-top: 0.5rem;
            padding-bottom: 1rem;
        }

        /* Indicaciones Textuales */
        .instructions {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            margin-top: 2rem;
        }

       
    </style>
</head>
<body>

<nav>
        <ul>
            <li><a href="/Pagina_principal.php" >Inicio</a></li>




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
            <li><a href="/Formularios/asistencia.php" class="active">Asistencia</a></li>
            <li>
                <a href="/formularios/Perfil.php">Perfil</a>
                <ul>
                    <li><a href="?logout">Cerrar sesión</a></li>
                </ul>
            </li>
        </ul>
    </nav>

<main>
    <section class="faq">
        <h2>Preguntas Frecuentes (FAQ)</h2>
        <?php if ($tipo_usuario === 'fiscal'): ?>

<div class="question" onclick="toggleAnswer(this)">¿Cómo creo un caso penal?</div>
<div class="answer">Para crear un caso penal, accede a "Gestión de Casos", selecciona "Nuevo Caso Penal" y completa los datos requeridos.</div>

<div class="question" onclick="toggleAnswer(this)">¿Cómo obtengo pruebas digitales para un caso?</div>
<div class="answer">En la sección "Pruebas Digitales", puedes buscar o cargar pruebas relacionadas con un caso específico.</div>

<div class="question" onclick="toggleAnswer(this)">¿Cómo solicito colaboración de otro fiscal?</div>
<div class="answer">Puedes solicitar colaboración desde la sección "Gestión de Colaboraciones", seleccionando el fiscal al que deseas invitar.</div>

            

         <h1>Hola Fiscal</h1>
           
            
            <?php endif; ?>

        <?php if ($tipo_usuario === 'abogado'): ?>
            <h1>Hola Abogado</h1>

<div class="question" onclick="toggleAnswer(this)">¿Cómo presento un escrito legal?</div>
<div class="answer">Ve a la sección "Gestión de Casos", selecciona el caso correspondiente y utiliza la opción "Presentar Escrito".</div>

<div class="question" onclick="toggleAnswer(this)">¿Cómo solicito una reunión con un juez?</div>
<div class="answer">Puedes solicitar una reunión desde la sección "Agendar Reunión". Asegúrate de incluir los detalles del caso y el propósito de la reunión.</div>

<div class="question" onclick="toggleAnswer(this)">¿Puedo compartir documentos con otros abogados?</div>
<div class="answer">Sí, desde la sección "Documentos Compartidos" puedes subir documentos y seleccionar los usuarios con quienes deseas compartirlos.</div>


            <?php endif; ?>



        <?php if ($tipo_usuario === 'juez' ): ?>
            <h1>Hola Juez</h1>

<div class="question" onclick="toggleAnswer(this)">¿Cómo puedo asignar casos a mi tribunal?</div>
<div class="answer">Para asignar casos, ve a la sección "Gestión de Casos", selecciona el caso correspondiente y asigna tu tribunal.</div>

<div class="question" onclick="toggleAnswer(this)">¿Puedo acceder a expedientes históricos?</div>
<div class="answer">Sí, puedes acceder a expedientes históricos desde la sección "Archivo Judicial". Utiliza el buscador para encontrar los casos necesarios.</div>

<div class="question" onclick="toggleAnswer(this)">¿Cómo programo audiencias en LegalConnect?</div>
<div class="answer">En la sección "Calendario Judicial", puedes seleccionar una fecha y hora disponible para programar audiencias relacionadas a un caso.</div>


            <?php endif; ?>

    </section>

   
</main>

<script>
    function toggleAnswer(questionElement) {
        const answerElement = questionElement.nextElementSibling;
        answerElement.style.display = (answerElement.style.display === "none" || !answerElement.style.display) ? "block" : "none";
    }
</script>

</body>
</html>
