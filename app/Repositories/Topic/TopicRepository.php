<?php

namespace App\Repositories\Topic;

use App\Models\Team;
use App\Models\Topic;
use App\Models\TopicFile;
use Carbon\Carbon;
// use Illuminate\Support\Facades\DB;

class TopicRepository implements TopicRepositoryInterface {
    
    protected $topic, $team, $topic_file;

    public function __construct(Topic $topic, Team $team, TopicFile $topic_file) {
        $this->topic = $topic;
        $this->team = $team;
        $this->topic_file = $topic_file;
    }

    public function getTopic($id) {
        return $this->topic->find($id);
    }

    public function getTopics($team_id) {
        return $this->topic->where('team_id', $team_id)->get();
    }

    public function createTopic($request) {
        $validation = $request->validate([
            'title' => 'required|max:255'
        ]);

        if(!$validation) {
            return false;
        }

        if(count($this->topic->where('title', $request->title)->get())) {
            return response()->json(['error' => 'Topic already exists.']);
        }

        $topic = new Topic();
        $topic->user_id = $request->user_id;
        $topic->team_id = $request->team_id;
        $topic->title = $request->title; 
        $topic->description = ($request->description) ?? '';
        $topic->save();

        return $topic;
    }

    public function updateTopic($request) {
        $topic = $this->topic->find($request->topic_id);

        $topic->title = $request->title;
        $topic->description = ($request->description) ?? '';

        $topic->save();

        return $topic;
    }

    public function deleteTopic($request) {
        $topic = $this->topic->find($request->topic_id);
        if(!$topic) {
            return false;
        }
        if (count($topic->messages)) {
            foreach($topic->messages as $message) {
                $message->delete();
            }
        }

        $topic->delete();

        return true;
    }

    public function deleteFile($topic, $file_id) {
        $topic = $this->topic->find($topic);
        $topic_file = $this->topic_file->where('topic_id', $topic)->where('file_id', $file_id)->first();
        $topic_file->file->delete();
        $topic_file->delete();

        return true;
    }

}