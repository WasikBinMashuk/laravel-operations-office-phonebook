<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\PhoneBookController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});

// Destroy session route
Route::get('/destroy', [AuthController::class, 'destroy'])->name('destroy');

Auth::routes();
// Auth::routes(['register' => false, 'password.request' => false, 'reset' => false]);

// CRUD route
Route::resource('companies', CompanyController::class);

// PhoneBook routes

Route::get('/phonebook', [PhoneBookController::class, 'index'])->name('phonebook.index');
Route::post('/phonebook/store', [PhoneBookController::class, 'store'])->name('phonebook.store');
Route::get('/phonebook/{id}/edit', [PhoneBookController::class, 'edit'])->name('phonebook.edit');
Route::put('/phonebook/update', [PhoneBookController::class, 'update'])->name('phonebook.update');
Route::get('/phonebook/{id}/delete', [PhoneBookController::class, 'delete'])->name('phonebook.delete');



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
