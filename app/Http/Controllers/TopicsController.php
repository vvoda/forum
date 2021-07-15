<?php

namespace App\Http\Controllers;

use App\Repositories\File\FileRepositoryInterface;
use App\Repositories\Message\MessageRepositoryInterface;
use App\Repositories\Topic\TopicRepositoryInterface;
use Illuminate\Support\Facades\Validator;
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

    public function store(Request $request) {
        return $this->topic->createTopic($request);
    }

    public function storeTopicConversation(Request $request): \Inertia\Response {
        return $this->topic->storeTopicConversation($request);
    }

    public function storeTopicFileConversation(Request $request): \Inertia\Response {
        return $this->topic->storeTopicFileConversation($request);
    }

    public function addTopicFile(Request $request) { //tested, works
        $validation = Validator::make($request->all(), ['file' => 'required|mimes:doc,docx,pdf,xlsx,xlx,csv|max:60000']);
        if (!$validation) {
            return back()->with('error', 'File could not be uploaded');
        }
        $file = $this->file->upload($request->file('file'));

        $this->topic->createTopicFile($file->id, $request->topic_id);

        return back()->with('success', 'File has been uploaded.');
    }

    public function deleteTopicFile(Request $request) {
        return $this->topic->deleteTopicFile($request->topic_file_id);
    }

    public function deleteTopic(Request $request) {
        return $this->topic->deleteTopic($request->topic_id, false); // true if the files needs to be deleted
    }

    public function updateTopic(Request $request) {
        return $this->topic->updateTopic($request);
    }

    public function sendTeamMessage(Request $request) {
        return $this->message->addTopicConversation($request->user()->id, $request->team_id, $request->topic_id, $request->message);
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