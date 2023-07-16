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
            <div class="card p-2" >
                <div class="card-header">
                    <div class="col-xl-12">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="input-group mb-3 d-flex align-items-center">
                                    <div class="mx-3">
                                        <div class="input-group-append">
                                            <a href="{{ route('producto.crear') }}" class="btn btn-success">Nuevo</a>
                                        </div>
                                    </div>
                                    
                                    <div class="mx-3">
                                        <label for="categoria">Filtrar por Categoría:</label>
                                        <select id="categoria" class="form-control">
                                            <option value="">Todas</option>
                                            <option value="Deportes">Deportes</option>
                                            <!-- Agrega más opciones de categoría según tus necesidades -->
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card-content">
                    <div class="card-body">
                    </div>
                    <!-- table hover -->
                    <div class="table-responsive">
                        <table id="myTable" class="table table-hover table-bordered mb-0">
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
                                        <a href="/imagenes/productos/{{ $prod->imagen }}" data-lightbox="example" data-title="Imagen de ejemplo">
                                            <img src="/imagenes/productos/{{ $prod->imagen }}" alt="Imagen de ejemplo" width="50" height="50">
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

<script>
    window.onload = function() {
        Swal.fire(
            'Éxito',
            'El registro se eliminó correctamente',
            'success'
        );
    }
  </script>



<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!-- JavaScript de Lightbox -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>


@endsection
