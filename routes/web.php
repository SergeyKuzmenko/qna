<?php

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
//Auth::routes();

Route::get('/', [App\Http\Controllers\QuestionController::class, 'all'])->name('feed');
Route::get('/q/{id}', [App\Http\Controllers\QuestionController::class, 'show'])->where('id', '[0-9]+')->name('question.show');


Route::get('/dark-side', [App\Http\Controllers\Controller::class, 'darkMode'])->name('dark-side');
Route::post('/app/toggleSidebar', [App\Http\Controllers\Controller::class, 'toggleSidebar'])->name('toggleSidebar');

Route::get('/tags', [App\Http\Controllers\TagController::class, 'all'])->name('tags.all');
Route::prefix('tag/{slug}')
    ->group(function () {
        Route::get('', [App\Http\Controllers\TagController::class, 'info'])->name('tag.info');
        Route::get('/questions', [App\Http\Controllers\TagController::class, 'questions'])->name('tag.questions');
        Route::get('/followers', [App\Http\Controllers\TagController::class, 'followers'])->name('tag.followers');
        Route::get('/subscribe', [App\Http\Controllers\TagController::class, 'subscribe'])->name('tag.subscribe');
        Route::get('/unsubscribe', [App\Http\Controllers\TagController::class, 'unsubscribe'])->name('tag.unsubscribe');
    });

Route::get('/users', [App\Http\Controllers\UserController::class, 'all'])->name('users.all');
Route::prefix('user/{username}')
    ->group(function () {
        Route::get('', [App\Http\Controllers\UserController::class, 'info'])->name('user');
        Route::get('/questions', [App\Http\Controllers\UserController::class, 'questions'])->name('user.questions');
        Route::get('/answers', [App\Http\Controllers\UserController::class, 'answers'])->name('user.answers');
        Route::get('/subscriptions', [App\Http\Controllers\UserController::class, 'subscriptions'])->name('user.subscriptions');
    });

Route::group(['middleware' => 'auth'], function () {
    Route::prefix('my')->group(function () {
        Route::get('/feed', [App\Http\Controllers\MyController::class, 'index'])->name('my.feed');
        Route::get('/questions', [App\Http\Controllers\MyController::class, 'questions'])->name('my.questions');
        Route::get('/answers', [App\Http\Controllers\MyController::class, 'answers'])->name('my.answers');
        Route::get('/tags', [App\Http\Controllers\MyController::class, 'tags'])->name('my.tags');
        Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'show'])->name('my.profile.show');
        Route::get('/history', [App\Http\Controllers\ProfileController::class, 'history'])->name('my.history');
        Route::get('/settings', [App\Http\Controllers\ProfileController::class, 'settings'])->name('my.settings');
    });

    Route::prefix('question')->group(function () {
        Route::get('/new', [App\Http\Controllers\QuestionController::class, 'new'])->name('question.new');
        Route::post('/store', [App\Http\Controllers\QuestionController::class, 'store'])->name('question.store');
        Route::post('/subscribe', [App\Http\Controllers\QuestionController::class, 'subscribe'])->name('question.subscribe');
        Route::post('/unsubscribe', [App\Http\Controllers\QuestionController::class, 'unsubscribe'])->name('question.unsubscribe');
        Route::get('/subscribers', [App\Http\Controllers\QuestionController::class, 'subscribers'])->name('question.subscribers');

    });

    Route::prefix('answer')->group(function () {
        Route::post('/new', [App\Http\Controllers\AnswerController::class, 'store'])->name('answer.new');
        Route::post('/delete', [App\Http\Controllers\AnswerController::class, 'destroy'])->name('answer.delete');
    });

    Route::prefix('reaction')->group(function () {
        Route::post('/like', [App\Http\Controllers\ReactionController::class, 'like'])->name('reaction.like');
        Route::post('/unlike', [App\Http\Controllers\ReactionController::class, 'unlike'])->name('reaction.unlike');
        Route::post('/likes', [App\Http\Controllers\ReactionController::class, 'likes'])->name('reaction.likes');

    });

    Route::prefix('comment')->group(function () {
        Route::post('/store', [App\Http\Controllers\CommentController::class, 'store'])->name('comment.store');

    });
});
