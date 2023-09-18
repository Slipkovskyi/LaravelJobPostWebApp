<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Models\Listing;
use App\Http\Controllers\ListingController;

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
//All listings
Route::get('/', [ListingController::class, 'index']);

//Show Create Form

Route::get("/listings/create", [ListingController::class, 'create'])->middleware('auth');

//Store Listing Data
Route::post('/listings/', [ListingController::class, 'store']);

//Show edit form
Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->middleware('auth');

// Edit Submit to Update

Route::put('/listings/{listing}', [ListingController::class, 'update'])->middleware('auth');
// Delete listing

Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])->middleware('auth');

//Manage listings

Route::get('/listings/manage', [ListingController::class, 'manage'])->middleware('auth');

//Single listing
Route::get('/listings/{listing}', [ListingController::class, 'show']);

//Show register create form

Route::get('/register', [UserController::class, 'create'])->middleware('guest');

//Create user

Route::post('/users', [UserController::class, 'store']);

//Log out user

Route::post('/logout', [UserController::class, 'logout']);

//Show login form

Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');

//Log in

Route::post('/users/authenticate', [UserController::class, 'authenticate']);

