<?php

namespace App\Http\Controllers;

use App\Logic\Levels;
use App\Models\Action;
use App\Models\Debate;
use App\Repositories\QuestionRepository;
use App\Repositories\ResponseRepository;
use App\Repositories\TagRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    private $questionRepository;
    private $responseRepository;
    private $tagRepository;

    public function __construct(
        QuestionRepository $questionRepository,
        ResponseRepository $responseRepository,
        TagRepository $tagRepository
    ) {
        $this->questionRepository = $questionRepository;
        $this->responseRepository = $responseRepository;
        $this->tagRepository = $tagRepository;
    }

    public function book(Request $request)
    {
        $user = $request->user();
        if ($user == null) {
            $done_count = Action::selectRaw('COUNT(DISTINCT(response_id)) AS "count"')->pluck('count')->all()[0];
            $questions = $this->questionRepository->listOfDebate(1);
            $response = $this->responseRepository->random($questions->first())->toArray();
            $tags = $this->tagRepository->getJsonTagsForQuestionUser($questions->first(), null);
            return view('book', compact('done_count', 'questions', 'response', 'tags'));
        } else {
            return redirect('/random');
        }
    }

    public function welcome(Request $request)
    {
        $users_count = User::count();
        $user = $request->user();
        $sample = config('samples.home.0');
        $sample['tags'] = $this->prepareTags($sample['tags']);
        return view('welcome', compact('users_count', 'user', 'sample'));
    }

    public function limits(Request $request)
    {
        $user = $request->user();
        $samples = config('samples.limits');
        $samples['0']['tags'] = $this->prepareTags($samples['0']['tags']);
        $samples['1']['tags'] = $this->prepareTags($samples['1']['tags']);
        $samples['2']['tags'] = $this->prepareTags($samples['2']['tags']);
        return view('limits', compact('user', 'samples'));
    }

    private function prepareTags($tags)
    {
        $result = [];
        foreach ($tags as $id => $label) {
            $result[] = ['color' => 'blue', 'is_custom' => false, 'checked' => false, 'label' => $label, 'id' => $id];
        }
        return $result;
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

    public function downloadActions()
    {
        return response()->download(storage_path("app/public/actions.zip"));
    }

    public function downloadResults()
    {
        return response()->download(storage_path("app/public/results.zip"));
    }

    public function downloadTexts()
    {
        return response()->download(storage_path("app/public/texts.zip"));
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
