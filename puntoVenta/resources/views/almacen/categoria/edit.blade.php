@extends('layouts.admin')
@section('contenido')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">EDITAR LA CATEGORÍA DE: {{ $categoria->categoria }}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/categoria">Inicio</a></li>
                    <li class="breadcrumb-item active">Categorias</li>
                    <li class="breadcrumb-item inactive">Editar</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<div class="col-md-8">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Editar Categoria {{ $categoria->categoria }}</h3>
        </div>

        <form action="{{ route('categoria.update') }}" method="POST" class="form">
            @csrf

            <input type="hidden" name="id_categoria" value="{{ $categoria->id_categoria }}">

            <div class="card-body">

                <div class="form-group">
                    <label for="categoria">Nombre</label>
                    <input type="text" class="form-control" name="categoria" id="categoria" placeholder="Ingresa el nombre de la categoria" value="{{ $categoria->categoria }}">
                    @error('categoria')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <input type="text" class="form-control" name="descripcion" id="descripcion" placeholder="Ingresa la descripcion" value="{{ $categoria->descripcion }}">
                    @error('descripcion')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Inicio: Botones --}}
                <div class="card-footer">
                    <button type="submit" class="btn btn-success me-1 mb-1">Guardar</button>
                    <button type="button" onclick="history.back()" class="btn btn-danger me-1 mb-1">Cancelar</button>
                </div>
                {{-- Fin: Botones --}}
            </div>
        </form>

    </div>
</div>

@endsection