<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//To display all
Route::get('/', function () {
    return Inertia::render('Book');
})->name('book');




// To add row
Route::post('/', [BookController::class, 'store'])->name('book');

Route::get('/', [BookController::class, 'index'])->name('book');


// To delete row
Route::delete('/books/{id}', [BookController::class, 'destroy'])->name('books.destroy');
//Route::get('/delete', [BookController::class, 'destroy']);

// To update row
Route::put('/books/{id}', [BookController::class, 'update'])->name('books.update');




/*Route::get('/', function () {
    return Inertia::render('Book', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});*/

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
