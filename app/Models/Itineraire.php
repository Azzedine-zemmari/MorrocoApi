<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Itineraire extends Model
{
    use HasFactory;
    protected $fillable = [
        'titre',
        'categorie',
        'duree',
        'image',
        'destinations',
        'userId'
    ];
    protected $casts = [
        'destinations' => 'array'
    ];

    public function user(){
        return $this->belongsTo(User::class,'userId');
    }
}
