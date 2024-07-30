<?php
// Conexión a la base de datos (ajusta estos valores según tu configuración)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "legalcc";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    header("Location: ErrorConectar.php");
    exit();
}

// Obtener los datos del formulario
$correo = $_POST['correo'];
$contrasena = $_POST['contrasena'];

// Buscar el usuario en la base de datos
$sql = "SELECT id, correo, contrasena FROM usuarios WHERE correo = '$correo'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Usuario encontrado, verificar la contraseña
    $row = $result->fetch_assoc();
    if (password_verify($contrasena, $row['contrasena'])) {
        // Contraseña correcta, inicio de sesión exitoso
        session_start(); // Iniciar sesión
        $_SESSION['user_id'] = $row['id']; // Almacenar el ID de usuario en la sesión
        header("Location: InicioGuardado.php"); // Redirigir al usuario a la página principal
        exit();
    } else {
        // Contraseña incorrecta, redirigir de nuevo al formulario de inicio de sesión con un mensaje de error
        header("Location: Iniciar_Sesion.php?error=1");
        exit();
    }
} else {
    // Usuario no encontrado, redirigir de nuevo al formulario de inicio de sesión con un mensaje de error
    header("Location: Iniciar_Sesion.php?error=1");
    exit();
}

// Cerrar conexión
$conn->close();
?>
