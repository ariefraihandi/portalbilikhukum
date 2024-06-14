<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    use HasFactory;

    protected $table = 'tagihan';

    protected $fillable = [
        'user_id',
        'amount',
        'note',
        'status',
        'payment_method',
        'due_date',
        'paid_date',
        'reference_id',
        'transaction_id',
        'invoice_number',
        'currency'
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
