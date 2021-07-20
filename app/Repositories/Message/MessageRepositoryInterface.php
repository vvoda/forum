<?php

namespace App\Repositories\Message;

interface MessageRepositoryInterface {
    public function addPrivateMessage($sender, $receiver, $message);
    public function sendPrivateFile($file_id, $channel_id);
    public function starChannelMessage($channel_id, $file_id);
}   