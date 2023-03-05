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
    return Inertia::render('Create', []);
});

Route::get('/home', [RicoAssistant::class, 'home'])->name('home');
Route::post('/store', [RicoAssistant::class, 'store'])->name('store');
Route::get('/filter', [RicoAssistant::class, 'filter'])->name('filter');
Route::get('/detail', [RicoAssistant::class, 'detail'])->name('detail');
Route::post('/update', [RicoAssistant::class, 'update'])->name('update');
Route::post('/delete', [RicoAssistant::class, 'delete'])->name('delete');
Route::post('/refcheck', [RicoAssistant::class, 'reference'])->name('refcheck');
Route::get('/create/titlecheck', [RicoAssistant::class, 'titlecheck'])->name('titlecheck');
Route::post('/tag', [RicoAssistant::class, 'tag'])->name('tag');
Route::post('/edit', [RicoAssistant::class, 'edit'])->name('edit');
// Route::get('/tag', [RicoAssistant::class, 'tag'])->name('tag');

Route::post('/preset_store', [RicoAssistant::class, 'preset_store'])->name('preset_store');
Route::post('/preset_update', [RicoAssistant::class, 'preset_update'])->name('preset_update');
Route::post('/preset_delete', [RicoAssistant::class, 'preset_delete'])->name('preset_delete');

// get summaries data
Route::post('/backup_check', [RicoAssistant::class, 'backup'])->name('backup');
Route::post('/statistic', [RicoAssistant::class, 'statistic'])->name('statistic');

Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
});

Route::get('/migrate', function () {
    Artisan::call('migrate:refresh');
});

Route::get('/backup', function () {
    Artisan::call('database:backup_manual');
    return Inertia::render('Backup');
});



