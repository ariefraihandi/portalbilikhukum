<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccessSub extends Model
{
    protected $fillable = [
        'role_id',
        'submenu_id',
    ];

    // Relasi dengan model Role
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    // Relasi dengan model MenuSub
    public function menuSub()
    {
        return $this->belongsTo(MenuSub::class, 'submenu_id');
    }
}
