@extends ('layouts.admin')

@section ('contenido')

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
      <div class="row mb-2">
          <div class="col-sm-6">
              <h1 class="m-0">REGISTRAR NUEVO PRODUCTO</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="/categoria">Inicio</a></li>
                  <li class="breadcrumb-item active">Productos</li>
                  <li class="breadcrumb-item inactive">Crear</li>
              </ol>
          </div><!-- /.col -->
      </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<div class="col-md-8">
  <div class="card card-primary">
      <div class="card-header">
          <h3 class="card-title">Nuevo Producto</h3>
      </div>

      <form action="{{ route('producto.store') }}" method="POST" class="form" enctype="multipart/form-data">
          @csrf
          <div class="card-body">

              <div class="form-group">
                <label for="id_categoria">Categoría:</label>
                <select class="form-control" id="id_categoria" name="id_categoria">
                  @foreach($categorias as $categoria)
                  <option value="{{ $categoria->id_categoria }}">{{ $categoria->categoria }}</option>
                  @endforeach
                </select>
              </div>

              <div class="form-group">
                <label for="codigo">Codigo</label>
                <input type="text" class="form-control" name="codigo" id="codigo" placeholder="Ingresa el codigo del producto" value="{{ old('codigo') }}">
                @error('codigo')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

              <div class="form-group">
                  <label for="nombre">Nombre</label>
                  <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Ingresa el nombre del producto" value="{{ old('nombre') }}">
                  @error('nombre')
                      <div class="text-danger">{{ $message }}</div>
                  @enderror
              </div>

              <div class="form-group">
                <label for="stock">Stock</label>
                <input type="number" class="form-control" name="stock" id="stock" min="1" placeholder="Ingresa el número de stock" value="{{ old('stock') }}">
                @error('stock')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
              </div>

              <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea class="form-control" name="descripcion" id="descripcion" placeholder="Ingresa la descripción" style="resize: none; height: 80px;">{{ old('descripcion') }}</textarea>
                @error('descripcion')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
              </div>
            

              <div class="form-group">
                <label for="imagen">Imagen:</label>
                <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
                <a href="#" data-lightbox="image-preview" data-title="Vista previa de la imagen">
                  <img id="preview" src="#" alt="Vista previa de la imagen" style="display: none; max-width: 100%; max-height: 200px;">
                </a>
                @error('imagen')
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

<script>
    document.getElementById('imagen').addEventListener('change', function(e) {
      var file = e.target.files[0];
      var reader = new FileReader();
  
      reader.onload = function(e) {
        var previewImg = document.getElementById('preview');
        previewImg.setAttribute('src', e.target.result);
        previewImg.style.display = 'block';
        previewImg.parentElement.setAttribute('href', e.target.result);
      }
  
      reader.readAsDataURL(file);
    });
</script>

@endsection