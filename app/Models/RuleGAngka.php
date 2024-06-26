<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RuleGAngka extends Model
{
    use HasFactory;

    protected $fillable = ['rule_f_huruf_id', 'angka_content'];

    public function huruf()
    {
        return $this->belongsTo(RuleFHuruf::class, 'rule_f_huruf_id');
    }
}
