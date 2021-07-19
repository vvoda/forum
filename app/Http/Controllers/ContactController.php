<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\PrivateMessage;
use Inertia\Inertia;

class ContactController extends Controller
{
    public function store(Request $request): \Inertia\Response
    {
        $request->validate([
           'friend_id' => 'required|integer'
        ]);
        Contact::create([
           'user_id' => $request->user()->id,
           'friend_id' => $request->friend_id,
           'accepted' => false
        ]);

        return Inertia::render('Home', [
            'contacts' => Contact::where([
                ['user_id', $request->user()->id]
            ])->with('friend')->get()
        ]);
    }
}
