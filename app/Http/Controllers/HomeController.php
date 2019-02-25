<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Debate;
use App\Models\Question;
use App\Repositories\QuestionRepository;
use App\Repositories\ResponseRepository;
use App\Repositories\TagRepository;
use App\User;
use Illuminate\Http\Request;
use App\Logic\Levels;
use Illuminate\Support\Facades\Crypt;

class HomeController extends Controller
{
    private $questionRepository;
    private $responseRepository;
    private $tagRepository;

    public function __construct(QuestionRepository $questionRepository, ResponseRepository $responseRepository, TagRepository $tagRepository)
    {
        $this->questionRepository = $questionRepository;
        $this->responseRepository = $responseRepository;
        $this->tagRepository = $tagRepository;
    }

    public function welcome(Request $request)
    {
        $actions_count = Action::count();
        $users_count = User::count();
        $question = Question::find(166);
        $user = $request->user();
        $response = $this->responseRepository->next($question, $user);
        $tags = $this->tagRepository->getJsonTagsForQuestionUser($question, $user);
        $key = Crypt::encrypt(['user_id' => $user->id ?? null, 'response_id' => $response->id]);
        return view('welcome', compact('actions_count', 'users_count', 'question', 'response', 'key', 'tags', 'user'));
    }

    public function random(Request $request)
    {
        $question = $this->questionRepository->randomQuestion($request->user());
        return redirect('/questions/' . $question->id . '/read');
    }

    public function data()
    {
        return view('data');
    }

    public function download()
    {
        return response()->download(storage_path("app/public/actions.zip"));
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
        return view('levels', compact('user', 'level', 'levels'));
    }

    public function index()
    {
        $debates = Debate::orderBy('id')->get();
        return view('home', compact('debates'));
    }
}
