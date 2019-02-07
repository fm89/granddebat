<?php

namespace App\Http\Controllers;

use App\Models\Debate;
use App\Models\Response;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $debates = Debate::orderBy('id')->get();
        $my_scores = [];
        $scores = [];
        $user_id = $request->user()->id;
        foreach ($debates as $debate) {
            $my_scores[$debate->id] = Response::whereHas('actions', function ($query) use ($user_id) {
                $query->where('user_id', $user_id);
            })->join('questions', 'questions.id', 'responses.question_id')
                ->where('questions.debate_id', $debate->id)
                ->count();
            $scores[$debate->id] = Response::whereHas('actions')
                ->join('questions', 'questions.id', 'responses.question_id')
                ->where('questions.debate_id', $debate->id)
                ->count();
        }
        return view('home', compact('debates', 'scores', 'my_scores'));
    }
}
