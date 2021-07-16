<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\CreateNewUser;
use App\Models\User;
use Illuminate\Http\Request;

class CmsController extends Controller {

    protected $user;
    
    public function __construct(User $user) {
        $this->user = $user;
    }

    public function dashboard() {
        $users = $this->user->where('admin', 0)->get();

        return view('cms.users')->with('users', $users);
    }

    public function create() {
        return view('cms.create-user');
    }

    public function register(Request $request) { // POST
        $user = new CreateNewUser();
        $user->create(["name" => $request->name, "email" => $request->email, "password" => $request->password, "password_confirmation" => $request->password_confirmation, "terms" => false]);
        
        return redirect('/cms')->with('success', 'User created succesfully!');
    }

    public function search(Request $request) {
        if($request->search) {
            $users = $this->user->where('name', 'LIKE', "%$request->search%")->orWhere('email', 'LIKE', "%$request->search%")->get();
        } else {
            $users = [];
        }

        return view('cms.search-results')->with($users);
    }

}
