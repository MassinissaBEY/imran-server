<?php

namespace App\Http\Controllers;

use App\Models\Favori;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class FavorisController extends Controller
{
    //

    public function create(Request $request){


        $token = PersonalAccessToken::findToken(request('token'));

        if (!$token) {
            dd("Error: Token not found");
        }

        $user = $token->tokenable;

     $user = $user;

     $favori = Favori::where('user_id' ,$user->id )->where('offer_id' , $request->offer_id)->first() ;

     if ( $favori ){
            Favori::where('user_id' ,$request->user_id)->where('offer_id' , $request->offer_id)->delete();

        }else{
            Favori::insert([
                'user_id'=>$user->id ,
                'offer_id'=>$request->offer_id,
                'created_at' => now(),
            ]);

            return "ok";
        }
        // $comment->user_id = Auth::user()->id;
//        $favoris->user_id = $request->user_id;
//        $favoris->offer_id = $request->offer_id;
//
//        $favoris->save();
        //$comment->user;

        //  return response()->json([
        //    'success' => true,
        //  'comment'=>$comment,
        // 'message' => 'comment added'
        //]);
        // return $request->comment;
    }


    public function delete(Request $request){

        $favori = Favori::where('offer_id', $request->offer_id);


   if($favori!=null){
       $favori->delete();
       return response()->json([
           'success' => true,
           'message' => 'comment deleted',
           $favori
       ]);
   }else{
       $favori->delete();
   }



    }




    public function favoris(Request $request)
    {
        $favoris = Favori::where('offer_id', $request->id)->get();


        // return $comments;

        //show user of each comment


        foreach ($favoris as $comment) {
            $comment->user;
        }

        return response()->json([
            //  'success' => true,
            'comments' => $favoris
        ]);
    }


        public function all_fav (){
            return  Favori::all();
        }

}
