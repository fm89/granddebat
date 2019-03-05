<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Debate;
use App\Models\Response;
use App\Repositories\QuestionRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DebateController extends Controller
{
    private $questionRepository;

    public function __construct(QuestionRepository $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }

    public function show(Request $request, Debate $debate)
    {
        $user = $request->user();
        $progress = [];
        foreach ($debate->questions as $question) {
            # Show progress with respect to target goal of 10% reading
            $progress[$question->id] = min(100, ceil(1000 - $question->priority));
        }
        return view('debates.show', compact('debate', 'user', 'progress'));
    }

    public function random(Request $request, Debate $debate)
    {
        $question = $this->questionRepository->randomQuestion($request->user(), $debate);
        return redirect('/questions/' . $question->id . '/read');
    }
}
