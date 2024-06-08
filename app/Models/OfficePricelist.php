<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficePricelist extends Model
{
    use HasFactory;

    protected $fillable = [
        'office_id',
        'name',
        'price_1',
        'price_2',
    ];

    // Relationships
    public function office()
    {
        return $this->belongsTo(Office::class);
    }
};