<?php

namespace App\Http\Controllers;


use App\Models\Question;
use App\Repositories\ResponseRepository;
use App\Repositories\TagRepository;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    private $responseRepository;
    private $tagRepository;

    public function __construct(ResponseRepository $responseRepository, TagRepository $tagRepository)
    {
        $this->responseRepository = $responseRepository;
        $this->tagRepository = $tagRepository;
    }

    public function show(Request $request, Question $question)
    {
        if (!$question->is_free) {
            return redirect('/debates/' . $question->debate_id);
        }
        $user = $request->user();
        $tags = $this->tagRepository->getTagsForQuestionUser($question, $user);
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
