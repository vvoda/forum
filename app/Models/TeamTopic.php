<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamTopic extends Model {

    public function topic() {
        return $this->belongsTo(Topic::class);
    }

    public function team() {
        return $this->belongsTo(Team::class);
    }

}