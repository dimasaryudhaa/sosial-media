<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', // Pengirim pesan (pengguna yang sedang login)
        'receiver_id', // Penerima pesan
        'message'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function receiver() {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
