<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MailingList extends Model
{
    protected $fillable = ['user_id', 'email', 'status'];

    // Jika Anda ingin kolom 'status' diisi secara default dengan '0'
    protected $attributes = [
        'status' => 0,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
