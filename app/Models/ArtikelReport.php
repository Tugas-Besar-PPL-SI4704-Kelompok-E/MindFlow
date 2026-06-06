<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArtikelReport extends Model
{
    // Fillable attributes for mass assignment
    protected $fillable = ['artikel_id', 'user_id', 'reason', 'status'];

    public function artikel()
    {
        return $this->belongsTo(Artikel::class, 'artikel_id', 'artikel_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
