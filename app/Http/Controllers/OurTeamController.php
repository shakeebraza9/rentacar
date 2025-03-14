<?php

namespace App\Http\Controllers;
use App\Models\OurTeam;

class OurTeamController extends Controller
{
    public function index(){
        $members = OurTeam::with('image')->get();
        return view('theme.our-team', compact('members'));
    }
}