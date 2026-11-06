<?php
use App\Http\Controllers\Web\DashboardWebController;
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
Route::get('/', [DashboardWebController::class, 'index'])->name('web.dashboard');

Route::get('/tenants', [DashboardWebController::class, 'tenants'])->name('web.tenants');

// Properties
Route::get('/properties', [DashboardWebController::class, 'properties'])->name('web.properties');
Route::post('/properties', [DashboardWebController::class, 'storeProperty'])->name('web.properties.store');

// Rooms
Route::get('/rooms', [DashboardWebController::class, 'rooms'])->name('web.rooms');
Route::post('/rooms', [DashboardWebController::class, 'storeRoom'])->name('web.rooms.store');


// Invoices
Route::get('/invoices', [DashboardWebController::class, 'invoices'])->name('web.invoices');
Route::post('/invoices', [DashboardWebController::class, 'storeInvoice'])->name('web.invoices.store');

// Route::get('/', function () {
//     return view('welcome');
// });
