<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KlienChat extends Model
{
    use HasFactory;

    protected $table = 'klien_chat'; // Pastikan nama tabel benar

    protected $fillable = [
        'name',
        'whatsapp',
        'email',
        'keperluan',
        'id_office',
        'status',
        'budget',
        'new_budget',
        'nomor_perkara ',
        'last_contacted_at',
        'is_followed_up',
        'referrer',
    ];

    protected $casts = [
        'last_contacted_at' => 'datetime',
        'is_followed_up' => 'boolean',
    ];

    // Relasi ke model Office
    public function office()
    {
        return $this->belongsTo(Office::class, 'id_office');
    }

    // Relasi ke model Response
    public function responses()
    {
        return $this->hasMany(Response::class, 'klien_chat_id');
    }

    // Relasi ke model MailingListKlien
    public function mailingListKliens()
    {
        return $this->hasMany(MailingListKlien::class, 'klien_id');
    }
}
