<?php

namespace App\Repositories\Topic;

use App\Models\Team;
use App\Models\Topic;
use App\Models\TopicConversation;
use App\Models\TopicFile;
use App\Repositories\File\FileRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class TopicRepository implements TopicRepositoryInterface {
    
    protected $topic, $team, $topic_file, $fileRepository, $message;

    public function __construct(Topic $topic, Team $team, TopicFile $topic_file, TopicConversation $message) {
        $this->topic = $topic;
        $this->team = $team;
        $this->topic_file = $topic_file;
        $this->fileRepository = app()->make(FileRepositoryInterface::class);
        $this->message = $message;
    }

    public function getTopic($id) {
        return $this->topic->find($id);
    }

    public function getTopics($team_id) {
        return $this->topic->where('team_id', $team_id)->get();
    }

    public function createTopic($request) {
        $request->validate([
            'title' => 'required|string',
            'description' => 'string',
            'team_id' => 'required|integer'
        ]);

        if(count($this->topic->where('title', $request->title)->where('team_id', $request->team_id)->get())) {
            return response()->json(['error' => 'Topic already exists.']);
        }

        $topic = new Topic();
        $topic->title = $request->title;
        $topic->team_id = $request->team_id;
        $topic->user_id = $request->user()->id;
        if (isset($request->description)) {
            $topic->description = $request->description;
        }
        $topic->save();

        return Inertia::render('Home', [
            'currentTopics' => Topic::where('team_id', $request->team_id)->with('createdBy')->orderBy('created_at', 'DESC')->get(),
            'rightSide' => 'groups'
        ]);
    }

    public function storeTopicConversation($request) {
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
             ])->with('file')->with('createdBy')->orderBy('created_at', 'ASC')->get(),
             'middleSection' => $request->topicId ? 'topic-conversations' : 'topics',
         ]);
    }

    public function storeTopicFileConversation($request) {
        $file = $this->fileRepository->upload($request->file('file'));
        if(!$file) {
            return response()->json(['error' => 'File could not be uploaded'], 500);
        }
        $message = new TopicConversation();
        $message->user_id = $request->user()->id;
        $message->team_id = $request->user()->current_team_id;
        $message->topic_id = $request->topicId;
        $message->file_id = $file->id;
        $message->message = '';
        $message->save();

        return Inertia::render('Home', [
            'currentTopicConversations' => TopicConversation::where([
                ['team_id', $request->user()->current_team_id],
                ['topic_id', $request->topicId]
            ])->with('file')->with('createdBy')->orderBy('created_at', 'ASC')->get(),
            'middleSection' => $request->topicId ? 'topic-conversations' : 'topics',
        ]);
    }

    public function updateTopic($request) {
        $topic = $this->topic->find($request->topic_id);

        $topic->title = $request->title;
        $topic->description = ($request->description) ?? '';

        $topic->save();

        return $topic;
    }

    public function deleteTopic($topic_id, $delete_files = false) {
        $topic = $this->topic->find($topic_id);
        if(!$topic) {
            return false;
        }
        if (count($topic->messages)) {
            foreach($topic->messages as $message) {
                $message->delete();
            }
        }

        if (count($topic->files) && $delete_files) {
            foreach($topic->files as $topic_file) {
                Storage::disk('public')->delete($topic_file->file->filename);
                $topic_file->delete();
            }
        }

        $topic->delete();

        return true;
    }

    public function createTopicFile($file_id, $topic_id) {
        $topicFile = new TopicFile();
        $topicFile->file_id = $file_id;
        $topicFile->topic_id = $topic_id;

        $topicFile->save();
        
    }

    public function deleteTopicFile($topic_file_id) { // tested, works
        $topic_file = $this->topic_file->find($topic_file_id);
        if (!$topic_file) {
            return false;
        }

        Storage::disk('public')->delete($topic_file->file->filename);
        $topic_file->file->delete();
        $topic_file->delete();
        
        return true;
    }

    public function starMessage($message_id) {
        $message = $this->message->find($message_id);
        $message->starred = 1;
        $message->save();

        return $message;
    }

    public function getTopicTeamFiles($team_id) {
        $topic = $this->topic->where('team_id', $team_id)->with('files')->first();
        $files = [];
        if(!$topic) {
            return $files;
        }
        
        
        if(!is_null($topic->files)) {
            foreach($topic->files as $topicfile) {
                $files[] = $topicfile->file;
            }
        }

        return $files;
    }

}