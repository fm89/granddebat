<?php

namespace App\Http\Controllers;


use App\Models\Question;
use App\Models\Response;
use App\Repositories\ResponseRepository;
use App\Repositories\TagRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        if ($question->is_free) {
            $user = $request->user();
            $tags = $this->tagRepository->getTagsForQuestionUser($question, $user);
            $next_response = $this->responseRepository->randomResponse($question);
            return view('questions.show', compact('question', 'tags', 'next_response'));
        } else {
            $raw_data = $question->responses()
                ->select('value', DB::raw('COUNT(*) AS count'))
                ->groupBy('value')
                ->orderBy('value')
                ->pluck('count', 'value')->all();
            $sum = array_sum(array_values($raw_data));
            // For multiple choice questions, rebuild data from joined string groups
            if ($question->id == 1206 || $question->id == 1207) {
                $data = [];
                foreach ($raw_data as $raw_key => $count) {
                    $keys = explode(', ', $raw_key);
                    foreach ($keys as $key) {
                        if (!array_key_exists($key, $data)) {
                            $data[$key] = 0;
                        }
                        $data[$key] += $count;
                    }
                }
            } else {
                $data = $raw_data;
            }
            foreach (array_keys($data) as $key) {
                $data[$key] = round(100 * $data[$key] / $sum);
            }
            return view('questions.graph', compact('question', 'data'));
        }
    }

    public function read(Question $question)
    {
        if ($question->is_free) {
            $response = $this->responseRepository->randomResponse($question);
            return redirect('/responses/' . $response->id);
        } else {
            return redirect('/questions/' . $question->id);
        }
    }
}
