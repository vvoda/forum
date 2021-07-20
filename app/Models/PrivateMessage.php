<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrivateMessage extends Model {

    protected $fillable = ['message'];

    public function channel() {
        return $this->belongsTo(PrivateChannel::class, 'channel_id', 'id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function file() {
        return $this->belongsTo(File::class);
    }

}
