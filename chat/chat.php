<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .chat-container {
            width: 400px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
        }
        .chat-header {
            background-color: #007bff;
            color: #fff;
            padding: 15px;
            text-align: center;
        }
        .chat-messages {
            height: 300px;
            overflow-y: auto;
            padding: 15px;
            background-color: #e9ecef;
        }
        .chat-messages .message {
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 5px;
            background-color: #fff;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }
        .chat-footer {
            display: flex;
            border-top: 1px solid #ccc;
        }
        .chat-footer input[type="text"] {
            flex: 1;
            padding: 15px;
            border: none;
            outline: none;
        }
        .chat-footer button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 15px;
            cursor: pointer;
        }
        .chat-footer button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="chat-container">
        <div class="chat-header">
            <h1>Chat</h1>
        </div>
        <div class="chat-messages" id="chatMessages"></div>
        <div class="chat-footer">
            <input type="text" id="messageInput" placeholder="Escribe un mensaje..." autocomplete="off">
            <button onclick="sendMessage()">Enviar</button>
        </div>
    </div>

    <script src="https://cdn.socket.io/4.0.0/socket.io.min.js"></script>
    <script>
        const socket = io('http://localhost:4000');

        socket.on('connect', () => {
            console.log('Connected to server');
        });

        socket.on('connect_error', (error) => {
            console.error('Connection error:', error);
            alert('Unable to connect to the WebSocket server. Please try again later.');
        });

        socket.on('server:mensajes', (mensajes) => {
            const chatMessages = document.getElementById('chatMessages');
            chatMessages.innerHTML = '';
            mensajes.forEach(mensaje => {
                const div = document.createElement('div');
                div.classList.add('message');
                div.textContent = mensaje.mensaje; 
                chatMessages.appendChild(div);
            });
            chatMessages.scrollTop = chatMessages.scrollHeight;
        });

        socket.on('server:nuevoMensaje', (mensaje) => {
            const chatMessages = document.getElementById('chatMessages');
            const div = document.createElement('div');
            div.classList.add('message');
            div.textContent = mensaje.mensaje; 
            chatMessages.appendChild(div);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        });

        function sendMessage() {
            const messageInput = document.getElementById('messageInput');
            const message = messageInput.value;
            if (message.trim()) {
                socket.emit('client:nuevoMensaje', { mensaje: message }); 
                messageInput.value = '';
            }
        }
    </script>
</body>
</html>

