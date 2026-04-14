<?php

use App\Http\Controllers\InventarisController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\UserController;


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
    return view('index');
    })->name('home');

Route::prefix('inventaris')->middleware('auth')->group(function () {
    Route::get('/',[InventarisController::class, 'index'])->name('inventaris.index');

    Route::prefix('categories')->middleware('auth')->group(function () {    
        Route::get('/',[CategoriesController::class,'index'])->name('categories.index');
        Route::get('/create', [CategoriesController::class, 'create'])->name('categories.create');
        Route::post('/', [CategoriesController::class, 'store'])->name('categories.store');
        Route::get('/{category}/edit', [CategoriesController::class, 'edit'])->name('categories.edit');
        Route::put('/{category}', [CategoriesController::class, 'update'])->name('categories.update');
        Route::delete('/{category}', [CategoriesController::class, 'destroy'])->name('categories.destroy');
    });

    Route::prefix('items')->middleware('auth')->group(function () {
        Route::get('/', [ItemsController::class,'index'])->name('items.index');
        Route::get('/create', [ItemsController::class, 'create'])->name('items.create');
        Route::post('/', [ItemsController::class,'store'])->name('items.store');
        Route::get('/{item}/edit', [ItemsController::class, 'edit'])->name('items.edit');
        Route::put('/{item}', [ItemsController::class,'update'])->name('items.update');
        Route::get('/export/excel', [ItemsController::class, 'exportExcel'])->name('items.export');

    });

    Route::prefix('users')->middleware('auth')->group(function () {
        Route::get('/', [UserController::class,'index'])->name('users.index');
    });
});


Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit')->middleware('guest');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');



