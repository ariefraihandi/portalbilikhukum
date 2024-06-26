<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RuleCBab extends Model
{
    use HasFactory;

    protected $table = 'rule_c_bab';

    protected $fillable = [
        'rule_b_undang_id',
        'bab_ke',
        'bab_name',
    ];

    // Relasi ke tabel RuleBUndang
    public function ruleBUndang()
    {
        return $this->belongsTo(RuleBUndang::class, 'rule_b_undang_id');
    }

    // Define the pasals relationship
    public function pasals()
    {
        return $this->hasMany(RuleDPasal::class, 'rule_c_bab_id', 'id');
    }
}
