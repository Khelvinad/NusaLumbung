<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PembeliProfile extends Model
{
    protected $fillable = [
        'user_id',
        'no_telp',
        'address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
