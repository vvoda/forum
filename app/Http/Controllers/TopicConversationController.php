<?php

namespace App\Http\Controllers;

use App\Models\TopicConversation;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TopicConversationController extends Controller
{
    public function store(Request $request): \Inertia\Response
    {
        $request->validate([
           'message' => 'required|string',
           'topicId' => 'required|integer'
        ]);

        $newTopicConversation = new TopicConversation();
        $newTopicConversation->message = $request->message;
        $newTopicConversation->topic_id = $request->topicId;
        $newTopicConversation->user_id = $request->user()->id;
        $newTopicConversation->team_id = $request->user()->current_team_id;
        $newTopicConversation->save();
        return Inertia::render('Home', [
            'currentTopicConversations' => TopicConversation::where([
                ['team_id', $request->user()->current_team_id],
                ['topic_id', $request->topicId]
            ])->with('createdBy')->orderBy('created_at', 'ASC')->get(),
            'middleSection' => $request->topicId ? 'topic-conversations' : 'topics',
        ]);
    }
}
