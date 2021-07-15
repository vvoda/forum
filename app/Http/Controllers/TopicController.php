<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TopicController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'string',
            'team_id' => 'required|integer'
        ]);

        $newTopic = new Topic();
        $newTopic->title = $request->title;
        $newTopic->team_id = $request->team_id;
        $newTopic->user_id = $request->user()->id;
        if (isset($request->description)) {
            $newTopic->description = $request->description;
        }
        $newTopic->save();
        return Inertia::render('Home', [
            'currentTopics' => Topic::where('team_id', $request->team_id)->with('createdBy')->orderBy('created_at', 'DESC')->get(),
            'rightSide' => 'groups'
        ]);
    }
}
