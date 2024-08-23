<?php
// Verificar si se recibieron los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['documento']['name'])) {
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

    // Obtener la referencia del caso
    $referencia = $_POST['referencia'];

    // Directorio donde se guardará el documento
    $targetDir = "documentos/";

    // Nombre del archivo de documento
    $fileName = basename($_FILES['documento']['name']);
    $targetFilePath = $targetDir . $fileName;

    // Guardar el documento en el directorio
    if(move_uploaded_file($_FILES["documento"]["tmp_name"], $targetFilePath)){
        // Obtener el tipo de archivo
        $fileType = $_FILES['documento']['type'];

        // Consulta para insertar el documento en la tabla documentos
        $sql = "INSERT INTO documentos (caso_referencia, nombre_archivo, tipo_archivo, ubicacion_archivo, archivado) 
                VALUES ('$referencia', '$fileName', '$fileType', '$targetFilePath', 0)";

        if ($conn->query($sql) === TRUE) {
            header("Location: /Casos/casoguardado.php"); 
        } else {
            echo "Error al registrar el documento: " . $conn->error;
        }
    } else {
        echo "Error al cargar el archivo de documento.";
    }

    $conn->close();
} else {
    echo "No se recibieron datos del formulario o no se seleccionó un archivo.";
}
?>


