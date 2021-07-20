<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SentFile extends Model {

    public function file() {
        return $this->belongsTo(File::class, 'file_id', 'id');
    }

    public function channel() {
        return $this->belongsTo(PrivateChannel::class, 'channel_id', 'id');
    }

}