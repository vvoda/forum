<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupTopic extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id', 'topic_id'
    ];
}
