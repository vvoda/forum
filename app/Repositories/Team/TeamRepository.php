<?php

namespace App\Repositories\Team;

use App\Models\Team;
use App\Models\Topic;
use Carbon\Carbon;
// use Illuminate\Support\Facades\DB;

class TeamRepository implements TeamRepositoryInterface {

    protected $team, $topic;

    public function __construct(Team $team, Topic $topic) {
        $this->team = $team;
        $this->topic = $topic;
    }

    /*public function createTeam($request) {
        $validation = $request->validate(['title' => 'required|max:255']);

        if(!$validation) {
            return false;
        }

        if(count($this->team->where('user_id', $request->user_id)->where('name', $request->name)->get()->first())) {
            return response()->json(['error' => 'Group already exists.'], 400);
        }

        $team = new Team();

        $team->user_id = $request->user_id;
        $team->name = $request->name;
        $team->save();

        return $team;
    }

    public function deleteTeam($request) {

    } */

}