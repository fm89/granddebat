<?php

namespace App\Http\Controllers;

use App\Models\Debate;
use App\Repositories\QuestionRepository;
use Illuminate\Http\Request;

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
        return view('debates.show', compact('debate', 'user'));
    }

    public function random(Request $request, Debate $debate)
    {
        $question = $this->questionRepository->randomQuestion($request->user(), $debate);
        return redirect('/questions/' . $question->id . '/read');
    }
}
