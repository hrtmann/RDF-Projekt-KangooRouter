<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DhcpController;
use App\Http\Controllers\RoutingController;
use App\Http\Controllers\InterfaceController;

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

/*
Route::get('/', function () {
    return view('welcome');
});
*/
//Login als Startseite
Route::group(['middleware' => 'auth'], function () {
        Route::get('/', 'App\Http\Controllers\DashboardController@index');
});


Auth::routes();
Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout']);
Route::get('/interfaces/hardware', [App\Http\Controllers\InterfaceController::class, 'hardware']);
Route::get('/ajax/getAjaxData', 'App\Http\Controllers\osclasses\daController@getAjaxData');
Route::resource('/dashboard', 'App\Http\Controllers\DashboardController');
Route::get('/packets', 'App\Http\Controllers\DashboardController@showPackets');
Route::resource('/interfaces', 'App\Http\Controllers\InterfaceController');
Route::resource('/hardwareinterfaces', 'App\Http\Controllers\HardwareInterfaceController');
Route::resource('/definitions', 'App\Http\Controllers\DefinitionController');
Route::resource('/firewallrules', 'App\Http\Controllers\FirewallController');
Route::resource('/nats', 'App\Http\Controllers\NatController');
Route::resource('/dhcp', 'App\Http\Controllers\DhcpController');
Route::resource('/routes', 'App\Http\Controllers\RoutingController');
//Empfangen des Status und Weitergabe an Controllerfunktion "changeStatus"
Route::get('/changeStatusInterface', [App\Http\Controllers\InterfaceController::class, 'changeStatus'])->name('changeStatus');
Route::get('/changeStatusFirewall', [App\Http\Controllers\FirewallController::class, 'changeStatus'])->name('changeStatus');
Route::get('/changeStatusNat', [App\Http\Controllers\NatController::class, 'changeStatus'])->name('changeStatus');
Route::get('/changeStatusRoute', [App\Http\Controllers\RoutingController::class, 'changeStatus'])->name('changeStatus');
Route::get('/changeStatusDhcp', [App\Http\Controllers\DhcpController::class, 'changeStatus'])->name('changeStatus');
