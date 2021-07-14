<?php

namespace App\Http\Controllers;

use App\Repositories\File\FileRepositoryInterface;
use App\Repositories\Message\MessageRepositoryInterface;
use App\Repositories\Topic\TopicRepositoryInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TopicsController extends Controller {
    
    protected $topic, $file, $message;

    public function __construct(TopicRepositoryInterface $topic, FileRepositoryInterface $file, MessageRepositoryInterface $message) {
        $this->topic = $topic;        
        $this->file = $file;
        $this->message = $message;
    }

    public function show(Request $request) {
        $topics = $this->topic->getTopics($request->team_id);

        return Inertia::render('Topics', $topics);
    }

    public function createTopic(Request $request) {
        return $this->topic->createTopic($request);
    }

    public function addTopicFile(Request $request) {
        $request->validate([
            'file' => 'required|mimes:doc,docx,pdf,xlsx,xlx,csv|max:60000',
        ]);

        $file =  $this->file->upload($request->file('file'));

        $this->topic->createTopicFile($file->id, $request->topic_id);

        return true;
    }

    public function deleteTopicFile(Request $request) {
        $file = $this->file->getByFilename($request->filename);

        return $this->topic->deleteTopicFile($file->id, $request->topic_id);
    }

    public function deleteTopic(Request $request) {
        return $this->topic->deleteTopic($request);
    }

    public function updateTopic(Request $request) {
        return $this->topic->updateTopic($request);
    }

    public function sendTeamMessage(Request $request) {
        return $this->message->addTeamMessage($request->session()->user->id, $request->team_id, $request->topic_id, $request->message);
    }

    public function getTopicFiles(Request $request) {
        $topic = $this->topic->getTopic($request->topic_id);
        $files = [];

        if(count($topic->files)) {
            foreach ($topic->files as $topicFile) {
                $files[] = $topicFile->file; 
            }
        }

        return $files;
    }

}