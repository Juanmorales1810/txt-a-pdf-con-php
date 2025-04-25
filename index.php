<?php
// Verificar si se ha subido un archivo
if(isset($_POST['submit'])) {
    // Verificar si hay errores en la carga
    if($_FILES['txtfile']['error'] === UPLOAD_ERR_OK) {
        // Ruta temporal donde se guarda el archivo subido
        $tmpFile = $_FILES['txtfile']['tmp_name'];
          // Leer el contenido del archivo de texto
        $txtContent = file_get_contents($tmpFile);        // Obtener las opciones seleccionadas por el usuario
        $fontSize = isset($_POST['fontsize']) ? (int)$_POST['fontsize'] : 11;
        $lineHeight = isset($_POST['lineheight']) ? (int)$_POST['lineheight'] : 5;
        $preserveIndentation = isset($_POST['preserve_indentation']) ? true : false;
        $orientation = isset($_POST['orientation']) ? $_POST['orientation'] : 'P'; // P=Portrait (vertical), L=Landscape (horizontal)
        $pageSize = isset($_POST['pagesize']) ? $_POST['pagesize'] : 'A4'; // Tamaño de papel
        
        // Nombre del archivo PDF
        $filename = isset($_POST['filename']) && !empty($_POST['filename']) ? $_POST['filename'] : 'documento_convertido';
        // Asegurarse de que tenga extensión .pdf
        if(!preg_match('/\.pdf$/i', $filename)) {
            $filename .= '.pdf';
        }
        
        // Verificar si la biblioteca FPDF está instalada
        if(!file_exists('fpdf.php')) {
            die('Error: La biblioteca FPDF no está correctamente instalada. Por favor, descárgala e instálala en el directorio raíz del proyecto.');
        }
        
        // Incluir la biblioteca FPDF
        require('fpdf.php');        // Crear un nuevo objeto PDF con la orientación y tamaño seleccionados
        $pdf = new FPDF($orientation, 'mm', $pageSize);
        
        // Añadir una página
        $pdf->AddPage();
        
        // Establecer fuente: Courier (monoespaciada), normal, tamaño según selección
        $pdf->SetFont('Courier', '', $fontSize);        // Configuraciones adicionales para mejor preservación del formato
        $pdf->SetAutoPageBreak(true, 10);
        
        // Dividir el contenido en líneas
        $lines = explode("\n", $txtContent);
        
        // Añadir cada línea al PDF respetando el formato
        foreach($lines as $line) {
            // Convertir tabulaciones en 4 espacios
            $line = str_replace("\t", "    ", $line);
            
            // Si la línea está vacía, agregar un salto de línea
            if(trim($line) === '') {
                $pdf->Ln($lineHeight);
            } else {
                // Preservar espacios iniciales contando cuántos hay
                if ($preserveIndentation) {
                    $leadingSpaces = strlen($line) - strlen(ltrim($line));
                    if($leadingSpaces > 0) {
                        $spacer = str_repeat(" ", $leadingSpaces);
                        $line = ltrim($line);
                        $pdf->Cell(0, $lineHeight, $spacer . $line, 0, 1);
                    } else {
                        $pdf->Cell(0, $lineHeight, $line, 0, 1);
                    }
                } else {
                    // Si no se preserva la indentación, simplemente recortar los espacios iniciales
                    $pdf->Cell(0, $lineHeight, ltrim($line), 0, 1);
                }
            }
        }
          // Generar el PDF y enviarlo al navegador
        $pdf->Output('D', $filename);
        exit;
    } else {
        echo "Error al subir el archivo. Código de error: " . $_FILES['txtfile']['error'];
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversor de Texto a PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        h1 {
            color: #333;
            text-align: center;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }        input[type="file"], input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #45a049;
        }        .note {
            margin-top: 20px;
            padding: 10px;
            background-color: #f8f9fa;
            border-left: 4px solid #4CAF50;
        }
        .options {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 10px;
        }
        .option-item {
            margin-bottom: 10px;
        }
        select {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: white;
        }
        input[type="checkbox"] {
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Conversor de Texto a PDF</h1>
        <p>Esta herramienta te permite convertir archivos de texto (.txt) a formato PDF manteniendo el formato original.</p>
          <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="txtfile">Selecciona un archivo de texto:</label>
                <input type="file" name="txtfile" id="txtfile" accept=".txt" required>
            </div>
            
            <div class="form-group">
                <label>Opciones de formato:</label>
                <div class="options">
                    <div class="option-item">
                        <label for="fontsize">Tamaño de fuente:</label>
                        <select name="fontsize" id="fontsize">
                            <option value="9">9 pt</option>
                            <option value="10">10 pt</option>
                            <option value="11" selected>11 pt</option>
                            <option value="12">12 pt</option>
                            <option value="14">14 pt</option>
                        </select>
                    </div>
                    
                    <div class="option-item">
                        <label for="lineheight">Altura de línea:</label>
                        <select name="lineheight" id="lineheight">
                            <option value="4">Compacta</option>
                            <option value="5" selected>Normal</option>
                            <option value="6">Amplia</option>
                        </select>
                    </div>
                      <div class="option-item">
                        <label><input type="checkbox" name="preserve_indentation" value="1" checked> Preservar indentación</label>
                    </div>                    <div class="option-item">
                        <label for="orientation">Orientación:</label>
                        <select name="orientation" id="orientation">
                            <option value="P" selected>Vertical</option>
                            <option value="L">Horizontal</option>
                        </select>
                    </div>
                    
                    <div class="option-item">
                        <label for="pagesize">Tamaño de papel:</label>
                        <select name="pagesize" id="pagesize">
                            <option value="A4" selected>A4</option>
                            <option value="A3">A3</option>
                            <option value="A5">A5</option>
                            <option value="Letter">Carta (Letter)</option>
                            <option value="Legal">Legal</option>
                        </select>
                    </div>
                    
                    <div class="option-item">
                        <label for="filename">Nombre del archivo PDF:</label>
                        <input type="text" name="filename" id="filename" placeholder="documento_convertido" value="documento_convertido">
                    </div>
                </div>
            </div>
            
            <button type="submit" name="submit">Convertir a PDF</button>
        </form>
          <div class="note">
            <p><strong>Nota:</strong> El archivo PDF resultante mantendrá el formato del texto original, incluyendo espacios, saltos de línea y tabulaciones. Puedes elegir entre diferentes tamaños de papel como A4, A3, A5, Carta o Legal para adaptarse mejor a tu contenido.</p>
        </div>
    </div>
</body>
</html>
