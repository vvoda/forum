<?php

namespace App\Http\Controllers;

use App\Models\TopicConversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use App\Models\Topic;
use App\Models\TopicFile;
use App\Models\User;
use App\Repositories\File\FileRepositoryInterface;
use App\Repositories\Topic\TopicRepositoryInterface;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class HomeController extends Controller {

    protected $file, $topic;

    public function __construct(FileRepositoryInterface $file, TopicRepositoryInterface $topic) {
        $this->file = $file;
        $this->topic = $topic;
    }

    public function index(Request $request): \Inertia\Response {
        $result = [];
        $response = [];
        $findUsers = [];
        $currentRightSide = 'groups';
        $rightSideComponent = 'group';
        if (isset($request->fc)) {
            $result = User::where('email', 'LIKE', "%$request->fc%")->orWhere('name', 'LIKE', "%$request->fc%")->get();
            $currentRightSide = 'add-contact';
        }

        if (isset($request->topicId)) {
            $response = TopicConversation::where([
                ['team_id', $request->user()->current_team_id],
                ['topic_id', $request->topicId]
            ])->with('file')->with('createdBy')->orderBy('created_at', 'ASC')->get();
        }

        if (isset($request->fu)) {
            $findUsers = User::where('email', 'LIKE', "%$request->fu%")->orWhere('name', 'LIKE', "%$request->fu%")->get();
            $rightSideComponent = 'invite-to-group';
        }

        return Inertia::render('Home', [
            'findContacts' => $result,
            'rightSide' => $currentRightSide,
            'currentTopics' => Topic::where('team_id', $request->user()->current_team_id)->with('createdBy')->orderBy('created_at', 'DESC')->get(),
            'currentTopicConversations' => $response,
            'middleSection' => $request->topicId ? 'topic-conversations' : 'topics',
            'findUsers' => $findUsers,
            'rightSideComponent' => $rightSideComponent,
            'groupFiles' => $this->topic->getTopicTeamFiles($request->user()->current_team_id)
        ]);
    }

    public function download() {
        $filename = request()->route('filename');
        $file = $this->file->getByFileName($filename);

        $path = storage_path('app/public') . '/' . $filename;
        $mimetype = mime_content_type($path);
        if ($mimetype=='application/pdf') {
            return response()->file($path, ['Content-Disposition' => 'inline; filename="'.$file->original_filename.'"']);
        } else { 
            return response()->download($path, $file->original_filename);
        }
    }

}