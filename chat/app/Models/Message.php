<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $fillable = [
        'sender_id',
        'recipient_id',
        'message',
        'image'
    ];

    public function sender()
    {
        return $this->belongsTo('App\Models\User', 'sender_id');
    }

    public function recipient()
    {
        return $this->belongsTo('App\Models\User', 'recipient_id');
    }
}
