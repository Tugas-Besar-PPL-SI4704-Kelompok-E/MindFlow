<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilKonselor extends Model
{
    protected $table = 'profil_konselors'; 

    protected $fillable = [
        'user_id', 
        'nama', 
        'spesialisasi', 
        'biografi', 
        'keahlian'
    ]; 
}