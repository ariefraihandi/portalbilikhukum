<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfficeMember extends Model
{
    protected $fillable = [
        'id_user', 'id_office', 'level'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function office()
    {
        return $this->belongsTo(Office::class, 'id_office');
    }
}
