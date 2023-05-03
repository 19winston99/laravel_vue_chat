<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = ['first_user_id', 'second_user_id'];

    public function first_user() {
        return $this->belongsToMany('App\Models\User', 'first_user_id');
    }

    public function second_user() {
        return $this->belongsToMany('App\Models\User', 'second_user_id');
    }

    public function messages() {
        return $this->hasMany('App\Models\Message', 'id');
    }
}
