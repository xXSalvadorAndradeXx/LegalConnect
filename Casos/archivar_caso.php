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
        
        // Obtener y guardar documentos
        $sql_docs = "SELECT * FROM documentos WHERE caso_referencia = ?";
        $stmt_docs = $conn->prepare($sql_docs);
        $stmt_docs->bind_param("s", $referencia);
        $stmt_docs->execute();
        $result_docs = $stmt_docs->get_result();

        while ($doc = $result_docs->fetch_assoc()) {
            $doc_path = $doc['ruta_archivo'];
            $doc_name = basename($doc_path);
            
            // Descargar el archivo
            if (file_exists($doc_path)) {
                $dest_path = 'C:/Users/salva/OneDrive/Escritorio' . $doc_name; // Cambia esto según tu estructura de carpetas
                copy($doc_path, $dest_path);
            }
        }

        // Obtener y guardar evidencias
        $sql_evidencias = "SELECT * FROM evidencias WHERE caso_referencia = ?";
        $stmt_evidencias = $conn->prepare($sql_evidencias);
        $stmt_evidencias->bind_param("s", $referencia);
        $stmt_evidencias->execute();
        $result_evidencias = $stmt_evidencias->get_result();

        while ($evi = $result_evidencias->fetch_assoc()) {
            $evi_path = $evi['ruta_archivo'];
            $evi_name = basename($evi_path);
            
            // Descargar el archivo
            if (file_exists($evi_path)) {
                $dest_path = 'C:/Users/salva/OneDrive/Escritorio' . $evi_name; // Cambia esto según tu estructura de carpetas
                copy($evi_path, $dest_path);
            }
        }

        // Eliminar evidencias y documentos
        $sql_evidencia_documentos = "DELETE FROM evidencias WHERE caso_referencia = ?";
        $stmt_evidencia_documentos = $conn->prepare($sql_evidencia_documentos);
        $stmt_evidencia_documentos->bind_param("s", $referencia);
        $stmt_evidencia_documentos->execute();

        $sql_eliminar_documentos = "DELETE FROM documentos WHERE caso_referencia = ?";
        $stmt_eliminar_documentos = $conn->prepare($sql_eliminar_documentos);
        $stmt_eliminar_documentos->bind_param("s", $referencia);
        $stmt_eliminar_documentos->execute();

        $sql_eliminar = "DELETE FROM casos WHERE referencia = ?";
        $stmt_eliminar = $conn->prepare($sql_eliminar);
        $stmt_eliminar->bind_param("s", $referencia);
        $stmt_eliminar->execute();

        // Insertar el caso en la tabla 'casos_archivados'
        $sql_archivar = "INSERT INTO casos_archivados (referencia, victima, imputado, tipo_delito, archivos_documento, fecha_creacion) 
                         VALUES (?, ?, ?, ?, ?, ?)";
        $stmt_archivar = $conn->prepare($sql_archivar);
        $stmt_archivar->bind_param("ssssss", $row['referencia'], $row['victima'], $row['imputado'], $row['tipo_delito'], $row['archivos_documento'], $row['fecha_creacion']);
        $stmt_archivar->execute();

        // Redirigir de vuelta a la página principal
        header("Location: Buscar_Casos.php");
        exit();
    } else {
        echo "Caso no encontrado.";
    }
}
?>


