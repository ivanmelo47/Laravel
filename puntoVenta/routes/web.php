<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
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

require __DIR__.'/auth.php';


Route::middleware(['auth', 'role:admin'])->group(function(){
    Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');
}); // End Group Admin