<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\Action;
use App\Models\Question;
use App\Models\Response;
use App\Models\Tag;
use App\Repositories\ResponseRepository;
use App\Repositories\TagRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class ResponseController extends Controller
{
    private $responseRepository;
    private $tagRepository;

    public function __construct(ResponseRepository $responseRepository, TagRepository $tagRepository)
    {
        $this->responseRepository = $responseRepository;
        $this->tagRepository = $tagRepository;
    }

    public function update(Request $request)
    {
        $key = Crypt::decrypt($request->input('key'));
        $user_id = $key['user_id'];
        $response_id = $key['response_id'];
        $user = $request->user();
        if ($user->id != $user_id) {
            abort(403);
        }
        $response = Response::find($response_id);
        if ($response == null) {
            abort(404);
        }
        $question = $response->question;
        if ($question->status != 'open' && $user->role != 'admin') {
            abort(403);
        }
        $tag_ids = [];
        if ($request->input('action') == 'noanswer') {
            // Hitting the gray button discards all other input tags
            $tag_ids[] = Tag::ID_NO_ANSWER;
        } else {
            // Hitting blue or yellow button keeps all input tags
            if ($request->has('tags')) {
                $tag_ids = $request->input('tags');
            }
            if ($request->input('action') == 'lightbulb') {
                // The yellow button adds a "light bulb" tag on top of the others
                $tag_ids[] = Tag::ID_LIGHT_BULB;
            }
            if (count($tag_ids) == 0) {
                // This happens when the user validates (blue button) an empty set of tags
                $tag_ids[] = Tag::ID_NO_ANSWER;
            }
        }
        // Find all responses having exactly the same text (up to case and accents) to tag them all at once
        $responses = Response::where('question_id', $question->id)
            ->where('clean_value_group_id', $response->clean_value_group_id)
            ->get();
        foreach ($responses as $sibling) {
            // Remove old tags by the same user to avoid duplicate tagging
            $sibling->actions()->where('user_id', $user->id)->delete();
            foreach ($tag_ids as $tag_id) {
                $action = new Action();
                $action->response_id = $sibling->id;
                $action->tag_id = $tag_id;
                $action->user_id = $user->id;
                $action->save();
            }
        }
        $user->addResponseToScore($question);
        $result = $this->next($request, $question);
        $result['scores'] = $user->scores;
        $result['level'] = $user->level();
        return $result;
    }

    public function next(Request $request, Question $question)
    {
        if ($question->is_free) {
            $user = $request->user();
            $response = $this->responseRepository->randomResponse($question);
            $previousResponse = null;
            if ($question->previous_id != null) {
                $previousResponse = Response::where('question_id', $question->previous_id)
                    ->where('proposal_id', $response->proposal_id)->first();
            }
            $key = ['user_id' => $user->id ?? null, 'response_id' => $response->id];
            $key = Crypt::encrypt($key);
            return compact('key', 'previousResponse', 'response');
        } else {
            return null;
        }
    }
}
