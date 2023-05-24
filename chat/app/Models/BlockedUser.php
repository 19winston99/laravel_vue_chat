<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlockedUser extends Model
{
    use HasFactory;

    protected $fillable = ['blocking_user_id', 'blocked_user_id'];

    public function blocking_user() {
        return $this->belongsTo('App\Models\User', 'blocking_user_id');
    }

    public function blocked_user() {
        return $this->belongsTo('App\Models\User', 'blocked_user_id');
    }
}
