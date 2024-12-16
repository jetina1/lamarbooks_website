<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\fileUpload;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BackendController;

Route::get('/', function () {
    return view('welcome');
});

//**************************only for admin Auth */
//signup
Route::get('/signup', [AuthController::class, 'showSignupForm'])->name('signup');
Route::get('/signin', function () {
    return view('auth.signin');
})->name('signin');

Route::post('/signup', [AuthController::class, 'signup'])->name('admin.signup.submit');
Route::post('/signin', [AuthController::class, 'Signin'])->name('admin.signin.submit');
Route::post('/upload', [fileUpload::class, 'upload']);
// Route::post('/flutter/signup', [BackendController::class, 'fluttersignup'])->name('flutter.signup');
// Route::post('/flutter/signin', [BackendController::class, 'fluttersignin'])->name('flutter.signin');

/********************password*************/
Route::get('forgot/password', [AuthController::class, 'showResetPasswordForm'])->name('password.request');
Route::post('reset/password', [AuthController::class, 'resetPassword'])->name('password.reset');

// Logout
Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth:api')->name('logout');
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
// Route::middleware('auth.cookie')->group(function () {
//     Route::get('/dashboard', [AuthController::class, 'index']);
// });
// Route::get('/dashboard', function () {
//     return view('dashboard');
// });



//**************************BOOK***************************/

Route::get('/books', [BookController::class, 'index'])->name('books.index'); // Fetch and view all books
Route::get('/books/create', [BookController::class, 'create'])->name('books.create'); // Create book form
Route::post('/books/store', [BookController::class, 'store'])->name('books.store');
// Route::post('/books/create', [BookController::class, 'store'])->name('books.create.submit');
Route::get('books/image/{filename}', [BookController::class, 'getBookImage'])->name('books.image');
Route::get('books/pdf/{filename}', [BookController::class, 'getBookPdf'])->name('books.pdf');
Route::get('/books/{id}/edit', [BookController::class, 'edit'])->name('books.edit'); // Edit book form
Route::put('/books/{id}', [BookController::class, 'update'])->name('books.update'); // Update book
Route::delete('/books/{id}', [BookController::class, 'destroy'])->name('books.delete'); // Delete book

//**********************profile**************************/
Route::middleware('jwt.auth')->group(function () {
    Route::get('/user/profile', [ProfileController::class, 'profile'])->name('profile');
    Route::put('/user/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
});
// Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
// Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

// Profile Page
// Route::get('/profile', [UserController::class, 'profile'])->name('profile');



Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/{id}', [CategoryController::class, 'show'])->name('categories.show');
    Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
});
