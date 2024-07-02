<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailingListKlien extends Model
{
    use HasFactory;

    protected $table = 'mailing_lists_klien'; // Pastikan nama tabel benar jika diperlukan

    protected $fillable = [
        'email',
        'status',
    ];

    // Relasi ke model KlienChat dihapus karena klien_id tidak ada lagi
}
