<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfficeVerificationList extends Model
{
    protected $fillable = [
        'user_id', 'office_id', 'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function office()
    {
        return $this->belongsTo(Office::class);
    }
}
