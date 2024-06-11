<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficeCase extends Model
{
    use HasFactory;

    protected $fillable = [
        'legal_case_id',
        'office_id',
        'min_fee',
        'max_fee',
    ];

    // Define relationships
    public function legalCase()
    {
        return $this->belongsTo(LegalCase::class);
    }

    public function office()
    {
        return $this->belongsTo(Office::class);
    }
}
