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
    <link rel="stylesheet" href="chat.css">
</head>
<body>

<div class="chat-container">
    <div class="users-list">
        <h3>Usuarios</h3>
        <div id="users">
        <div class="user" onclick="selectUser(1, 'Usuario 1')">Usuario 1</div>
        <div class="user" onclick="selectUser(2, 'Usuario 2')">Usuario 2</div>
        <div class="user" onclick="selectUser(3, 'Usuario 3')">Usuario 3</div>


        </div>
    </div>

    <div class="chat-window">
        <div id="chat-box" class="chat-box">
            Selecciona un usuario para comenzar el chat.
        </div>
        <div class="input-area">
            <input type="text" id="message" class="input-message" placeholder="Escribe un mensaje..." disabled>
            <button id="sendBtn" disabled onclick="sendMessage()">Enviar</button>
        </div>
    </div>
</div>

<script>

// Variables globales
let selectedUserId = null;
let selectedUserName = null; // Asegúrate de que el nombre esté inicializado correctamente
let intervalId = null;

// Función para seleccionar un usuario
function selectUser(id, name) {
    selectedUserId = id;
    selectedUserName = name;  // Actualiza el nombre del usuario seleccionado

    // Actualizar el área del chat para mostrar con quién estás chateando
    document.getElementById('chat-box').innerHTML = `<p>Estás chateando con <strong>${selectedUserName}</strong></p>`;

    // Habilitar el input y botón de enviar
    document.getElementById('message').disabled = false;
    document.getElementById('sendBtn').disabled = false;

    // Limpiar el chat anterior y cargar el nuevo
    loadChat(selectedUserId);

    // Iniciar la actualización automática de mensajes
    if (intervalId) {
        clearInterval(intervalId);
    }
    intervalId = setInterval(function() {
        loadChat(selectedUserId);
    }, 2000); // Consultar nuevos mensajes cada 2 segundos
}

// Función para cargar los mensajes del chat
function loadChat(userId) {
    fetch(`obtener_mensajes.php?usuario_id=${userId}`)
        .then(response => response.text())
        .then(data => {
            let chatBox = document.getElementById('chat-box');

            // Si el nombre del usuario seleccionado está definido, reemplazar "Ellos:" por el nombre real
            if (selectedUserName) {
                let formattedChat = data.replace(/Ellos:/g, `${selectedUserName}:`);
                chatBox.innerHTML = formattedChat;
            } else {
                chatBox.innerHTML = data; // Si no, deja los mensajes sin cambios
            }

            // Mantener el scroll abajo
            chatBox.scrollTop = chatBox.scrollHeight;
        })
        .catch(error => console.log('Error al cargar mensajes:', error));
}

// Función para enviar un mensaje
function sendMessage() {
    const message = document.getElementById('message').value;
    if (selectedUserId && message) {
        const chatBox = document.getElementById('chat-box');

        // Agregar el mensaje enviado al chat
        const sentMessage = document.createElement('div');
        sentMessage.classList.add('message', 'sent');
        sentMessage.textContent = `Tú: ${message}`;
        chatBox.appendChild(sentMessage);

        // Enviar mensaje al backend
        fetch('enviar_mensaje.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `remitente_id=<?php echo $_SESSION['user_id']; ?>&destinatario_id=${selectedUserId}&mensaje=${message}`
        })
        .then(response => response.text())
        .then(data => console.log(data))
        .catch(error => console.log('Error al enviar mensaje:', error));

        // Limpiar el input y mantener el scroll abajo
        document.getElementById('message').value = '';
        chatBox.scrollTop = chatBox.scrollHeight;
    } else {
        alert('Selecciona un usuario y escribe un mensaje.');
    }
}

// Cargar usuarios cuando la página carga
window.onload = function() {
    fetch('usuarios.php')
        .then(response => response.text())
        .then(data => {
            document.getElementById('users').innerHTML = data;
        })
        .catch(error => console.log('Error al cargar usuarios:', error));
};


</script>

</body>
</html>
