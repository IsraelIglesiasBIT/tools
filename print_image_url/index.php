<html>
<head></head>
<body>
    <br><button data-image="https://dibujos.info/wp-content/uploads/2023/05/dibujos-de-cenicienta-para-imprimir-y-colorear.jpg">Print</button>
    <br><button data-image="https://dibujos.info/wp-content/uploads/2023/05/dibujos-de-bebes-tiernos-para-colorear.jpg">Print</button>
    <br><button data-image="https://dibujos.info/wp-content/uploads/2023/05/dibujo-de-mama-con-beb%C3%A9-para-colorear.jpg">Print</button>
</body>
<script>
    // Query the element
    //const printBtn = document.querySelector('.print');

    const els = Array.from(document.querySelectorAll('[data-image]'));
    for(const printBtn of els) {
        printBtn.addEventListener('click', function() {

            //Create a fake image --------------------------------------------------
            const image = document.createElement('img');

            // Make it hidden
            //image.style.visibility = 'hidden';
            image.style.maxWidth = '100%';

            // Set the image's source
            image.setAttribute('src', this.dataset.image);

            // Create a fake iframe ------------------------------------------------
            const iframe = document.createElement('iframe');

            // Make it hidden
            iframe.style.visibility = 'hidden';
            iframe.style.height = 0;
            iframe.style.width = 0;

            // Set the iframe's source
            iframe.setAttribute('srcdoc', '<html><body></body></html>');

            document.body.appendChild(iframe);

            iframe.addEventListener('load', function () {
                // Append the image to the iframe's body
                const body = iframe.contentDocument.body;
                body.style.textAlign = 'center';
                body.appendChild(image);

                image.addEventListener('load', function() {
                    // Invoke the print when the image is ready
                    iframe.contentWindow.print();
                    image.remove();
                    iframe.remove();
                });
            });
        });
    }
    
</script>
</html>