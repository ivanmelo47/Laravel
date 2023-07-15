<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\CategoriaFormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;



class CategoriaController extends Controller
{
    public function __construct()
    {

    }
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        //
        if ($request) {
            $query = trim($request->get('texto'));
            $categorias = DB::table('categoria')->where('categoria', 'LIKE', '%' . $query . '%')
                ->where('estatus', '=', '1')
                ->orderBy('id_categoria', 'desc')
                ->paginate(100);
            return view('almacen.categoria.index', ["categoria" => $categorias, "texto" => $query]);
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function crear()
    {
        //
        return view('almacen.categoria.crear');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación de los campos
        $validator = Validator::make($request->all(), [
            'categoria' => 'required|min:3|unique:categoria,categoria',
            'descripcion' => 'required',
        ]);

        // Comprueba si la validación falla
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Si la validación pasa, crea el registro
        $validatedData = $validator->validated();
        $validatedData['estatus'] = '1';
        Categoria::create($validatedData);

        return redirect('categoria');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        return view('almacen.categoria.show', ['categoria' => Categoria::findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        return view('almacen.categoria.edit', ['categoria' => Categoria::findOrFail($id)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $pid = $request->id_categoria;

        // Validación de los campos
        $validator = Validator::make($request->all(), [
            'categoria' => [
                'required',
                Rule::unique('categoria', 'categoria')->ignore($pid, 'id_categoria'),
            ],
            'descripcion' => 'required',
        ]);

        // Comprueba si la validación falla
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Si la validación pasa, actualiza el registro
        $categoria = Categoria::findOrFail($pid);
        $categoria->categoria = $request->input('categoria');
        $categoria->descripcion = $request->input('descripcion');
        $categoria->update();

        return redirect('categoria');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    $categoria = Categoria::findOrFail($id);
    $categoria->estatus = '0';
    $categoria->save();

    Alert::success('Éxito', 'La categoría ha sido desactivada exitosamente')->autoclose(3000);

    return redirect()->route('categoria');
}
}