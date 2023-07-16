@extends('layouts.admin')

@section('contenido')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">LISTADO DE CATEGORIAS</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Categorias</li>
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
            <div class="card p-2">
                <div class="card-header">
                    <div class="col-xl-12">
                        <form action="{{ route('categoria') }}" method="get">

                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="input-group mb-3 d-flex align-items-center">

                                        <div class="mx-3">
                                            <div class="input-group-append">
                                                <a href="{{ route('categoria.crear') }}" class="btn btn-success">Nuevo</a>
                                            </div>
                                        </div>
                                        
                                        
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
                    <div class="table-responsive" id="table-listado">
                        <table id="myTable" class="table table-hover table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Id</th>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categoria as $cat)
                                <tr>
                                    <td>
                                        <a href="{{ route('categoria.edit', $cat->id_categoria) }}" class="btn btn-warning btn-sm"><i class="fas fa-pen"></i></a>
                                        <a href="#" class="btn btn-outline-danger btn-sm" onclick="eliminarCategoria({{ $cat->id_categoria }})"><i class="fas fa-trash-alt"></i></a>
                                        <form id="delete-form-{{ $cat->id_categoria }}" action="{{ route('categoria.destroy', $cat->id_categoria) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                    <td>{{ $cat->id_categoria }}</td>
                                    <td>{{ $cat->categoria }}</td>
                                    <td>{{ $cat->descripcion }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $categoria->links() }}
                    </div>

                    <div class="list-group" id="grid-listado" style="display: none;">
                        @foreach ($categoria as $cat)
                        <div class="list-group-item">
                            <div class="row">
                                <div class="col-md-3">
                                    <img src="https://via.placeholder.com/150" alt="Imagen">
                                </div>
                                <div class="col-md-9">
                                    <h5 class="mt-3">{{ $cat->categoria }}</h5>
                                    <p>{{ $cat->descripcion }}</p>
                                    <div class="text-end">
                                        <a href="{{ route('categoria.edit', $cat->id_categoria) }}" class="btn btn-warning btn-sm"><i class="fas fa-pen"></i></a>
                                        <a href="#" class="btn btn-outline-danger btn-sm" onclick="eliminarCategoria({{ $cat->id_categoria }})"><i class="fas fa-trash-alt"></i></a>
                                        <form id="delete-form-{{ $cat->id_categoria }}" action="{{ route('categoria.destroy', $cat->id_categoria) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Hoverable rows end -->

<button id="alternar-listado" class="btn btn-primary">Alternar Listado</button>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

{{-- Alternar entre lista y cuadricula --}}
<script>
$(document).ready(function() {
  $("#alternar-listado").click(function() {
    $("#table-listado").toggle();
    $("#grid-listado").toggle();
  });
});
</script>

<script>
    window.onload = function() {
        @if(Session::has('success_message'))
            Swal.fire(
                'Éxito',
                '{{ Session::get('success_message') }}',
                'success'
            );
        @endif
    }
</script>

@endsection
