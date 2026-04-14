<?php

use App\Http\Controllers\InventarisController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LendingsController;


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

 Route::get('/error404', function () { return view('errors.404');});

Route::prefix('inventaris')->middleware('auth')->group(function () {
    Route::get('/',[InventarisController::class, 'index'])->name('inventaris.index');

    Route::prefix('categories')->middleware('auth', 'role:admin')->group(function () {    
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
        Route::middleware('auth', 'role:admin')->group(function () { 
            Route::get('/admin', [UserController::class, 'index'])->name('users.index');
            Route::get('/authoperator', [UserController::class, 'authoperator'])->name('users.authoperator');
            Route::get('/create', [UserController::class, 'create'])->name('users.create');
            Route::post('/', [UserController::class, 'store'])->name('users.store');
            Route::get('/{user}', [UserController::class, 'show'])->name('users.show');
            Route::get('/export/excel', [UserController::class, 'exportExcel'])->name('users.export');
            Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy');
            Route::post('/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');
        });

        Route::middleware('auth')->group(function () {
            Route::get('/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
            Route::put('/{user}', [UserController::class, 'update'])->name('users.update');
        });
    });

    Route::prefix('lendings')->middleware('auth')->group(function () {

        Route::middleware('auth','role:operator')->group(function () { 
            Route::get('/', [LendingsController::class, 'index'])->name('lendings.index');
            Route::get('/create', [LendingsController::class, 'create'])->name('lendings.create');
            Route::post('/', [LendingsController::class, 'store'])->name('lendings.store');
            Route::patch('/{lending}/return', [LendingsController::class, 'markAsReturned'])->name('lendings.return');
            Route::delete('/{lending}', [LendingsController::class, 'destroy'])->name('lendings.destroy');
            Route::get('/export/excel', [LendingsController::class, 'exportExcel'])->name('lendings.export');
        });

        Route::get('/{lending}', [LendingsController::class, 'show'])->name('lendings.show');
     });


});


Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit')->middleware('guest');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');



