<html>
<head></head>
<body>
    <img id="image" src="https://dibujos.info/wp-content/uploads/2023/05/dibujos-de-cenicienta-para-imprimir-y-colorear.jpg" />
    <br><button id="print">Print</button>
</body>
<script>
    // Query the element
    const printBtn = document.getElementById('print');

    printBtn.addEventListener('click', function() {
        // Create a fake iframe
        const iframe = document.createElement('iframe');

        // Make it hidden
        iframe.style.height = 0;
        iframe.style.visibility = 'hidden';
        iframe.style.width = 0;

        // Set the iframe's source
        iframe.setAttribute('srcdoc', '<html><body></body></html>');

        document.body.appendChild(iframe);

        iframe.addEventListener('load', function () {
            // Clone the image
            const image = document.getElementById('image').cloneNode();
            image.style.maxWidth = '100%';

            // Append the image to the iframe's body
            const body = iframe.contentDocument.body;
            body.style.textAlign = 'center';
            body.appendChild(image);

            image.addEventListener('load', function() {
                // Invoke the print when the image is ready
                iframe.contentWindow.print();
            });
        });
    });

    
</script>
</html>