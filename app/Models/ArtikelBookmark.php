<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArtikelBookmark extends Model
{
    protected $table = 'bookmarks';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'artikel_id',
    ];

    /**
     * User yang membookmark.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Artikel yang di-bookmark.
     */
    public function artikel()
    {
        return $this->belongsTo(Artikel::class, 'artikel_id', 'artikel_id');
    }
}
