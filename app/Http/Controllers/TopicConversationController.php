<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\File;
use App\Models\Topic;
use App\Models\TopicConversation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TopicConversationController extends Controller
{
    public function store(Request $request): \Inertia\Response {
        $request->validate([
           'message' => 'string',
           'topicId' => 'required|integer'
        ]);


        $file = NULL;
        if ($request->file('file')) {
            $filename = basename($request->file('file')->store('public'));
            $originalFilename = $request->file('file')->getClientOriginalName();
            $fileSize = $request->file('file')->getSize();
            $ext = $request->file('file')->getClientOriginalExtension();

            $file = new File;
            $file->user_id = request()->user()->id;
            $file->filename = $filename;
            $file->original_filename = $originalFilename;
            $file->size = $fileSize;
            $file->team_id = $request->user()->current_team_id;
            $file->extension = $ext;
            $file->save();
        }

        $message = new TopicConversation();

        if (isset($request->message)) {
            $message->message = $request->message;
        };

        $message->topic_id = $request->topicId;
        $message->user_id = $request->user()->id;
        $message->team_id = $request->user()->current_team_id;

        if ($file) {
            $message->file_id = $file->id;
        }

        $message->save();
        return Inertia::render('Home', [
            'currentTopicConversations' => TopicConversation::where([
                ['team_id', $request->user()->current_team_id],
                ['topic_id', $request->topicId]
            ])->with(['createdBy', 'file'])->orderBy('created_at', 'ASC')->get(),
            'middleSection' => 'topic-conversations',
            'contacts' => Contact::where('user_id', $request->user()->id)->orWhere('friend_id', $request->user()->id)->with(['friend', 'user'])->get(),
            'currentTopics' => Topic::where('team_id', $request->user()->current_team_id)->with('createdBy')->orderBy('created_at', 'DESC')->get()
        ]);
    }
}
