<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Repositories\TagRepository;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    private $tagRepository;

    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    public function tags(Request $request, Question $question)
    {
        return $this->tagRepository->getJsonTagsForQuestionUser($question, $request->user());
    }
}
