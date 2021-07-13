<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SentFile extends Model {

    public function file() {
        return $this->belongsTo(File::class, 'file_id', 'id');
    }

    public function receiver() {
        return $this->belongsTo(User::class, 'receiver_id', 'id');
    }

}