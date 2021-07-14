<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model {

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function team() {
        return $this->belongsTo(Team::class);
    }

    public function topic() {
        return $this->belongsTo(Topic::class);
    }

    public function messages() {
        return $this->hasMany(TeamMessage::class, 'topic_id', 'id');
    }

    public function files() {
        return $this->hasMany(TopicFile::class, 'topic_id', 'id');
    }

}