<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Debate;
use App\Models\Response;
use App\Repositories\QuestionRepository;
use App\Repositories\ResponseRepository;
use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $questionRepository;
    private $responseRepository;

    public function __construct(QuestionRepository $questionRepository, ResponseRepository $responseRepository)
    {
        $this->questionRepository = $questionRepository;
        $this->responseRepository = $responseRepository;
    }

    public function welcome()
    {
        $actions_count = Action::count();
        $users_count = User::count();
        $question = $this->questionRepository->randomQuestion();
        $next_response = $this->responseRepository->randomResponse($question);
        return view('welcome', compact('actions_count', 'users_count', 'next_response'));
    }

    public function data()
    {
        return view('data');
    }

    public function download()
    {
        return response()->download(storage_path("app/public/actions" . date("Ymd") . ".csv"));
    }

    public function faq()
    {
        return view('faq');
    }

    public function legal()
    {
        return view('legal');
    }

    public function index(Request $request)
    {
        $debates = Debate::orderBy('id')->get();
        $my_scores = [];
        if ($request->user() != null) {
            $user_id = $request->user()->id;
            foreach ($debates as $debate) {
                $my_scores[$debate->id] = Response::whereHas('actions', function ($query) use ($user_id) {
                    $query->where('user_id', $user_id);
                })->join('questions', 'questions.id', 'responses.question_id')
                    ->where('questions.debate_id', $debate->id)
                    ->count();
            }
        }
        $question = $this->questionRepository->randomQuestion();
        $next_response = $this->responseRepository->randomResponse($question);
        return view('home', compact('debates', 'my_scores', 'next_response'));
    }
}
