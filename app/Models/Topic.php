<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Topic extends Model {

    public function createdBy(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function team() {
        return $this->belongsTo(Team::class);
    }

    public function messages() {
        return $this->hasMany(TeamMessage::class, 'topic_id', 'id');
    }

    public function files() {
        return $this->hasMany(TopicFile::class, 'topic_id', 'id');
    }

}

