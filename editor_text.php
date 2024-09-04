<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editor de Texto Básico</title>
    <style>
        #editor {
            width: 80%;
            height: 300px;
            margin: 20px auto;
            padding: 10px;
            border: 1px solid #ccc;
            font-family: Arial, sans-serif;
            font-size: 16px;
            resize: vertical;
            overflow-y: auto;
        }
        #toolbar {
            width: 80%;
            margin: 20px auto;
            text-align: center;
        }
        #toolbar button {
            margin: 5px;
            padding: 10px;
            font-size: 16px;
        }
    </style>
</head>
<body>

    <div id="toolbar">
        <button onclick="formatText('bold')"><b>Negrita</b></button>
        <button onclick="formatText('italic')"><i>Cursiva</i></button>
        <button onclick="formatText('underline')"><u>Subrayado</u></button>
        <button onclick="formatText('insertUnorderedList')">• Lista</button>
        <button onclick="formatText('insertOrderedList')">1. Lista</button>
        <button onclick="formatText('justifyLeft')">Alinear Izquierda</button>
        <button onclick="formatText('justifyCenter')">Centrar</button>
        <button onclick="formatText('justifyRight')">Alinear Derecha</button>
    </div>

    <div id="editor" contenteditable="true">
        <!-- Aquí puedes empezar a escribir tu documento -->
    </div>

    <script>
        function formatText(command) {
            document.execCommand(command, false, null);
        }
    </script>

</body>
</html>


