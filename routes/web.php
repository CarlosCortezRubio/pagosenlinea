<?php

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
Route::get('/limpiar', function () {
   echo Artisan::call('config:clear');
   echo Artisan::call('config:cache');
   echo Artisan::call('cache:clear');
   echo Artisan::call('route:clear');
});

Route::get('/', function () {
  if (Auth::check()) {
      return redirect()->route('home');
   } else {
      return redirect()->route('login');
   }
});

//SIMULACIONES
Route::get('simularPago','SimulacionController@index');
Route::get('ReciboSimulado','SimulacionController@enviarReciboIngreso');

// Auth::routes();
Auth::routes(['register'=>false]);

Route::get('register','Auth\RegisterController@index')->name('register');
Route::post('register','Auth\RegisterController@store');
Route::get('register/generarCredenciales', 'Auth\RegisterController@generarCredenciales')->name('register.credenciales');
Route::post('register/generarCredenciales','Auth\RegisterController@guardarCredenciales')->name('createPassword');

Route::post('/admision','AdmisionCartController@apiRest')->name('api.rest');
Route::get('/admision/cartSignOut','AdmisionCartController@index')->name('admision');
Route::post('/admision/cartSignOut','AdmisionCartController@prepareAccessToken')->name('admision.pay');
Route::post('/orbisNotification','ListenerController@orbisNotification')->name('api.rest.notify');
Route::post('/generatedReceipt','ListenerController@apiRestRecibo')->name('api.rest.recibo');
Route::get('/viewPDF','ReciboController@recibo')->name('viewPDF');

//2021
Route::get('/externo/simularPago','ExternalController@showSimularPago')->name('external.simularPago');
Route::post('/externo/simularPago','ExternalController@simularPago')->name('external.simularPago.post');
//2021

Route::middleware(['auth'])->group(function() {
   Route::get('home','HomeController@index')->name('home');
   Route::get('home/paid','HomeController@paid')->name('paid');
   Route::get('home/cart','PagoController@index')->name('cart');
   Route::post('home/cart','PagoController@store')->name('cart.add.pay');
   Route::delete('home/cart/{id}','PagoController@destroy')
               ->name('pago.destroy');
   Route::get('receipt/{id}','PagoController@recibo')->name('recibo');
});

Route::get('/{slug}', function () {
  if (Auth::check()) {
      return redirect()->route('home');
   } else {
      return redirect()->route('login');
   }
});
