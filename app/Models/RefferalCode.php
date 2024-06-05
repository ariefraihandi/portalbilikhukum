<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class RefferalCode extends Model
{
    protected $table = 'refferalcode';

    protected $fillable = [
        'user_id',
        'code',
        'agreed',
        'valid',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
