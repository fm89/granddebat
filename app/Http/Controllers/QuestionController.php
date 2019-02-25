<?php

namespace App\Http\Controllers;


use App\Models\Action;
use App\Models\Question;
use App\Models\Response;
use App\Repositories\ResponseRepository;
use App\Repositories\TagRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
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
            if ($user == null) {
                abort(403);
            }
            if (($user->role != 'admin') && ($question->status == 'preparing' || $user->scores['total'] < $question->minimal_score)) {
                abort(403);
            }
            $tags = $this->tagRepository->getTagsForQuestionUser($question, $user);
            $tag_ids = $tags->map(function ($item, $key) {
                return $item->id;
            })->all();
            $counts = Action::join('responses', 'responses.id', 'actions.response_id')
                ->select('tag_id', DB::raw('COUNT(DISTINCT clean_value_group_id) AS count'))
                ->whereIn('tag_id', $tag_ids)->groupBy('tag_id')->pluck('count', 'tag_id')->all();
            return view('questions.show', compact('question', 'counts', 'tags', 'user'));
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

    public function read(Request $request, Question $question)
    {
        if ($question->is_free) {
            $user = $request->user();
            $response = $this->responseRepository->next($question, $user);
            $previous_response = null;
            $previous_question = $question->previous;
            if ($previous_question != null) {
                $previous_response = Response::where('question_id', $previous_question->id)
                    ->where('proposal_id', $response->proposal_id)->first();
            }
            $tags = $this->tagRepository->getJsonTagsForQuestionUser($question, $user);
            $key = ['user_id' => $user->id ?? null, 'response_id' => $response->id];
            $key = Crypt::encrypt($key);
            return view('responses.show', compact('question', 'response', 'key', 'tags', 'previous_question', 'previous_response', 'user'));
        } else {
            return redirect('/questions/' . $question->id);
        }
    }

    public function search(Question $question)
    {
        if (!$question->is_free) {
            return redirect('/questions/' . $question->id);
        }
        $tags = $this->tagRepository->getJsonTagsForQuestionUser($question, null);
        return view('questions.search', compact('question', 'tags'));
    }
}
