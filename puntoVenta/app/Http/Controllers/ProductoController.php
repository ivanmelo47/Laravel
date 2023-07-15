<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\CategoriaFormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        if ($request) {
            $query = trim($request->get('texto'));
            $productos = DB::table('producto')->where('nombre', 'LIKE', '%' . $query . '%')
                ->where('estado', '=', '1')
                ->orderBy('id_producto', 'desc')
                ->paginate(100);
            return view('almacen.producto.index', ["producto" => $productos, "texto" => $query]);
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function crear()
    {
        //
        $categorias = DB::table('categoria');

        return view('almacen.producto.crear');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación de los datos ingresados en el formulario
        $request->validate([
            'categoria' => 'required',
            'stock' => 'required|integer|min:1',
            'descripcion' => 'required',
            'imagen' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Añade cualquier validación adicional para la imagen si es necesario
        ]);

        // Crear un nuevo objeto Producto con los datos del formulario
        $producto = new Producto();
        $producto->categoria = $request->input('categoria');
        $producto->stock = $request->input('stock');
        $producto->descripcion = $request->input('descripcion');

        // Procesar y guardar la imagen si se ha subido
        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
            $rutaImagen = public_path('/imagenes/productos');
            $imagen->move($rutaImagen, $nombreImagen);
            $producto->imagen = $nombreImagen;
        }

        // Guardar el objeto Producto en la base de datos
        $producto->save();

        // Redirigir o realizar cualquier otra acción que necesites después de guardar el producto

        return redirect()->route('producto.index'); // Ejemplo de redirección a la página de listado de productos
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
