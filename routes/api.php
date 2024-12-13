<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BackendController;
// use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\BookController;

Route::get('test', function () {
    return response()->json(['message' => 'Test route is working!']);
});

// Route::get('/', function () {
//     return view('welcome');
// });
// Route::prefix('v1')->group(function () {
//     Route::get('test', function () {
//         return response()->json(['message' => 'Test route is working!']);
//     });
// });
// Route::name('api.')->group(function () {
//     // Route::get('/books', [BackendController::class, 'index'])->name('books.index');

// Route::get('/test', function () {
//     return response()->json(['message' => 'API is working']);
// });
//**************************Auth */


// Route::get('forgot/password', [AuthController::class, 'showResetPasswordForm'])->name('password.request');
// Route::post('reset/password', [AuthController::class, 'resetPassword'])->name('password.reset');

// Logout
// Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth:api')->name('logout');
// Route::group(['middleware' => 'jwt.auth'], function () {
//     Route::get('dashboard', fn() => view('dashboard'))->name('dashboard');
// });



//**************************BOOK***************************/

// Route::get('/books', [BookController::class, 'index'])->name('api.books.index');
// });
// View all books
// Route::get('/books/create', [BookController::class, 'create'])->name('books.create'); // Create book form
// // Route::post('/books/create', [BookController::class, 'store'])->name('books.create.submit'); // Submit new book
// // Route::post('/books/store', [BookController::class, 'store'])->middleware('jwt.auth')->name('books.create.submit');
// Route::post('/books/create', [BookController::class, 'store'])->name('books.create.submit');
// Route::get('books/image/{filename}', [BookController::class, 'getBookImage'])->name('books.image');
// Route::get('books/pdf/{filename}', [BookController::class, 'getBookPdf'])->name('books.pdf');
// Route::get('/books/edit/{id}', [BookController::class, 'edit'])->name('books.edit'); // Edit book form
// Route::put('/books/{id}', [BookController::class, 'update'])->name('books.update'); // Update book
// Route::delete('/books/{id}', [BookController::class, 'destroy'])->name('books.delete'); // Delete book

//**********************profile**************************/

// Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
// Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
// Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

// // Profile Page
// // Route::get('/profile', [UserController::class, 'profile'])->name('profile');



// Route::prefix('categories')->group(function () {
//     Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
//     Route::get('/create', [CategoryController::class, 'create'])->name('categories.create');
//     Route::post('/', [CategoryController::class, 'store'])->name('categories.store');
//     Route::get('/{id}', [CategoryController::class, 'show'])->name('categories.show');
//     Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
//     Route::put('/{id}', [CategoryController::class, 'update'])->name('categories.update');
//     Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
// });

// <?php

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\BackendController;

// /*
// |--------------------------------------------------------------------------
// | API Routes
// |--------------------------------------------------------------------------
// |
// | Here is where you can register API routes for your application. These
// | routes are loaded by the RouteServiceProvider within a group which
// | is assigned the "api" middleware group. Enjoy building your API!
// |
// // */

// // Authhhhhhhhhhhhhh Public Routes
// Route::post('/signup', [BackendController::class, 'signup']);
// Route::post('/signin', [BackendController::class, 'signin']);
// // Route::post('/admin-signin', [AuthController::class, 'adminSignin']);
// // Route::post('/admin-signup', [AuthController::class, 'adminSignup']);
// Route::post('/password/reset', [BackendController::class, 'resetPassword']);
// // Route::get('/password/reset/{token}', [BackendController::class, 'showResetPasswordForm']);
// Route::get('/books', [BackendController::class, 'index']);
// Route::get('/books/thumbnails/{filename}', [BackendController::class, 'getBookThumbnail']);
// Route::get('/books/pdfs/{filename}', [BackendController::class, 'getBookPdf']);
// Route::get('/books/images/{filename}', [BackendController::class, 'getImage']);
// Route::get('/books/category/{name}', [BackendController::class, 'getspecificatagoriescbook']);
// Route::get('/books/{id}', [BackendController::class, 'getspecificbook']);

// // Protected Routes (requires JWT authentication)
// Route::middleware(['jwt.auth'])->group(function () {
//     Route::get('/user', [BackendController::class, 'getUserData']);
//     Route::post('/logout', [BackendController::class, 'logout']);
//     Route::post('/password/edit', [BackendController::class, 'editPassword']);
// });

// /****************book*************************************/


// // Route::middleware(['jwt.auth'])->group(function () {
// //     Route::post('/books', [BookController::class, 'store']);
// //     Route::put('/books/{id}', [BookController::class, 'update']);
// //     Route::delete('/books/{id}', [BookController::class, 'destroy']);
// // });


// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Route;

// Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
// return $request->user();
// });
// Route::middleware('auth:api')->get('user', function (Request $request) {
// return $request->user();
// });