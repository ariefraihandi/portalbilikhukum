<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficeSite extends Model
{
    use HasFactory;

    protected $table = 'office_site';

    protected $fillable = [
        'office_id',
        'office_name',
        'logo_image',
        'owner_image',
        'owner_sec_image',
        'icon_image',
        'tagline',     
        'aboutMe_title',
        'aboutMe_description',
        'aboutMe_legalcategory',
    ];

    protected $casts = [
        'aboutMe_legalcategory' => 'array',
    ];

    public function office()
    {
        return $this->belongsTo(Office::class);
    }
}
