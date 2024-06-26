<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RuleFHuruf extends Model
{
    use HasFactory;

    protected $fillable = ['rule_e_ayat_id', 'huruf_content'];

    public function ayat()
    {
        return $this->belongsTo(RuleEAyat::class, 'rule_e_ayat_id');
    }

    public function angkas()
    {
        return $this->hasMany(RuleGAngka::class, 'rule_f_huruf_id');
    }
}
