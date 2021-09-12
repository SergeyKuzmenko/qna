<?php

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/tags', function (Request $request, Tag $tag) {
    if ($request->has('q')) {
        return response()->json($tag->select(['id', 'icon','title as text'])
            ->where('title', 'like', '%' . $request->q . '%')
            ->get()
        );
    } else {
        return response()->json([]);
    }
})->name('api.tags');

