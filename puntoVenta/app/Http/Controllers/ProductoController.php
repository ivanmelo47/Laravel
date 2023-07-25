<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\CategoriaFormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;

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
        $categorias = DB::table('categoria')->where('estatus', '=', '1')->get();
        return view('almacen.producto.crear', ["categorias" => $categorias]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación de los campos
        $validator = Validator::make($request->all(), [
            'codigo' => 'required|unique:producto,codigo',
            'nombre' => 'required|unique:producto,nombre',
            'stock' => 'required|integer|min:1',
            'descripcion' => 'required',
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Comprueba si la validación falla
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Si la validación pasa, crea el registro
        $validatedData = $validator->validated();
        $validatedData['estado'] = '1';
        $validatedData['id_categoria'] = $request->id_categoria;

        // Guardar la imagen en el servidor
        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $nombreImagen = Str::random(30) . '_' . time() . '.' . $imagen->getClientOriginalExtension();

            // Verificar si la carpeta existe y crearla si es necesario
            $directorio = public_path('imagenes/productos');
            if (!File::exists($directorio)) {
                File::makeDirectory($directorio, 0755, true);
            }

            $imagen->move($directorio, $nombreImagen);
            $validatedData['imagen'] = $nombreImagen;
        }

        Producto::create($validatedData);

        return redirect('producto')->with([
            'success' => 'Producto registrado con Exito',
        ]);
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
    public function edit($id)
    {
        //
        $producto = Producto::findOrFail($id);
        $nombreImagen = $producto->imagen; // Obtener el nombre de la imagen desde la base de datos
        $rutaImagen = '/imagenes/productos/' . $nombreImagen; // Reemplaza 'ruta/a/la/carpeta/' con la ruta real de la carpeta en tu servidor
        $urlImagen = asset($rutaImagen); // Construir la URL completa de la imagen

        $categorias = DB::table('categoria')->where('estatus', '=', '1')->get();
        return view('almacen.producto.editar', ["producto" => Producto::findOrFail($id), "categorias" => $categorias, "urlImagen" => $urlImagen]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        /* Caputurando el ID para saber que registro se a de actualizar */
        $pid = $request->id_producto;

        // Validaciónde los campos
        $validator = Validator::make($request->all(), [
            'codigo' => [
                'required',
                Rule::unique('producto', 'codigo')->ignore($pid, 'id_producto'),
            ],
            'nombre' => [
                'required',
                Rule::unique('producto', 'nombre')->ignore($pid, 'id_producto'),
            ],

            'stock' => 'required|integer|min:1',
            'descripcion' => 'required|min:10|max:510',

            'imagen' => [
                'nullable', // Permite que el campo esté vacío
                'image',
                'mimes:jpeg,png,jpg,gif',
                'max:2048',
            ]
        ]);

        // Comprueba si la validación falla
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Si la validación pasa, actualiza el registro
        $producto = Producto::findOrFail($pid);
        $producto->fill([
            'id_categoria' => $request->input('id_categoria'),
            'codigo' => $request->input('codigo'),
            'nombre' => $request->input('nombre'),
            'stock' => $request->input('stock'),
            'descripcion' => $request->input('descripcion'),
        ]);

        // Elimina la imagen anterior del servidor si existe y sube la nueva imagen
        if ($request->hasFile('imagen') && $producto->imagen) {

            //Elimar la imagen anterior del servidor
            $rutaImagenAnterior = public_path('imagenes/productos/' . $producto->imagen);
            if (file_exists($rutaImagenAnterior)) {
                unlink($rutaImagenAnterior);
            }

            //Nombre de la nueva imagen
            $imagen = $request->file('imagen');
            $nombreImagen = Str::random(30) . '_' . time() . '.' . $imagen->getClientOriginalExtension();

            // Sube y actualiza el nombre de la nueva imagen
            $directorio = public_path('imagenes/productos/');
            $imagenRecortada = Image::make($imagen)->fit(600, 600);
            $imagenRecortada->save($directorio . $nombreImagen);
            $producto->imagen = $nombreImagen;
        }

        $producto->update();

        return redirect('producto')->with([
            'success' => 'Producto actualizado con Exito',
        ]);
        ;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->estado = '0';
        $producto->save();

        if ($producto) {
            // Si la eliminación fue exitosa, mostrar mensaje de éxito
            return redirect()->route('producto')->with([
                'success' => 'Registro eliminado exitosamente',
            ]);
        } else {
            // Si la eliminación falló, mostrar mensaje de error
            return redirect()->route('producto')->with('error', 'Error al eliminar el registro');
        }
    }
}