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
            background-color: #ddd; /* Mantiene el azul oscuro */
            color: black;
            border-radius: 12px; /* Redondeo más suave */
            padding: 10px 10px; /* Espacio interno para mejorar la legibilidad */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Añade una sombra sutil para darle profundidad */
            font-size: 16px; /* Tamaño de fuente más grande para mayor legibilidad */
            /* Limita el ancho del mensaje para evitar que sea muy largo */
            margin: 8px 0; /* Espaciado entre los mensajes */
            word-wrap: break-word; /* Para que las palabras largas no se desborden */

            
        }
        .message.user {
    text-align: right;
    background-color: #0056b3; /* Mantiene el azul oscuro */
    color: #fff;
    border-radius: 12px; /* Redondeo más suave */
    padding: 10px 10px; /* Espacio interno para mejorar la legibilidad */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Añade una sombra sutil para darle profundidad */
    font-size: 16px; /* Tamaño de fuente más grande para mayor legibilidad */
    /* Limita el ancho del mensaje para evitar que sea muy largo */
    margin: 8px 0; /* Espaciado entre los mensajes */
    word-wrap: break-word; /* Para que las palabras largas no se desborden */
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
            padding: 10px 20px;
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
                { keywords: ["nombre", "quien"], response: "Soy Legal IA, tu asistente legal. ¿En que te puedo ayudar?" },
                { keywords: ["ayuda", "como hago"], response: "claro, que puedo ayudarte" },
                { keywords: ["puedes", "hacer"], response: "Puedo responder algunas preguntas básicas. ¡Inténtalo!" },
                { keywords: ["ayuda", "caso" ], response: "Claro, dirigete al menu principal, Opcion caso y agregar caso." }



                
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
