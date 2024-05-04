<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CrimeController;

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
Route::get('/login',function(){
   return redirect('/');
});
Route::get('/',[UserController::class,'loadLogin']);
Route::post('/login',[UserController::class,'userLogin'])->name('userLogin');

Route::get('/register',[UserController::class,'loadRegister']);
Route::Post('/register',[UserController::class,'userRegister'])->name('userRegister');

Route::get('/logout',[UserController::class,'logout']);


// Route::get('/home',[UserController::class,'home']);

Route::get('/insert',[CrimeController::class,'insertCrime']);
Route::post('/addCrime',[CrimeController::class,'addCrime'])->name('addCrime');

Route::get('/crime-map-search', [CrimeController::class, 'showCrimeMapSearch']);

Route::get('/get-crimes-by-location', [CrimeController::class, 'getCrimesByLocation']);

Route::get('/view',[CrimeController::class,'ViewCrimeData']);

Route::get('/edit/{crimeId}', [CrimeController::class,'editCrime'])->name('editCrime');

// Update Crime
Route::post('/update/{crimeId}', [CrimeController::class,'updateCrime'])->name('updateCrime');

Route::get('/delete/{crimeId}', [CrimeController::class,'deleteCrime'])->name('deleteCrime');

Route::get('/home', function () {
   return redirect('http://localhost:3000/#home');
});
Route::get('/about', function () {
   return redirect('http://localhost:3000/#about');
});
Route::get('/search', function () {
   return redirect('http://localhost:3000/#search');
});
Route::get('/alerts', function () {
   return redirect('http://localhost:3000/#alerts');
});
Route::get('/tip', function () {
   return redirect('http://localhost:3000/#contact');
});

