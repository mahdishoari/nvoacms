<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\TagController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get("/greeting", function(){
    return Inertia::render("HelloWorld");
});

Route::get("/posts", [PostController::class, "index"]);
Route::get("/post/{id}/{slug?}", [PostController::class, "show"]);

//page
Route::get("/page/{id}", [PageController::class, 'show']);

Route::get('profile/{id}', [ProfileController::class, 'show']);

Route::post('/post/{id}/comment', [CommentController::class,'store']);



//admin
Route::get('/posts/create', [PostController::class, 'create'])->middleware('auth', 'throttle:35,15');
Route::post('/post', [PostController::class, 'store'])->middleware('auth', 'throttle:35,15');
Route::get('/posts/edit/{post}', [PostController::class, 'edit'])->middleware('auth', 'throttle:35,15')->name('posts.edit');
Route::put('/post/{post}', [PostController::class, 'update'])->middleware('auth', 'throttle:35,15');
Route::get('/posts/datagrid', [PostController::class, 'datagrid'])->middleware('auth', 'throttle:35,15')->name('posts.datagrid');
Route::get('/comments/datagrid', [CommentController::class, 'datagrid'])->middleware('auth', 'throttle:35,15')->name('comments.datagrid');
Route::post('/comments/status', [CommentController::class, 'status'])->middleware('auth')->name('comments.status');
Route::delete('/comments/trash/{comment}', [CommentController::class, 'trash'])->middleware('auth')->name('comments.trash')->withTrashed();
Route::delete('/comments/delete/{comment}', [CommentController::class, 'delete'])->middleware('auth')->name('comments.delete')->withTrashed();
Route::get('/tags/datagrid', [TagController::class, 'datagrid'])->middleware('auth', 'throttle:35,15')->name('tags.datagrid');
Route::get('/tags/edit/{tag}', [TagController::class, 'edit'])->middleware('auth', 'throttle:35,15')->name('tags.edit');
Route::put('/tags/{tag}', [TagController::class, 'update'])->middleware('auth', 'throttle:35,15')->name('tags.update');
Route::post('/tags', [TagController::class, 'store'])->middleware('auth', 'api', 'throttle:35,15')->name('tags.store');
Route::get('/tags/{tag}', [TagController::class, 'show']);
Route::post('/category', [CategoryController::class, 'store'])->middleware('auth')->name('category.store');
Route::get('/categories', [CategoryController::class, 'index'])->middleware('auth')->name('categories.index');

require __DIR__.'/auth.php';
