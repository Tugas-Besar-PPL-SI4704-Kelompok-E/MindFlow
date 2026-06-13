<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    use HasFactory;
    protected $table = 'artikels';
    protected $primaryKey = 'artikel_id';

    protected $fillable = [
        'admin_id',
        'judul',
        'konten',
        'gambar_cover',
        'kategori',
        'penerbit',
        'status',
    ];

    /**
     * Admin yang membuat artikel.
     */
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    /**
     * Bookmarks dari user.
     */
    public function bookmarks()
    {
        return $this->hasMany(ArtikelBookmark::class, 'artikel_id', 'artikel_id');
    }

    /**
     * Check apakah artikel sudah di-bookmark oleh user tertentu.
     */
    public function isBookmarkedBy($userId)
    {
        return $this->bookmarks()->where('user_id', $userId)->exists();
    }

    /**
     * Scope: hanya artikel yang published.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Scope: filter by kategori.
     */
    public function scopeByKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }
}
