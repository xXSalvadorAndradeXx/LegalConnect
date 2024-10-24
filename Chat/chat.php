<?php
session_start(); // Iniciar sesión

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html"); // Redirigir al login si no está autenticado
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat en Tiempo Real</title>
    <style>
        /* Misma estructura CSS que en ejemplos anteriores */
    </style>
</head>
<body>

    <h1>Bienvenido, <?php echo $_SESSION['user_nombre'] . ' ' . $_SESSION['user_apellido']; ?>!</h1>
    
    <div class="chat-container">
        <div class="users-list">
            <h3>Usuarios disponibles</h3>
            <div id="users">
                Cargando usuarios...
            </div>
        </div>

        <div class="chat-window">
            <h3>Chat</h3>
            <div id="chat-box" class="chat-box">
                Selecciona un usuario para comenzar el chat.
            </div>
            <input type="text" id="message" class="input-message" placeholder="Escribe un mensaje..." disabled>
            <button id="sendBtn" disabled onclick="sendMessage()">Enviar</button>
        </div>
    </div>

    <script>
    let selectedUserId = null;
    let intervalId = null;

    // Cargar usuarios cuando la página carga
    window.onload = function() {
        fetch('usuarios.php')
            .then(response => response.text())
            .then(data => {
                document.getElementById('users').innerHTML = data;
            })
            .catch(error => console.log('Error al cargar usuarios:', error));
    };

    function selectUser(id) {
        selectedUserId = id;
        document.getElementById('chat-box').innerHTML = ''; // Limpiar chat
        document.getElementById('message').disabled = false; // Habilitar input de mensaje
        document.getElementById('sendBtn').disabled = false; // Habilitar botón de envío
        
        // Cargar mensajes anteriores y activar actualización automática
        loadChat(selectedUserId);
        if (intervalId) {
            clearInterval(intervalId);  // Detener actualizaciones anteriores si hay un usuario seleccionado
        }
        intervalId = setInterval(function() {
            loadChat(selectedUserId);
        }, 2000); // Consultar nuevos mensajes cada 2 segundos
    }

    function loadChat(userId) {
        fetch(`obtener_mensajes.php?usuario_id=${userId}`)
            .then(response => response.text())
            .then(data => {
                document.getElementById('chat-box').innerHTML = data;  // Mostrar los mensajes en el chat
                document.getElementById('chat-box').scrollTop = document.getElementById('chat-box').scrollHeight; // Mantener el scroll abajo
            })
            .catch(error => console.log('Error al cargar mensajes:', error));
    }

    function sendMessage() {
        const message = document.getElementById('message').value;
        if (selectedUserId && message) {
            // Mostrar el mensaje en el área de chat como un mensaje enviado
            const chatBox = document.getElementById('chat-box');
            const sentMessage = document.createElement('div');
            sentMessage.classList.add('message', 'sent');
            sentMessage.textContent = "Tú: " + message;
            chatBox.appendChild(sentMessage);

            // Enviar mensaje al backend para guardarlo en la base de datos
            fetch('enviar_mensaje.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `remitente_id=<?php echo $_SESSION['user_id']; ?>&destinatario_id=${selectedUserId}&mensaje=${message}`
            })
            .then(response => response.text())
            .then(data => console.log(data))
            .catch(error => console.log('Error al enviar mensaje:', error));

            // Limpiar el input del mensaje
            document.getElementById('message').value = ''; 
            chatBox.scrollTop = chatBox.scrollHeight; // Mantener el scroll siempre abajo
        } else {
            alert('Selecciona un usuario y escribe un mensaje.');
        }
    }
</script>

</body>
</html>


