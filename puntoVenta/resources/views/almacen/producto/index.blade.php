@extends ('layouts.admin')

@section ('contenido')

<!-- CSS de Lightbox -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">LISTADO DE PRODUCTOS</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Categorías</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Hoverable rows start -->
<section class="section">
    <div class="row" id="table-hover-row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="col-xl-12">
                        <form action="{{ route('categoria') }}" method="get">

                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="input-group mb-6">
                                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                                        <input type="text" class="form-control" name="texto" placeholder="Buscar Productos" value="{{$texto}}" aria-label="Recipient's username" aria-describedby="button-addon2">
                                        <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Buscar</button>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="input-group mb-6">
                                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-plus-circle-fill"></i></span>
                                        <a href="{{ route('producto.crear') }}" class="btn btn-success">Nuevo</a>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                    </div>
                    <!-- table hover -->
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Id</th>
                                    <th>Categoría</th>
                                    <th>Código</th>
                                    <th>Nombre</th>
                                    <th>Stock</th>
                                    <th>Descripción</th>
                                    <th>Imagen</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($producto as $prod)
                                <tr>
                                    <td class="align-middle">
                                        <a href="{{ route('producto.edit', $prod->id_producto) }}" class="btn btn-warning btn-sm"><i class="fas fa-pen"></i></a>
                                        <a href="#" class="btn btn-outline-danger btn-sm" onclick="eliminarCategoria({{ $prod->id_producto }})"><i class="fas fa-trash-alt"></i></a>
                                        <form id="delete-form-{{ $prod->id_producto }}" action="{{ route('producto.destroy', $prod->id_producto) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                    <td class="align-middle">{{ $prod->id_producto}}</td>
                                    <td class="align-middle">
                                        @php
                                            $categoria = DB::table('categoria')->where('id_categoria', $prod->id_categoria)->first();
                                            echo $categoria->categoria;
                                        @endphp
                                    </td>
                                    <td class="align-middle">{{ $prod->codigo}}</td>
                                    <td class="align-middle">{{ $prod->nombre}}</td>
                                    <td class="align-middle">{{ $prod->stock}}</td>
                                    <td class="align-middle">{{ $prod->descripcion}}</td>
                                    <td class="text-center align-middle">
                                        <a href="https://via.placeholder.com/300" data-lightbox="example" data-title="Imagen de ejemplo">
                                            <img src="https://via.placeholder.com/300" alt="Imagen de ejemplo" width="50" height="50">
                                        </a>
                                    </td>
                                    
                                    
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                        {{ $producto->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Hoverable rows end -->

<script>
    function eliminarCategoria(id) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Esta acción no se puede deshacer',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>

{{-- Imagen emergente --}}
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




<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!-- JavaScript de Lightbox -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>


@endsection
