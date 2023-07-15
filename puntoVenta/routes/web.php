<?php

use App\Models\Producto;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

/* Rutas de Categoria */
//Listado
Route::get('/categoria', [CategoriaController::class, 'index'])->name('categoria');
//Creacion categoria
Route::get('/categoria/crear', [CategoriaController::class, 'crear'])->name('categoria.crear');
Route::post('/categoria/store', [CategoriaController::class, 'store'])->name('categoria.store');
//Edicion Catergoria
Route::get('/categoria/edit/{id}', [CategoriaController::class, 'edit'])->name('categoria.edit');
Route::post('/categoria/update', [CategoriaController::class, 'update'])->name('categoria.update');
//Eliminacion-anulacion categoria
Route::delete('/categoria/{id}', [CategoriaController::class, 'destroy'])->name('categoria.destroy');

/* Rutas de Categoria */
//Listado
Route::get('/producto', [ProductoController::class, 'index'])->name('producto');
//Creacion Producto
Route::get('/producto/crear', [ProductoController::class, 'crear'])->name('producto.crear');
Route::post('/producto/store', [ProductoController::class, 'store'])->name('producto.store');
//Edicion Catergoria
Route::get('/producto/edit/{id}', [ProductoController::class, 'edit'])->name('producto.edit');
Route::post('/producto/update', [ProductoController::class, 'update'])->name('producto.update');
//Eliminacion-anulacion Producto
Route::delete('/producto/{id}', [ProductoController::class, 'destroy'])->name('producto.destroy');

