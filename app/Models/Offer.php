<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, mixed $user_id)
 * @method static max(string $string)
 */
class Offer extends Model
{
    use HasFactory;
    protected $fillable = [
        'title','vente', 'price', 'category_id','user_id','description','adresse','latitude',"longitude",'nbr_chambres','nbr_cuisine','nbr_sbain','superficie',"meubles",'garage','jardin','piscine','nbr_etages','num_etage','parking','promotion_imob','acte','livret'
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
