<?php

namespace App\Repositories\Message;

use App\Models\PrivateMessage;
use App\Models\TeamMessage;

class MessageRepository implements MessageRepositoryInterface {

    protected $pm, $tm;

    public function __construct(PrivateMessage $pm, TeamMessage $tm) {
        $this->pm = $pm;
        $this->tm = $tm;
    }

    public function addPrivateMessage($sender, $receiver, $message) {
        $message = new PrivateMessage();

        $message->user_id = $sender;
        $message->receiver_id = $receiver;
        $message->message = $message;

        $message->save();

        return $message;
    }

    public function addTeamMessage($sender, $team, $topic, $message) {
        $message = new TeamMessage();

        $message->user_id = $sender;
        $message->team_id = $team;
        $message->topic_id = $topic;
        $message->message = $message;

        $message->save();

        return $message();
    }
    
}