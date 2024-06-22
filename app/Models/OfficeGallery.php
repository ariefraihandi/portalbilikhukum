<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficeGallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'short_title',
        'title',
        'description',
        'image_file',
        'office_id',
    ];
}
