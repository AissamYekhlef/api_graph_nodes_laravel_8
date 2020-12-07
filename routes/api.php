<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GraphController;
use App\Http\Controllers\NodeController;
use App\Http\Controllers\RelationController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [AuthController::class,'login']);
    Route::post('register', [AuthController::class,'register']);
    Route::post('logout', [AuthController::class,'logout']);
    Route::post('refresh', [AuthController::class,'refresh']);
    Route::post('user-profile', [AuthController::class,'userProfile']);

});


Route::group([

    'middleware' => 'api',
    // 'prefix' => 'auth'

], function () {

    // Route::apiResource('graphs', GraphController::class);
    Route::get('graphs', [GraphController::class, 'index'])->name('graphs.index');
    Route::post('graphs/create', [GraphController::class, 'store'])->name('graphs.store');
    Route::post('graphs/{graph}/update', [GraphController::class, 'update'])->name('graphs.update');
    Route::delete('graphs/{graph}', [GraphController::class, 'destroy'])->name('graphs.destroy');
    Route::get('graphs/{graph}', [GraphController::class, 'show'])->name('graphs.show');

    Route::post('graphs/{graph}/add/nodes/{node}', [GraphController::class, 'addNode'])->name('graphs.nodes.add');
    Route::post('graphs/{graph}/add/relation', [GraphController::class, 'addRelation'])->name('graphs.relations.add');


    Route::post('/nodes/create', [NodeController::class, 'store'])->name('nodes.store');

    Route::apiResource('nodes', NodeController::class);

    // Route::resource('relaions', RelationController::class);
    
});
