<?php

namespace App\Http\Controllers;

use App\Repositories\File\FileRepositoryInterface;
use App\Repositories\Message\MessageRepositoryInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UsersController extends Controller {

    protected $message, $file;

    public function __construct(MessageRepositoryInterface $message, FileRepositoryInterface $file) {
        $this->message = $message;
        $this->file = $file;
    }

    public function dashboard() {
        return Inertia::render('Dashboard');
    }

    public function sendPrivateMessage(Request $request) {
        $validation = $this->request->validate(['message' => 'required']);

        if ($validation) {
            return $this->message->addPrivateMessage($request->user()->id, $request->receiver_id, $request->message);
        } else {
            return response()->json(['error' => 'Message could not be sent.'], 500);
        }

    }

    public function unsendPrivateMessage($message_id) {
        return $this->message->unsendPrivateMessage($message_id);
    }

    public function getFavouriteFiles(Request $request) {
        return $this->file->getFavouriteFiles($request->user()->id);
    }

    public function getTeamFavouriteFiles(Request $request) {
        return $this->file->getTeamFavouriteFiles(1);
    }

//    Csabi
    public function switchConversation(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
           'pm_id' => 'required|integer'
        ]);
        $request->user()->setConversation($request->pm_id);
        return redirect()->back();
    }
}
