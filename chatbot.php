<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot Simple</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f4;
        }
        .chat-container {
            width: 400px;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        .chat-header {
            background: #007bff;
            color: white;
            padding: 15px;
            text-align: center;
            font-size: 18px;
        }
        .chat-messages {
            padding: 20px;
            height: 300px;
            overflow-y: scroll;
            border-bottom: 1px solid #ddd;
        }
        .message {
            text-align: left;
            background-color: #ddd;
            color: black;
            border-radius: 12px;
            padding: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            font-size: 16px;
            margin: 8px 0;
            word-wrap: break-word;
        }
        .message.user {
            text-align: right;
            background-color: #0056b3;
            color: #fff;
            border-radius: 12px;
            padding: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            font-size: 16px;
            margin: 8px 0;
            word-wrap: break-word;
        }
        .chat-input {
            display: flex;
            padding: 10px;
            background: #f4f4f4;
        }
        .chat-input input {
            flex: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-right: 10px;
        }
        .chat-input button {
            padding: 10px 20px;
            background: #007bff;
            border: none;
            color: white;
            border-radius: 4px;
            cursor: pointer;
        }
        .chat-input button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="chat-container">
        <div class="chat-header">Chatbot</div>
        <div class="chat-messages" id="chat-messages"></div>
        <div class="chat-input">
            <input type="text" id="user-input" placeholder="Escribe una consulta...">
            <button onclick="sendMessage()"><i class="fas fa-paper-plane"></i></button>
        </div>
    </div>

    <script>
        const messages = document.getElementById('chat-messages');
        const userInput = document.getElementById('user-input');

        // Cargar mensajes al cargar la página
        window.onload = loadMessages;

        function sendMessage() {
            const userText = userInput.value;
            if (userText.trim() !== "") {
                const timestamp = new Date().getTime();
                addMessage("user", userText, timestamp);
                saveMessage("user", userText, timestamp);
                respondToUser(userText, timestamp);
                userInput.value = "";
            }
        }
        function addMessage(sender, text, timestamp) {
    const message = document.createElement('div');
    message.classList.add('message', sender);

    // Formato de tiempo
    const date = new Date(timestamp);
    const timeString = date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

    // Contenido del mensaje
    message.innerHTML = `<strong>${timeString}</strong> - ${text}`;
    
    messages.appendChild(message);
    messages.scrollTop = messages.scrollHeight;
}


        function saveMessage(sender, text, timestamp) {
            const savedMessages = JSON.parse(localStorage.getItem('chatMessages')) || [];
            savedMessages.push({ sender, text, timestamp });
            localStorage.setItem('chatMessages', JSON.stringify(savedMessages));
        }

        function loadMessages() {
            const savedMessages = JSON.parse(localStorage.getItem('chatMessages')) || [];
            const currentTime = new Date().getTime();

            const validMessages = savedMessages.filter(message => {
                return currentTime - message.timestamp <= 24 * 60 * 60 * 1000; // 24 horas en milisegundos
            });

            // Eliminar mensajes viejos
            localStorage.setItem('chatMessages', JSON.stringify(validMessages));

            validMessages.forEach(message => {
                addMessage(message.sender, message.text, message.timestamp);
            });
        }

        function respondToUser(input, timestamp) {
            let response = "No entiendo lo que dices.";

            const keywordResponses = [
                { keywords: ["hola", "buenas"], response: "¡Hola! ¿Cómo puedo ayudarte?" },
                { keywords: ["cómo", "estás"], response: "Estoy bien, gracias por preguntar. ¿Y tú?" },
                { keywords: ["adiós", "chao"], response: "¡Adiós! Que tengas un buen día." },
                { keywords: ["nombre", "quien"], response: "Soy Legal IA, tu asistente legal. ¿En qué te puedo ayudar?" },
                { keywords: ["ayuda", "como hago"], response: "Claro, ¿en qué puedo ayudarte?" },
                { keywords: ["puedes", "hacer"], response: "Puedo responder algunas preguntas básicas. ¡Inténtalo!" },
                { keywords: ["ayuda", "caso"], response: "Claro, dirígete al menú principal, opción caso y agrega un caso." }
            ];

            const normalizedInput = input.toLowerCase();

            for (let i = 0; i < keywordResponses.length; i++) {
                const keywordGroup = keywordResponses[i];
                for (let j = 0; j < keywordGroup.keywords.length; j++) {
                    if (normalizedInput.includes(keywordGroup.keywords[j])) {
                        response = keywordGroup.response;
                        break;
                    }
                }
                if (response !== "No entiendo lo que dices.") break;
            }

            setTimeout(() => {
                addMessage("bot", response, timestamp);
                saveMessage("bot", response, timestamp);
            }, 500);
        }
    </script>
</body>
</html>
