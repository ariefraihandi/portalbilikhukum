<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RuleEAyat extends Model
{
    use HasFactory;

    protected $fillable = ['rule_d_pasal_id', 'ayat_content'];

    public function pasal()
    {
        return $this->belongsTo(RuleDPasal::class, 'rule_d_pasal_id');
    }

    public function hurufs()
    {
        return $this->hasMany(RuleFHuruf::class, 'rule_e_ayat_id');
    }
}
