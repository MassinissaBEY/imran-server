<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class CommentsController extends Controller
{

    public function create(Request $request){
        $token = PersonalAccessToken::findToken(request('token'));

        if (!$token) {
            dd("Error: Token not found");
        }

        $user = $token->tokenable;


        $comment = new Comment;
       // $comment->user_id = Auth::user()->id;
        $comment->user_id = $user->id;
        $comment->offer_id = $request->offer_id;
        $comment->comment = $request->comment;
        $comment->save();
        $comment->user;

      //  return response()->json([
        //    'success' => true,
          //  'comment'=>$comment,
           // 'message' => 'comment added'
        //]);
       // return $request->comment;
    }

    public function update(Request $request){
        $comment = Comment::find($request->id);
        //check if user is editing his own comment
        if($comment->id != Auth::user()->id){
            return response()->json([
                'success' => false,
                'message' => 'unauthorize access'
            ]);
        }
        $comment->comment = $request->comment;
        $comment->update();

        return response()->json([
            'success' => true,
            'message' => 'comment edited'
        ]);
    }




    public function delete(Request $request){
        $comment = Comment::find($request->comment_id);    /// comment_id
        //check if user is editing his own comment

       // $token = PersonalAccessToken::findToken(request('token'));



      //  $user = $token->tokenable;


        //    if($comment->user_id != $user->id){       //hot fi data user_id : ????


        // }else{
        $comment->delete();

        return response()->json([
            'success' => true,
            'message' => 'comment deleted'
        ]);

    }




    public function comments(Request $request){
        $comments = Comment::where('offer_id',$request->id)->get();



      // return $comments;

        //show user of each comment


         foreach($comments as $comment){
            $comment->user;
         }

        return response()->json([
          //  'success' => true,
            'comments' => $comments
        ]);
    }

}
