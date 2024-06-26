<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RuleDPasal extends Model
{
    use HasFactory;

    protected $fillable = ['rule_c_bab_id', 'pasal_content', 'rule_ca_bagian_id', 'pasal_ke'];

    public function bab()
    {
        return $this->belongsTo(RuleCBab::class, 'rule_c_bab_id');
    }

    public function ayats()
    {
        return $this->hasMany(RuleEAyat::class, 'rule_d_pasal_id');
    }

    public function bagian()
    {
        return $this->belongsTo(RuleCaBagian::class, 'rule_ca_bagian_id');
    }
}
