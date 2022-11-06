<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\RicoAssistant;
use App\Models\Inventory;
use Illuminate\Support\Facades\Artisan;

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

Route::get('/', function () {
    return Inertia::render('Home', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('/');

Route::get('/welcome', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

Route::get('/create', function () {
    return Inertia::render('Create', [
    ]);
});

Route::post('/store', [RicoAssistant::class, 'store'])->name('store');
Route::get('/list', [RicoAssistant::class, 'filter'])->name('list');
Route::get('/detail', [RicoAssistant::class, 'detail'])->name('detail');
Route::post('/update', [RicoAssistant::class, 'update'])->name('update');
Route::post('/delete', [RicoAssistant::class, 'delete'])->name('delete');
Route::post('/refcheck', [RicoAssistant::class, 'reference'])->name('refcheck');
Route::post('/titlecheck', [RicoAssistant::class, 'titlecheck'])->name('titlecheck');

Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
});

Route::get('/migrate', function () {
    Artisan::call('migrate:refresh');
});



