<?php

namespace App\Http\Controllers;

use App\Models\PrivateChannel;
use App\Models\PrivateMessage;
use App\Repositories\File\FileRepositoryInterface;
use App\Repositories\Message\MessageRepositoryInterface;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PrivateMessagesController extends Controller {
    
    protected $file, $message;

    public function __construct(FileRepositoryInterface $file, MessageRepositoryInterface $message) {     
        $this->file = $file;
        $this->message = $message;
    }

    public function store(Request $request): \Inertia\Response {
        $request->validate([
            'message' => 'required|string',
            'channelId' => 'required|integer'
         ]);
 
         $message = new PrivateMessage();
         $message->message = $request->message;
         $message->channel_id = $request->channelId;
         $message->user_id = $request->user()->id;
         $message->save();
         return Inertia::render('Home', [
             'currentConversation' => PrivateMessage::where([
                 ['user_id', $request->user()->id],
                 ['channel_id', $request->channelId]
             ])->with('createdBy')->orderBy('created_at', 'ASC')->get(),
             'middleSection' => $request->topicId ? 'topic-conversations' : 'topics', //  ** ? **
         ]);
    }

    public function addFile(Request $request) { //tested, works
        $validation = Validator::make($request->all(), ['file' => 'required|mimes:doc,docx,pdf,xlsx,xlx,csv|max:60000']);
        if (!$validation) {
            return back()->with('error', 'File could not be uploaded');
        }
        $file = $this->file->upload($request->file('file'));

        $this->message->sendPrivateFile($file->id, $request->channel_id, $request->user()->id);

        return $file;
    }

    public function getChannelFiles(Request $request) {
        $channel = PrivateChannel::find($request->channel_id);
        $files = [];

        if(count($channel->files)) {
            foreach ($channel->files as $sentFile) {
                $files[] = $sentFile->file->filename; 
            }
        }

        return $files;
    }

    public function starMessage(Request $request) { 
        return $this->message->starChannelMessage($request->channel_id, $request->file_id);
    }

}