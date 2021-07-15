<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopicConversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'team_id', 'topic_id', 'message', 'file_id'
    ];

    public function createdBy(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
