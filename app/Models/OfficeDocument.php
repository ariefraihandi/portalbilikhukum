<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficeDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'office_id',
        'name',
        'file',
        'url',
    ];

    // Relationships
    public function office()
    {
        return $this->belongsTo(Office::class);
    }
}
