<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot Simple</title>
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
            margin-bottom: 10px;
        }
        .message.user {
            text-align: right;
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
    </style>
</head>
<body>
    <div class="chat-container">
        <div class="chat-header">Chatbot</div>
        <div class="chat-messages" id="chat-messages"></div>
        <div class="chat-input">
            <input type="text" id="user-input" placeholder="Escribe tu mensaje...">
            <button onclick="sendMessage()">Enviar</button>
        </div>
    </div>

    <script>
        const messages = document.getElementById('chat-messages');
        const userInput = document.getElementById('user-input');

        function sendMessage() {
            const userText = userInput.value;
            if (userText.trim() !== "") {
                addMessage("user", userText);
                respondToUser(userText);
                userInput.value = "";
            }
        }

        function addMessage(sender, text) {
            const message = document.createElement('div');
            message.classList.add('message', sender);
            message.textContent = text;
            messages.appendChild(message);
            messages.scrollTop = messages.scrollHeight;
        }

        function respondToUser(input) {
            let response = "No entiendo lo que dices.";

            const keywordResponses = [
                { keywords: ["hola", "buenas"], response: "¡Hola! ¿Cómo puedo ayudarte?" },
                { keywords: ["cómo", "estás"], response: "Estoy bien, gracias por preguntar. ¿Y tú?" },
                { keywords: ["adiós", "chao"], response: "¡Adiós! Que tengas un buen día." },
                { keywords: ["nombre"], response: "Soy un simple chatbot." },
                { keywords: ["ayuda", "como hago"], response: "claro, que puedo ayudarte" },
                { keywords: ["puedes", "hacer"], response: "Puedo responder algunas preguntas básicas. ¡Inténtalo!" },
                { keywords: ["ayuda", "caso" ], response: "Claro, dirigere al menu principal, Opcion caso y agreagr caso." }



                
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

            setTimeout(() => addMessage("bot", response), 500);
        }
    </script>
</body>
</html>
