<?php

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    //  return $request->user();
//});

//Route::get('/category', [OffersController::class, 'list']);
//Route::get('/offers/{id}', [OffersController::class, 'show']);

//Route::post('offers/{id?}', function ($id='offers1'){
  //  return 'Post Offer'.$id;
//});

Route::get('/by',function (){
    return 'hello';
});
  //

    Route::get('/category', [OffersController::class, 'list']);
    Route::apiResource('offer', \App\Http\Controllers\OffersController::class);
    Route::apiResource('category', \App\Http\Controllers\CategoryController::class);
    Route::apiResource('photo', \App\Http\Controllers\PhotosController::class);
//Route::post('photo',[\App\Http\Controllers\PhotosController::class, 'store']);
    Route::post('register', [\App\Http\Controllers\AuthController::class, 'register']);
    Route::post('login', [\App\Http\Controllers\AuthController::class, 'login']);
//Route::get('ess',[\App\Http\Controllers\OffersController::class , 'ess']);
    Route::post('logout', [\App\Http\Controllers\AuthController::class, 'logout'])->middleware();

    Route::get('images/{id}', [\App\Http\Controllers\ImageController::class, 'fetch']);
    Route::post('off', [\App\Http\Controllers\OffersController::class, 'off']);


Route::apiResource('user', \App\Http\Controllers\AuthController::class);   /* Get info of USER  function show*/


Route::post('offer_user', [\App\Http\Controllers\AuthController::class, 'offer']);  /* Offer of USER   */








Route::post('comments/create',[\App\Http\Controllers\CommentsController::class,'create']);
Route::post('comments/delete',[\App\Http\Controllers\CommentsController::class,'delete']);
Route::post('comments/update',[\App\Http\Controllers\CommentsController::class,'update']);
Route::post('comments/comments',[\App\Http\Controllers\CommentsController::class,'comments']);




Route::post('favoris/create',[\App\Http\Controllers\FavorisController::class,'create']);
Route::get('favoris/get',[\App\Http\Controllers\FavorisController::class,'all_fav']);

//Route::post('comments/comments',[\App\Http\Controllers\CommentsController::class,'comments']);




//Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::post('find_user',[\App\Http\Controllers\AuthController::class,'find_user']);
    Route::post('get_my_id',[\App\Http\Controllers\AuthController::class,'get_my_id']);

   // });

Route::post('offer/update/{id}' , [\App\Http\Controllers\OffersController::class , 'update']);






Route::get('get/all_agences',[\App\Http\Controllers\AuthController::class,'all_agences']);

Route::post('get/offer_user',[\App\Http\Controllers\OffersController::class,'offer_user']);


Route::post('logoutseconde', [\App\Http\Controllers\AuthController::class, 'logout']);
Route::post('offer/recherche',[\App\Http\Controllers\OffersController::class,'recherche']);

