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

        // Guardar contenido como DOCX
        document.getElementById('save-docx').addEventListener('click', function () {
            const content = tinymce.get('editor').getContent({format: 'text'}); // Obtener el contenido como texto sin HTML

            const doc = new docx.Document({
                sections: [{
                    properties: {},
                    children: [
                        new docx.Paragraph({
                            children: [
                                new docx.TextRun(content) // Agregar el contenido como texto simple
                            ]
                        })
                    ]
                }]
            });

            docx.Packer.toBlob(doc).then(blob => {
                const a = document.createElement('a');
                a.href = URL.createObjectURL(blob);
                a.download = 'documento.docx';
                a.click();
                URL.revokeObjectURL(a.href); // Liberar el objeto URL después de la descarga
            });
        });
    
    </script>
</body>
</html>



