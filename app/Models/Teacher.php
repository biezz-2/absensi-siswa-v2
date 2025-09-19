<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        'user_id',
        'nip',
        'gender',
        'phone_number',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}