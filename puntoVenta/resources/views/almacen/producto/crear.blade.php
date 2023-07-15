<form action="{{ route('guardarImagen') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
      <label for="imagen">Imagen:</label>
      <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
    </div>
    <div class="form-group">
      <label for="categoria">Categoría:</label>
      <select class="form-control" id="categoria" name="categoria">
        @foreach($categorias as $categoria)
        <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
        @endforeach
      </select>
    </div>
    <button type="submit" class="btn btn-primary">Guardar</button>
</form>
  