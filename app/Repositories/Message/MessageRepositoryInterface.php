<?php

namespace App\Repositories\Message;

interface MessageRepositoryInterface {
    public function addPrivateMessage($sender, $receiver, $message);
    public function addTeamMessage($sender, $team, $topic, $message);
}   