<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Debate;
use App\Repositories\QuestionRepository;
use App\Repositories\ResponseRepository;
use App\User;
use Illuminate\Http\Request;
use App\Logic\Levels;

class HomeController extends Controller
{
    private $questionRepository;

    public function __construct(QuestionRepository $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }

    public function welcome()
    {
        $actions_count = Action::count();
        $users_count = User::count();
        $question = $this->questionRepository->randomQuestion();
        return view('welcome', compact('actions_count', 'users_count', 'question'));
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

    public function levels(Request $request)
    {
        $user = $request->user();
        $level = $user == null ? null : $user->level();
        $levels = Levels::levels();
        $question = $this->questionRepository->randomQuestion();
        return view('levels', compact('user', 'level', 'levels', 'question'));
    }

    public function index()
    {
        $debates = Debate::orderBy('id')->get();
        $question = $this->questionRepository->randomQuestion();
        return view('home', compact('debates', 'question'));
    }
}
