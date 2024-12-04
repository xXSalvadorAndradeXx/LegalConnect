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
    if ($_GET['logout'] == 'confirm') {
        session_destroy(); // Destruir todas las variables de sesión
        header("Location: Iniciar_Sesion.php");
        exit();
    } else {
        header("Location: {$_SERVER['PHP_SELF']}?logout=confirm");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LegalConnect - Ayuda</title>
    <link rel="stylesheet" href="/estilos/menu.css">
    <style>

        .faq {
            background-color: #fff;
            border-radius: 10px;
            padding: 1.5rem;
            margin-top: 1rem;
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
        .answer-container {
            display: none;
            align-items: flex-start;
            gap: 2rem;
            margin-top: 1rem;
        }
        .answer {
            font-size: 1rem;
            color: #555;
            flex: 1;
        }
        iframe {
            width: 400px;
            height: 300px;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

<nav>
    <ul>
        <li><a href="/Pagina_principal.php">Inicio</a></li>
        <li><a href="/Casos/Agregar_casos.php">Casos</a></li>
        <li><a href="/Audiencias/Principal_audiencias.php">Audiencias</a></li>
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




        <div class="question" onclick="toggleAnswer(this)" data-video="https://www.youtube.com/embed/76-3t3g_Mig">
            ¿Cómo creo un caso?
        </div>
        






        <div class="question" onclick="toggleAnswer(this)" data-video="https://www.youtube.com/embed/example-video-id1">
            ¿Cómo creo un caso penal?
        </div>
        <div class="answer-container">
            <div class="answer">Para crear un caso penal, accede a "Gestión de Casos", selecciona "Nuevo Caso Penal" y completa los datos requeridos.</div>
            <iframe src="" title="Video tutorial" frameborder="0" allowfullscreen></iframe>
        </div>

    </section>
</main>

<iframe 
    id="faq-video" 
    width="560" 
    height="315" 
    src="" 
    title="Video tutorial" 
    frameborder="0" 
    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
    allowfullscreen>
</iframe>


<script>
    function toggleAnswer(questionElement) {
        const answerContainer = questionElement.nextElementSibling;
        const videoFrame = answerContainer.querySelector('iframe');
        const videoUrl = questionElement.getAttribute('data-video');

        const isCurrentlyVisible = answerContainer.style.display === "flex";
        document.querySelectorAll('.answer-container').forEach(el => el.style.display = "none");
        document.querySelectorAll('iframe').forEach(el => el.src = "");

        if (!isCurrentlyVisible) {
            answerContainer.style.display = "flex";
            videoFrame.src = videoUrl;
        }
    }
</script>

</body>
</html>
