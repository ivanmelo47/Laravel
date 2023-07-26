@extends ('layouts.admin')

@section ('contenido')





<!-- Imagen emergente INICIO -->
<script>
    $(document).ready(function() {
        // Inicializar Lightbox con opciones personalizadas
        lightbox.option({
            resizeDuration: 90,
            wrapAround: true,
            maxWidth: 800,  // Define el ancho máximo de la imagen emergente
            maxHeight: 600  // Define la altura máxima de la imagen emergente
        });
    });
</script>
<!-- Imagen emergente FIN -->



<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>



@endsection
