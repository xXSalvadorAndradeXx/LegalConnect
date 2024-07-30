<?php
// Conectar a la base de datos
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

// Obtener la referencia del caso desde la URL
$referencia = $conn->real_escape_string($_GET['referencia']);

// Iniciar una transacción
$conn->begin_transaction();

try {
    // Copiar los datos del caso a la tabla de archivados
    $sql_archivar = "INSERT INTO casos_archivados SELECT * FROM casos WHERE referencia='$referencia'";
    if ($conn->query($sql_archivar) !== TRUE) {
        throw new Exception("Error al archivar el caso: " . $conn->error);
    }

    // Actualizar el estado del caso en la tabla original
    $sql_ocultar = "UPDATE casos SET estado='archivado' WHERE referencia='$referencia'";
    if ($conn->query($sql_ocultar) !== TRUE) {
        throw new Exception("Error al actualizar el estado del caso: " . $conn->error);
    }

    // Confirmar la transacción
    $conn->commit();
    echo "Caso archivado correctamente.";
} catch (Exception $e) {
    // Revertir la transacción en caso de error
    $conn->rollback();
    echo $e->getMessage();
}

// Cerrar la conexión
$conn->close();
?>
