<?php

namespace App\Http\Controllers;

use App\Models\TopicConversation;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TopicConversationController extends Controller
{
    public function store(Request $request): \Inertia\Response {
        $request->validate([
           'message' => 'required|string',
           'topicId' => 'required|integer'
        ]);

        $message = new TopicConversation();
        $message->message = $request->message;
        $message->topic_id = $request->topicId;
        $message->user_id = $request->user()->id;
        $message->team_id = $request->user()->current_team_id;
        $message->save();
        return Inertia::render('Home', [
            'currentTopicConversations' => TopicConversation::where([
                ['team_id', $request->user()->current_team_id],
                ['topic_id', $request->topicId]
            ])->with('createdBy')->orderBy('created_at', 'ASC')->get(),
            'middleSection' => $request->topicId ? 'topic-conversations' : 'topics',
        ]);
    }
}
