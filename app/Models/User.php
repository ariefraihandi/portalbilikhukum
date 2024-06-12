<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use Notifiable, HasFactory, SoftDeletes;

    protected $table = 'users';

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

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'dob' => 'date',
        'email_verified_at' => 'datetime',
        'verified' => 'boolean',
    ];

    public function referralCode()
    {
        return $this->hasOne(RefferalCode::class, 'user_id', 'id');
    }

    public function referrals()
    {
        return $this->hasMany(User::class, 'referedby', 'id');
    }

    public function referredByUser()
    {
        return $this->belongsTo(User::class, 'referedby', 'id');
    }

    public function capitalizeWords($string)
    {
        return ucwords(strtolower($string));
    }

    public function getAddressParts()
    {
        $code = $this->address;
        $parts = explode('.', $code);

        return [
            'province' => isset($parts[0]) ? Province::where('code', $parts[0])->first() : null,
            'regency' => isset($parts[1]) ? Regency::where('code', "{$parts[0]}.{$parts[1]}")->first() : null,
            'district' => isset($parts[2]) ? District::where('code', "{$parts[0]}.{$parts[1]}.{$parts[2]}")->first() : null,
            'village' => isset($parts[3]) ? Village::where('code', "{$parts[0]}.{$parts[1]}.{$parts[2]}.{$parts[3]}")->first() : null,
        ];
    }

    public function getReferralCountAttribute()
    {
        $referralCode = $this->referralCode;
        if ($referralCode) {
            return User::where('referedby', $referralCode->code)->count();
        }
        return 0;
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($user) {
            // Delete image file from storage if it's not the default image
            if ($user->image && $user->image !== 'default.webp') {
                $imagePath = public_path('assets/img/member/' . $user->image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            // Delete related referral code
            if ($user->referralCode) {
                $user->referralCode->delete();
            }

            // Delete referrals
            foreach ($user->referrals as $referral) {
                $referral->delete();
            }
        });
    }

}
