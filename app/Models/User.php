<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable, HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'whatsapp',
        'password',
        'address',
        'image',
        'role',
        'dob',
        'gender',
        'referedby',
        'email_verified_at',
        'verified',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'dob' => 'date',
        'email_verified_at' => 'datetime',
        'verified' => 'boolean',
    ];

    /**
     * Relasi untuk mengambil kode referral yang dimiliki pengguna
     */
    public function referralCode()
    {
        return $this->hasOne(RefferalCode::class, 'user_id', 'id');
    }

    /**
     * Relasi untuk pengguna yang menggunakan kode referral
     */
    public function referrals()
    {
        return $this->hasMany(User::class, 'referedby', 'id');
    }

    /**
     * Relasi untuk pengguna yang merujuk pengguna ini berdasarkan kode referral
     */
    public function referredByUser()
    {
        return $this->belongsTo(User::class, 'referedby', 'id');
    }

    /**
     * Metode untuk kapitalisasi kata
     */
    public function capitalizeWords($string)
    {
        return ucwords(strtolower($string));
    }

    /**
     * Metode untuk menguraikan kode alamat menjadi bagian-bagian
     */
    public function getAddressParts()
    {
        $code = $this->address;
        $parts = explode('.', $code);

        $provinceCode = isset($parts[0]) ? $parts[0] : null;
        $regencyCode = isset($parts[1]) ? "{$parts[0]}.{$parts[1]}" : null;
        $districtCode = isset($parts[2]) ? "{$parts[0]}.{$parts[1]}.{$parts[2]}" : null;
        $villageCode = isset($parts[3]) ? "{$parts[0]}.{$parts[1]}.{$parts[2]}.{$parts[3]}" : null;

        return [
            'province' => $provinceCode ? Province::where('code', $provinceCode)->first() : null,
            'regency' => $regencyCode ? Regency::where('code', $regencyCode)->first() : null,
            'district' => $districtCode ? District::where('code', $districtCode)->first() : null,
            'village' => $villageCode ? Village::where('code', $villageCode)->first() : null,
        ];
    }
}
