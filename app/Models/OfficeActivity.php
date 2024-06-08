<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficeActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'office_id', 'name', 'description', 'badge', 'status',
    ];

    public function office()
    {
        return $this->belongsTo(Office::class);
    }
}
