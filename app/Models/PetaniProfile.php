<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PetaniProfile extends Model
{
    protected $fillable = [
        'user_id',
        'no_telp',
        'farm_name',
        'location',
        'bio',
        'rating_avg',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
