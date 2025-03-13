<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory;
    public function itineraire(){
        return $this->belongsTo(itineraire::class,"itenairire_Id");
    }
    protected $fillable = [
        "nom",
        "lounge",
        "places_to_visit",
        "destinations"
    ];

    protected $casts = [
        'places_to_visit' => 'array'
    ];
}
