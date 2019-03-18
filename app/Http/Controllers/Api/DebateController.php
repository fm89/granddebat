<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\Debate;
use App\Repositories\QuestionRepository;

class DebateController extends Controller
{
    private $questionRepository;

    public function __construct(QuestionRepository $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }

    public function show(Debate $debate)
    {
        $questions = $this->questionRepository->listOfDebate($debate->id);
        return compact('questions');
    }
}
