<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // Menentukan nama tabel
    protected $table = 'wp54_posts';

    // Menentukan koneksi database
    protected $connection = 'wordpress';

    // Jika Anda menggunakan timestamps tetapi tabel Anda tidak memiliki kolom created_at dan updated_at
    public $timestamps = false;
}
