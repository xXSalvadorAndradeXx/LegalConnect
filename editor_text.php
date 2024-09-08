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
    <!-- Incluir Mammoth.js para la conversión de DOCX a HTML -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mammoth/1.4.2/mammoth.browser.min.js"></script>
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
        <button id="load-docx">Cargar archivo DOCX</button><br><br>
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

        let loadedFile;

        // Leer el archivo DOCX
        document.getElementById('docx-file').addEventListener('change', function (event) {
            loadedFile = event.target.files[0];
        });

        // Cargar el contenido del archivo DOCX en el editor cuando se haga clic en el botón
        document.getElementById('load-docx').addEventListener('click', function () {
            if (loadedFile) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const arrayBuffer = e.target.result;
                    
                    // Usar Mammoth.js para convertir DOCX a HTML
                    mammoth.convertToHtml({ arrayBuffer: arrayBuffer })
                        .then(function(result) {
                            const htmlContent = result.value; // El contenido convertido a HTML
                            tinymce.get('editor').setContent(htmlContent); // Cargar el HTML en TinyMCE
                        })
                        .catch(function(err) {
                            console.error('Error al convertir el archivo DOCX:', err);
                        });
                };
                reader.readAsArrayBuffer(loadedFile);
            } else {
                alert("Por favor selecciona un archivo DOCX primero.");
            }
        });

        // Guardar el contenido como DOCX
        document.getElementById('save-docx').addEventListener('click', function () {
            const content = tinymce.get('editor').getContent({ format: 'html' }); // Obtener el contenido como HTML
            
            // Crear el documento DOCX basado en el contenido
            const doc = new docx.Document({
                sections: [{
                    properties: {},
                    children: [
                        new docx.Paragraph({
                            children: [
                                new docx.TextRun({
                                    text: content.replace(/<\/?[^>]+(>|$)/g, ""), // Remover etiquetas HTML
                                    break: 1 // Agregar un salto de línea
                                })
                            ]
                        })
                    ]
                }]
            });

            // Generar el archivo DOCX y descargarlo
            docx.Packer.toBlob(doc).then(blob => {
                const a = document.createElement('a');
                a.href = URL.createObjectURL(blob);
                a.download = 'documento.docx';
                document.body.appendChild(a);
                a.style.display = 'none';
                
                // Hacer clic en el enlace para descargar el archivo
                a.click();
                URL.revokeObjectURL(a.href); // Liberar el objeto URL después de la descarga
            }).catch(err => {
                console.error('Error al generar el documento DOCX:', err);
            });
        });
    </script>
</body>
</html>

