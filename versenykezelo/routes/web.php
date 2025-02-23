<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompetitionController;
use App\Http\Controllers\RoundController;

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

Route::get('/', [Controller::class,'index'])->middleware('notLoggedInCheck')->name('welcome');
Route::get('/login',[Controller::class,'index']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister'])->middleware('notLoggedInCheck')->name('showRegister');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/competitions', [CompetitionController::class,'index'])->middleware('loggedInCheck')->name('competitions');
Route::get('/competition/create', [CompetitionController::class, 'create'])->middleware('adminLogin');
Route::get('/competition/store', [CompetitionController::class,'index']);
Route::post('/competition/store', [CompetitionController::class, 'store'])->middleware('adminLogin');
Route::get('/competition/show/{name}/{year}', [CompetitionController::class,'show'])->middleware('loggedInCheck')->name('showCompetition');
Route::get('/competition/delete/{name}/{year}',[CompetitionController::class,'destroy'])->middleware('adminLogin');
Route::get('/competition/edit/{name}/{year}', [CompetitionController::class,'edit'])->middleware('adminLogin')->name('editcompetition');
Route::get('/competition/update/{name}/{year}', [CompetitionController::class,'index'])->middleware('adminLogin');
Route::post('/competition/update/{name}/{year}', [CompetitionController::class,'update'])->middleware('adminLogin');

Route::get('/round/edit/{id}', [RoundController::class, 'edit'])->middleware('adminLogin')->name('roundEdit');
Route::post('/round/update/{id}', [RoundController::class, 'update'])->middleware('adminLogin');
Route::post('/rounds/store/{c_name}/{c_year}', [RoundController::class, 'store'])->middleware('adminLogin');
Route::get('/rounds/delete/{id}', [RoundController::class, 'destroy'])->middleware('adminLogin');
Route::get('/round/user/delete/{id}/{email}', [RoundController::class, 'deleteUserRoundConnection']);


