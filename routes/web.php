<?php

use App\Models\Offer;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('test' , function (\Illuminate\Http\Request  $request) {

//   return  \App\Models\category::find(1)->offers;

    if ($request->category != null) {

        $offer = Offer::whereRelation('category', 'id', '=', $request->category)
           -> where('price' , '>' , request('min') ?? 0)
            ->where('price' , '<' , request('max') ?? Offer::max('price')+1)
              ->where('area' ,'>' , $request->area ?? 0)
            ->where('nbr_ch' , '<' ,$request->chmber ?? 0 )

            ->get('price');
    }



    else{
        $offer = Offer::where('price' , '>' , request('min') ?? 0)
            ->where('price' , '<' , request('max') ?? Offer::max('price')+1)->get('price');
    }


    return $offer;
});
