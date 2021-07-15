<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamUser extends Model {

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function team() {
        return $this->belongsTo(Team::class);
    }

}