<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RuleBUndang extends Model
{
    use HasFactory;

    protected $table = 'rule_b_undang';

    protected $fillable = [
        'type_id',
        'name',
        'nomor',
        'tahun',
        'tentang',
        'menimbang',
        'mengingat',
        'mencabut',
        'menetapkan',
        'persetujuan',
        'bab',
        'tanggal_penetapan',
        'tanggal_pengundangan',
        'tanggal_berlaku',
        'sumber',
    ];

    protected $casts = [
        'tanggal_penetapan' => 'date',
        'tanggal_pengundangan' => 'date',
        'tanggal_berlaku' => 'date',
        'bab' => 'boolean',
        'menimbang' => 'array', // Cast menimbang as array
        'mengingat' => 'array', // Cast mengingat as array
        'menetapkan' => 'array', // Cast menetapkan as array
    ];

    public function ruleAType()
    {
        return $this->belongsTo(RuleAType::class, 'type_id');
    }

    public function babs()
{
    return $this->hasMany(RuleCBab::class, 'rule_b_undang_id', 'id');
}

}
