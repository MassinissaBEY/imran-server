<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Photo;
use App\Models\User;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;



class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate(([
            'email' => 'required|email',
            'password' => 'required',

        ]));
        //check if already exist
        $user = User::where('email', $request->email)->first();
        if ($user) {
            return response('the provider email is already exists.', 403);
            //throw ValidationException::withMessages([
            //'email'=>['the provider email user already exists.']
            //]);
        }

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);


        if ($request->hasFile('photo')) {




            $originalImage = $request->file('photo');

            $image=$user->id.'_'.$originalImage->getClientOriginalName();
            // $originalImage->store('public/images/users'.user->id);
           // $var=Storage::disk()->put('user/' . $user->id . '', $originalImage);
            $request->photo->move('user',$image);

            $user->photo =$image;
            $user->save();

        }


        $response['token'] = $user->createToken($request->email)->plainTextToken;
        $response['user'] = $user;

        return response(json_encode($response), 201);
    }



    public function login(request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',

        ]);


        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response('The provided credentials are incorrect.', 403);
            //throw ValidationException::withMessages([
            // 'email' => ['The provided credentials are incorrect.'],
            // ]);
        }

        $response['token'] = $user->createToken($request->email)->plainTextToken;
        $response['user'] = $user;

        return response(json_encode($response));
    }

    public function logout(Request $request)
    {
        //$token = PersonalAccessToken::where('token', $request->token)->first();
        //  $user = PersonalAccessToken::where('token', $request->token)->first();
        //$user->tokens()->delete();

        //return response()->json('Successfully logged out');
        $hashedToken = $request->bearerToken();
        $token = PersonalAccessToken::where('token', $hashedToken)->first();
        $user = $token->tokenable;
        return $user;
    }


    public function show($id)
    {
        $user = user::with(['offer'])->find($id);

        return $user;
    }


    public function offer(Request $id)
    {
        $user = user::with(['offer'])->find($id);

        return $user;
    }




    public function find_user(Request $request)
    {
        //$user = user::find($id);

        //return $user;


        $token = PersonalAccessToken::findToken(request('token'));

        if (!$token) {
            dd("Error: Token not found");
        }

        $user = $token->tokenable;
        return $user;
    }



public function get_my_id () {
    $token = PersonalAccessToken::findToken(request('token'));

    if (!$token) {
        dd("Error: Token not found");
    }

    $user = $token->tokenable;
    return $user->id;
}




    public function all_agences(){
        return user::where('agence','=','1')->get();
    }



}

