<?php

namespace App\Http\Controllers;


use App\Models\Question;
use App\Repositories\ResponseRepository;

class QuestionController extends Controller
{
    private $responseRepository;

    public function __construct(ResponseRepository $responseRepository)
    {
        $this->responseRepository = $responseRepository;
    }

    public function show(Question $question)
    {
        if (!$question->is_free) {
            return redirect('/debates/' . $question->debate_id);
        }
        $tags = $question->tags()->orderBy('name')->get();
        $current = $question->score();
        $max = $question->responses()->count();
        $next_response = $this->responseRepository->randomResponse($question);
        return view('questions.show', compact('question', 'tags', 'current', 'max', 'next_response'));
    }

    public function read(Question $question)
    {
        if (!$question->is_free) {
            return redirect('/debates/' . $question->debate_id);
        }
        $response = $this->responseRepository->randomResponse($question);
        return redirect('/responses/' . $response->id);
    }
}
