<?php

namespace App\Repositories\Message;

use App\Models\PrivateMessage;
use App\Models\PrivateChannel;
use App\Models\SentFile;

class MessageRepository implements MessageRepositoryInterface {

    protected $pm, $channel, $sent_file;

    public function __construct(PrivateMessage $pm, PrivateChannel $channel, SentFile $sent_file) {
        $this->pm = $pm;
        $this->channel = $channel;
        $this->sent_file = $sent_file;
    }

    public function addPrivateMessage($sender, $receiver, $message) {
        $message = new PrivateMessage();

        $message->user_id = $sender;
        $message->receiver_id = $receiver;
        $message->message = $message;

        $message->save();

        return $message;
    }

    public function sendPrivateFile($file_id, $channel_id) {
        $sentFile = new SentFile();
        
        $sentFile->file_id = $file_id;
        $sentFile->channel_id = $channel_id;

        $sentFile->save();

        return $sentFile;
    }

    public function starChannelMessage($channel_id, $file_id) {
        $sentFile = $this->sent_file->where('channel_id', $channel_id)->where('file_id', $file_id)->first();

        if(!$sentFile) {
            return false;
        }

        $sentFile->starred = 1;
        $sentFile->save();

        return true;
    }
    
}