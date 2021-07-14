<?php

namespace App\Http\Controllers;

use App\Repositories\Message\MessageRepositoryInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UsersController extends Controller {

    protected $message;
    
    public function __construct(MessageRepositoryInterface $message) {
        $this->message = $message;
    }

    public function dashboard() {
        return Inertia::render('Dashboard');
    }

    public function sendPrivateMessage(Request $request) {
        $validation = $this->request->validate(['message' => 'required']);

        if ($validation) {
            return $this->message->addPrivateMessage($request->session()->user->id, $request->receiver_id, $request->message);
        } else {
            return response()->json(['error' => 'Message could not be sent.'], 500);
        }
        
    }

    public function sendTeamMessage(Request $request) {
        $validation = $this->request->validate(['message' => 'required']);

        if ($validation) {
            return $this->message->addTeamMessage($request->session()->user->id, $request->team_id, $request->topic_id, $request->message);
        } else {
            return response()->json(['error' => 'Message could not be sent.'], 500);
        }
    }

    public function unsendPrivateMessage($message_id) {
        return $this->message->unsendPrivateMessage($message_id);
    }

}