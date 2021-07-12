<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TopicFile extends Model {

    public function file() {
        return $this->belongsTo(File::class);
    }

    public function topic() {
        return $this->belongsTo(Topic::class);
    }

}