<?php
use App\Http\Controllers\Callbacks\SearchController;
use Illuminate\Support\Facades\Route;

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

Route::prefix('callbacks')->name('callbacks.')->group(function(){
    Route::get('index', [SearchController::class, 'index'])->name('index');
    Route::get('suggest', [SearchController::class, 'suggest'])->name('suggest');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
