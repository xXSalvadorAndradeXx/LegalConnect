<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Solicitud</title>
    <link rel="stylesheet" href="styles.css"> <!-- Asegúrate de incluir tu archivo CSS -->
</head>
<body>
    <?php
    // Suponiendo que tienes una conexión a la base de datos establecida
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

    // Obtener el id de la solicitud a editar
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Consulta para obtener los datos de la solicitud
        $sql = "SELECT * FROM solicitudes WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        } else {
            echo "No se encontró la solicitud.";
            exit;
        }
    } else {
        echo "ID no especificado.";
        exit;
    }
    ?>

    <form action="guardar_cambios.php" method="post" id="editarFormulario">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

        <label for="usuario_id">ID del Usuario:</label>
        <input type="text" name="usuario_id" id="usuario_id" value="<?php echo $row['usuario_id']; ?>" required>

        <label for="juez_id">ID del Juez:</label>
        <input type="text" name="juez_id" id="juez_id" value="<?php echo $row['juez_id']; ?>" required>

        <label for="razon">Razón:</label>
        <textarea name="razon" id="razon" required><?php echo $row['razon']; ?></textarea>

        <label for="fecha_sugerida">Fecha Sugerida:</label>
        <input type="date" name="fecha_sugerida" id="fecha_sugerida" value="<?php echo $row['fecha_sugerida']; ?>" required>

        <label for="estado">Estado:</label>
        <select name="estado" id="estado" required>
            <option value="Pendiente" <?php if ($row['estado'] === 'Pendiente') echo 'selected'; ?>>Pendiente</option>
            <option value="Aceptada" <?php if ($row['estado'] === 'Aceptada') echo 'selected'; ?>>Aceptada</option>
            <option value="Rechazada" <?php if ($row['estado'] === 'Rechazada') echo 'selected'; ?>>Rechazada</option>
        </select>

        
        <label for="caso_id">ID del Caso:</label>
        <input type="text" name="caso_id" id="caso_id" value="<?php echo $row['caso_id']; ?>" required>

        <button type="submit" class="btn">Guardar Cambios</button>
    </form>
</body>
</html>






