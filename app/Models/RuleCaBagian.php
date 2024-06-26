<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RuleCaBagian extends Model
{
    use HasFactory;

    protected $table = 'rule_ca_bagian';

    protected $fillable = [
        'rule_b_undang_id',
        'id_bab',
        'bagian_name',
        'bagian_ke',
    ];

    // Relasi ke RuleBUndang (optional, sesuaikan dengan kebutuhan aplikasi Anda)
    public function ruleBUndang()
    {
        return $this->belongsTo(RuleBUndang::class, 'rule_b_undang_id');
    }

    // Relasi ke RuleCBab (optional, sesuaikan dengan kebutuhan aplikasi Anda)
    public function ruleCBab()
    {
        return $this->belongsTo(RuleCBab::class, 'id_bab');
    }
}

