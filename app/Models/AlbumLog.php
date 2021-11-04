<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlbumLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'artist',
        'album',
        'img',
        'info',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
