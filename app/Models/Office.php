<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_kantor',
        'email_kantor',
        'hp_whatsapp',
        'tanggal_pendirian',
        'alamat',
        'kode_pos',
        'provinsi',
        'kabupaten_kota',
        'kecamatan',
        'desa',
        'website',
        'slogan',
        'logo',
        'cover',
        'agreement',
        'referedby',
        'type',
        'status',
    ];

    protected $casts = [
        'tanggal_pendirian' => 'date',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function village()
    {
        return $this->belongsTo(Village::class, 'desa', 'code');
    }
    
    public function district()
    {
        return $this->belongsTo(District::class, 'kecamatan', 'code');
    }

    public function regency()
    {
        return $this->belongsTo(Regency::class, 'kabupaten_kota', 'code');
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'provinsi', 'code');
    }

    public function documents()
    {
        return $this->hasMany(OfficeDocument::class);
    }

    public function klienChats()
    {
        return $this->hasMany(KlienChat::class, 'id_office');
    }

    public function legalCases()
    {
        return $this->belongsToMany(LegalCase::class, 'office_cases')
                    ->withPivot('min_fee', 'max_fee')
                    ->withTimestamps();
    }

    public function officeVerificationList()
    {
        return $this->hasOne(OfficeVerificationList::class);
    }

    public function officeCases()
    {
        return $this->hasMany(OfficeCase::class);
    }
}
