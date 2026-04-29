<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    use HasFactory;

    // Menentukan primary key custom (karena bukan 'id')
    protected $primaryKey = 'journal_id';

    // Menentukan atribut yang bisa diisi secara mass-assignment
    protected $fillable = [
        'user_id',
        'content',
    ];

    /**
     * Relasi ke Model User (Setiap jurnal dimiliki oleh 1 user)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
