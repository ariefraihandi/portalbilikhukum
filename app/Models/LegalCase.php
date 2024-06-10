<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LegalCase extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'kategori',
    ];

    // Relasi ke model Office
    public function offices()
    {
        return $this->belongsToMany(Office::class, 'office_cases')
                    ->withPivot('min_fee', 'max_fee')
                    ->withTimestamps();
    }
}
