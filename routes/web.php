<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InterestController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\GuestbookController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\StatisticsController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\GuestbookController as AdminGuestbookController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CommentController;

Route::middleware(['web'])->group(function () {
    Route::view('/', 'main')->name("home");

    Route::get('/test', [TestController::class, "index"])->name('test.index');
    Route::post('/test', [TestController::class, "store"])->name('test.store');
    Route::get('/test-results', [TestController::class, 'testResults'])->name('test.results')->middleware("auth.user");

    Route::get('/contact', [ContactController::class, 'index']);
    Route::post('/contact', [ContactController::class, 'store']);

    Route::get('/interests', [InterestController::class, 'index']);

    Route::get('/album', [PhotoController::class, 'index']);

    Route::get('/guestbook', [GuestbookController::class, 'index'])->name('guestbook.index');
    Route::post('/guestbook', [GuestbookController::class, 'store'])->name('guestbook.store');

    Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
    Route::get('/blog/{id}', [BlogController::class, 'show'])->name('blog.show');
    Route::post('/blog/{postId}/comment', [CommentController::class, 'store']);

    // Авторизация и регистрация пользователей
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    Route::get("/check-is-login-available", [RegisterController::class, "checkIsLoginAvailable"]);
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Админ-панель
    Route::prefix('admin')->group(function () {
        Route::get('login', [AuthController::class, 'showLoginForm'])->name('admin.login');
        Route::post('login', [AuthController::class, 'login']);
        Route::get('logout', [AuthController::class, 'logout'])->name('admin.logout');

        Route::middleware(['auth.admin'])->group(function () {
            Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
            Route::get('/statistics', [StatisticsController::class, 'index'])->name('admin.statistics');
            
            // Блог
            Route::get('/blog', [BlogController::class, 'adminIndex'])->name('admin.blog.index');
            Route::get('/blog/create', [BlogController::class, 'create'])->name('admin.blog.create');
            Route::post('/blog', [BlogController::class, 'store'])->name('admin.blog.store');
            Route::get('/blog/{post}/edit', [BlogController::class, 'edit'])->name('admin.blog.edit');
            Route::get('/blog/{post}', [BlogController::class, 'update']);
            Route::delete('/blog/{post}', [BlogController::class, 'destroy'])->name('admin.blog.destroy');
            Route::post('/blog/import', [BlogController::class, "import"])->name("admin.blog.import");

            // Гостевая книга
            Route::get('/guestbook', [GuestbookController::class, 'adminIndex'])->name('admin.guestbook');
            Route::get('/guestbook-upload', [GuestbookController::class, 'createByFile'])->name('admin.guestbook.upload.form');
            Route::post('/guestbook-upload', [GuestbookController::class, 'storeByFile'])->name('admin.guestbook.upload.file');
        });
    });

    Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
    Route::get('/blog/{post}', [BlogController::class, 'show'])->name('blog.show');
    Route::get('/guestbook', [GuestbookController::class, 'index'])->name('guestbook.index');
    Route::post('/guestbook', [GuestbookController::class, 'store'])->name('guestbook.store');
});