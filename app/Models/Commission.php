<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    use HasFactory;

    protected $fillable = [
        'referral_id',
        'note',
        'type',
        'commission_amount',
        'reference_id',        
    ];

    public function referral()
    {
        return $this->belongsTo(RefferalCode::class, 'referral_id');
    }
}
