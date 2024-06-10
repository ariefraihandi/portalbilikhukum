<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'klien_chat_id',
        'office_id',
        'question_1',
        'question_2',
        'question_3',
        'question_4',
        'question_5',
        'question_6',
    ];

    // Relasi ke model Client
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // Relasi ke model KlienChat
    public function klienChat()
    {
        return $this->belongsTo(KlienChat::class);
    }

    // Relasi ke model Office
    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    public function responses()
    {
        return $this->hasMany(Response::class, 'office_id');
    }
}