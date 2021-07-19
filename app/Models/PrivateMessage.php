<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrivateMessage extends Model {

    protected $fillable = ['message'];

    public function sender() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function receiver() {
        return $this->belongsTo(User::class, 'receiver_id', 'id');
    }

}
