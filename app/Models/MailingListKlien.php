<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailingListKlien extends Model
{
    use HasFactory;

    protected $table = 'mailing_list_kliens'; // Pastikan nama tabel benar jika diperlukan

    protected $fillable = [
        'klien_id',
        'email',
        'status',
    ];

    // Relasi ke model KlienChat
    public function klien()
    {
        return $this->belongsTo(KlienChat::class, 'klien_id');
    }
}
