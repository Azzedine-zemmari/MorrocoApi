<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class favoris extends Model
{
    use HasFactory;
    protected $fillable = [
        'userId',
        'itineraireId'
    ];
    public function user(){
        return $this->belongsTo(User::class,'userId');
    }
    public function itineraire(){
        return $this->belongsTo(Itineraire::class,'itineraireId');
    }
}
