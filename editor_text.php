<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editor de Documentos DOCX</title>
    <!-- Incluir TinyMCE con tu API -->
    <script src="https://cdn.tiny.cloud/1/3foww2ks0exfu5njoq1sre6v2mxs80meoygho4mfhsijta6k/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <!-- Incluir docx.js -->
    <script src="https://cdn.jsdelivr.net/npm/@dolanmiu/docx@6.1.1/build/index.js"></script>
    <style>
        #editor-container {
            width: 80%;
            margin: 20px auto;
        }
    </style>
</head>
<body>

    <div id="editor-container">
        <h2>Editor de Documentos DOCX</h2>
        <input type="file" id="docx-file" accept=".docx"><br><br>
        <textarea id="editor"></textarea><br><br>
        <button id="save-docx">Guardar como DOCX</button>
    </div>

    <script>
        // Inicializar TinyMCE con tu API
        tinymce.init({
            selector: '#editor',
            height: 500,
            plugins: 'autosave lists table',
            toolbar: 'undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | table',
            menubar: false
        });

        // Cargar archivo DOCX
        document.getElementById('').addEventListener('change', function (event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const arrayBuffer = e.target.result;
                    const docx = new docx.Docx(arrayBuffer);
                    const text = docx.getText();
                    tinymce.get('editor').setContent(text);
                };
                reader.readAsArrayBuffer(file);
            }
        });

        // Guardar contenido como DOCX
        document.getElementById('save-docx').addEventListener('click', function () {
            const content = tinymce.get('editor').getContent();
            const doc = new docx.Document();
            doc.addSection({
                children: [
                    new docx.Paragraph(content)
                ]
            });

            docx.Packer.toBlob(doc).then(blob => {
                const a = document.createElement('a');
                a.href = URL.createObjectURL(blob);
                a.download = 'documento.docx';
                a.click();
            });
        });
    </script>
</body>
</html>

