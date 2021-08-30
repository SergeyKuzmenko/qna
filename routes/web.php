<?php

use App\Http\Controllers\Auth\RegisteredUserController;
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

require __DIR__ . '/auth.php';
Auth::routes();

Route::post('/register', [RegisteredUserController::class, 'store'])
    ->name('register.store');

Route::get('/', [App\Http\Controllers\QuestionController::class, 'all'])->name('feed');
Route::get('/q/{id}', [App\Http\Controllers\QuestionController::class, 'show'])->name('question.show');
Route::get('/q/{id}/subscribers', [App\Http\Controllers\QuestionController::class, 'subscribers'])->name('question.subscribers');
Route::get('/question/new', [App\Http\Controllers\QuestionController::class, 'new'])->middleware(['auth'])->name('question.new');
Route::post('/question/new', [App\Http\Controllers\QuestionController::class, 'store'])->middleware(['auth'])->name('question.store');
Route::get('/dark-mode={mode}', [App\Http\Controllers\Controller::class, 'darkMode'])->name('dark-mode');

Route::get('/tags', [App\Http\Controllers\TagController::class, 'all'])->name('tags.all');
Route::prefix('tag/{slug}')
    ->group(function () {
        Route::get('', [App\Http\Controllers\TagController::class, 'info'])->name('tag.info');
        Route::get('questions', [App\Http\Controllers\TagController::class, 'questions'])->name('tag.questions');
        Route::get('followers', [App\Http\Controllers\TagController::class, 'followers'])->name('tag.followers');
        Route::get('subscribe', [App\Http\Controllers\TagController::class, 'subscribe'])->name('tag.subscribe');
        Route::get('unsubscribe', [App\Http\Controllers\TagController::class, 'unsubscribe'])->name('tag.unsubscribe');
    });

Route::get('/users', [App\Http\Controllers\UserController::class, 'all'])->name('users.all');
Route::prefix('user/{username}')
    ->group(function () {
        Route::get('',  [App\Http\Controllers\UserController::class, 'info'])->name('user');
//        Route::get('info', [App\Http\Controllers\UserController::class, 'info'])->name('user.info');
        Route::get('questions', [App\Http\Controllers\UserController::class, 'questions'])->name('user.questions');
        Route::get('answers', [App\Http\Controllers\UserController::class, 'answers'])->name('user.answers');
        Route::get('subscriptions', [App\Http\Controllers\UserController::class, 'subscriptions'])->name('user.subscriptions');
    });


//Route::get('/user/{username}', [App\Http\Controllers\UserController::class, 'get'])->name('user.get');

Route::group(['midleware' => 'auth'], function () {
    Route::prefix('my')->group(function () {
        Route::get('/feed', [App\Http\Controllers\MyController::class, 'index'])->name('my.feed');
        Route::get('/questions', [App\Http\Controllers\MyController::class, 'questions'])->name('my.questions');
        Route::get('/answers', [App\Http\Controllers\MyController::class, 'answers'])->name('my.answers');
        Route::get('/tags', [App\Http\Controllers\MyController::class, 'tags'])->name('my.tags');

        Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'show'])->name('my.profile.show');
        Route::get('/history', [App\Http\Controllers\ProfileController::class, 'history'])->name('my.history');
        Route::get('/settings', [App\Http\Controllers\ProfileController::class, 'settings'])->name('my.settings');
    });
});

