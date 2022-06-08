<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Offer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Image;
use App\Models\User;
use Laravel\Sanctum\PersonalAccessToken;

class OffersController extends Controller
{
    public function index(Request $request)
    {
       return   Offer::with(['images','category','user'])->latest()->get();


       // return Offer::all();

    }

    public function show($id)
    {
        $offer = Offer::with(['category','images','user'])->find($id);
        $offer->counter_vues = $offer->counter_vues+1;
        $offer->save();

      $offer_date =   Carbon::parse($offer->created_at)->addHour()->toDateTimeString();

      $arr = [];
      $arr = $offer->toArray();
      $arr ['created_at'] = $offer_date;
         return $arr;
    }




    public function store(Request $request)
    {

         $offer = Offer::create($request->all());

        if($request->hasFile('images')){

            foreach ($request->file('images') as $imagefile) {
                $image = new Image;
                $path = $imagefile->store('public/images/offers/'. $offer->id);
                $image->url = $path;
                $image->offer_id = $offer->id;
                $image->save();
            }
        }
        return response('Offer created ' . $offer->id, 201);
    }


    private function resizeImage($image)
    {
        $resizedImage = Image::make($image);
        $resizedImage->resize(null, 200, function ($constraint) {
            $constraint->aspectRatio();
        });
        //$resizedImage->stream();
        return $resizedImage;
    }
    // public function list(){
    //     return 'List of offers';
    // }
    // public function show($id){
    //     return 'Offer: '.$id;
    // }
    public function off(Request $request)
    {
      //  return Offer::where(['user_id',$request->user_id])->get();
        return Offer::with('images')->where('user_id', $request->user_id)->get();
    }




    public function offer_user(Request $request)
    {
        $token = PersonalAccessToken::findToken(request('token'));

        if (!$token) {
            dd("Error: Token not found");
        }

        $user = $token->tokenable;

       return   Offer::where('user_id',$user->id )->with(['category','images','user'])->get();
           //User::find($user)->Offer::with(['category','images','user']);
    }




    public function info_user(Request $id)
    {
        return  User::find($id);
    }









    /*Update offer*/

    public function update(Request  $request , $id)
    {
        $offer = Offer::find($id);

//
//        $user->photo = null;
//
//        $user->photo = newOne;
        $offer->update([
           'title' =>  $request->title,
            'price' => $request->price,
            'vente' => $request->vente,
            'description' => $request->description,
            'adresse' => $request->adresse,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'eau' => $request->eau,
            'elec' => $request->elec,
            'gaz' => $request->gaz,
            'nbr_chambres' => $request->nbr_chambres,
            'superficie' => $request->superficie,
            'meubles' => $request->meubles,
            'garage' => $request->garage,
            'jardin' => $request->jardin,
            'piscine' => $request->piscine,
            'nbr_etage' => $request->nbr_etage,
            'parking' => $request->parking,
            'promotion_imob' => $request->promotion_imob,
            'acte' => $request->acte,
            'livret' => $request->livret,
            'category_id' => $request->category_id,
        ]);


        $offer->images()->delete();


        if($request->hasFile('images')){

            foreach ($request->file('images') as $imagefile) {
                $image = new Image;
                $path = $imagefile->store('public/images/offers/'. $offer->id);
                $image->url = $path;
                $image->offer_id = $offer->id;
                $image->save();
            }
        }



        return $offer;



    }







      public function recherche (Request  $request)
      {

//   return  \App\Models\category::find(1)->offers;

              $offer = Offer::whereRelation('category', 'id', '=', $request->category)
                  ->where('price', '>', request('min') ?? 0)
                  ->where('price', '<', request('max') ?? Offer::max('price') + 1)
                  ->where('area', '>', $request->area ?? 0)
                  ->where('vente', '=', $request->vente ?? 1)
                  ->where('eau', '=', $request->eau ?? 0)
                  ->where('gaz', '=', $request->gaz ?? 0)
                  ->where('elec', '=', $request->elec ?? 0)
                  ->where('meubles', '=', $request->meubles ?? 0)
                  ->where('garage', '=', $request->garage ?? 0)
                  ->where('jardin', '=', $request->jardin ?? 0)
                  ->where('piscine', '=', $request->piscine ?? 0)
                  ->where('parking', '=', $request->parking ?? 0)
                  ->whereIn('acte', '=', $request->acte ?? [null ,0,1])
                  ->where('nbr_chambres', '<', $request->chmber ?? 0)
                  ->get('price');
      }
}
