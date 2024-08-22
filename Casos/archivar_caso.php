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

// Verificar si se ha recibido la referencia del caso
if (isset($_GET['referencia'])) {
    $referencia = $_GET['referencia'];

    // Obtener los datos del caso desde la tabla 'casos'
    $sql = "SELECT * FROM casos WHERE referencia = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $referencia);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Insertar el caso en la tabla 'casos_archivados'
        $sql_archivar = "INSERT INTO casos_archivados (referencia, victima, imputado, tipo_delito, archivos_documento, fecha_creacion) 
                         VALUES (?, ?, ?, ?, ?, ?)
                         ON DUPLICATE KEY UPDATE 
                         victima = VALUES(victima),
                         imputado = VALUES(imputado),
                         tipo_delito = VALUES(tipo_delito),
                         archivos_documento = VALUES(archivos_documento),
                         fecha_creacion = VALUES(fecha_creacion)";
        $stmt_archivar = $conn->prepare($sql_archivar);
        
        $stmt_archivar->bind_param("ssssss", $row['referencia'], $row['victima'], $row['imputado'], $row['tipo_delito'], $row['archivos_documento'], $row['fecha_creacion']);

        $stmt_archivar->execute();
  

        $sql_evidencia_documentos = "DELETE FROM evidencias WHERE caso_referencia = ?";
        $stmt_evidencia_documentos = $conn->prepare($sql_evidencia_documentos);
        $stmt_evidencia_documentos->bind_param("s", $referencia);
        $stmt_evidencia_documentos->execute();

        $sql_eliminar_documentos = "DELETE FROM documentos WHERE caso_referencia = ?";
        $stmt_eliminar_documentos = $conn->prepare($sql_eliminar_documentos);
        $stmt_eliminar_documentos->bind_param("s", $referencia);
        $stmt_eliminar_documentos->execute();

        // Eliminar el caso de la tabla 'casos'
        $sql_eliminar = "DELETE FROM casos WHERE referencia = ?";
        $stmt_eliminar = $conn->prepare($sql_eliminar);
        $stmt_eliminar->bind_param("s", $referencia);
        $stmt_eliminar->execute();

        // Redirigir de vuelta a la página principal
        header("Location: Buscar_Casos.php");
        exit();
    } else {
        echo "Caso no encontrado.";
    }
}
?>



