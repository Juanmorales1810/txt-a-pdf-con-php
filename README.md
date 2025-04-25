# Conversor de Texto a PDF con PHP

Esta aplicación web permite convertir archivos de texto (.txt) a formato PDF manteniendo el formato original, incluyendo espacios, tabulaciones y saltos de línea.

## Características

-   Conversión simple de archivos TXT a PDF
-   Preservación de formato (espacios, tabulaciones, saltos de línea)
-   Opciones de personalización:
    -   Tamaño de fuente ajustable
    -   Altura de línea configurable - Orientación de página (vertical/horizontal)
    -   Tamaño de papel (A3, A4, A5, Carta, Legal)
    -   Preservación opcional de indentación
    -   Nombre personalizado para el archivo PDF
-   Soporte para codificaciones de caracteres (UTF-8, ISO)
-   Interfaz web intuitiva y responsive
-   Descarga directa del archivo PDF generado

## Requisitos

-   PHP 5.6 o superior
-   Biblioteca FPDF (incluida)

## Instalación

1. Clona o descarga este repositorio
2. Colócalo en el directorio raíz de tu servidor web (por ejemplo, en la carpeta `htdocs` de XAMPP)
3. Accede a través de tu navegador: `http://localhost/txt-a-pdf-con-php/`

## Uso

1. Abre la aplicación en tu navegador
2. Haz clic en "Seleccionar archivo" y elige un archivo de texto (.txt)
3. Configura las opciones según tus preferencias:
    - Selecciona el tamaño de fuente (de 9pt a 14pt)
    - Ajusta la altura de línea (compacta, normal o amplia)
    - Elige la orientación de la página (vertical u horizontal)
    - Selecciona el tamaño del papel (A4, A3, A5, Carta, Legal)
    - Activa o desactiva la preservación de indentación
    - Personaliza el nombre del archivo PDF resultante
4. Presiona el botón "Convertir a PDF"
5. El archivo PDF se descargará automáticamente con las configuraciones elegidas

## Créditos

-   [FPDF](http://www.fpdf.org/) - Biblioteca para la generación de archivos PDF

## Licencia

Este proyecto está bajo la Licencia MIT - ver el archivo LICENSE para más detalles.
