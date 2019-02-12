<?php

namespace App\Http\Controllers;


use App\Models\Action;
use App\Models\Response;
use App\Models\Tag;
use App\Repositories\ResponseRepository;
use App\Repositories\TagRepository;
use Illuminate\Http\Request;

class ResponseController extends Controller
{
    private $responseRepository;
    private $tagRepository;

    public function __construct(ResponseRepository $responseRepository, TagRepository $tagRepository)
    {
        $this->responseRepository = $responseRepository;
        $this->tagRepository = $tagRepository;
    }

    public function show(Request $request, Response $response)
    {
        $question = $response->question;
        $user = $request->user();
        $next_response = $this->responseRepository->randomResponse($question);
        $previous_response = null;
        $previous_question = $question->previous;
        if ($previous_question != null) {
            $previous_response = Response::where('question_id', $previous_question->id)
                ->where('proposal_id', $response->proposal_id)->first();
        }
        $tags = $this->tagRepository->getTagsForQuestionUser($question, $user);
        $show_easy_help = ($request->user() != null) && ($request->user()->scores['total'] < 10);
        $show_bulb = ($request->user() != null) && ($request->user()->scores['total'] >= 50);
        $show_bulb_help = ($request->user() != null) && ($request->user()->scores['total'] >= 50 && $request->user()->scores['total'] < 60);
        return view('responses.show',
            compact('question', 'response', 'tags', 'next_response', 'previous_question', 'previous_response',
                'show_easy_help', 'show_bulb', 'show_bulb_help'));
    }

    public function update(Response $response, Request $request)
    {
        $question = $response->question;
        $user = $request->user();
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
        // Find all responses having exactly the same text to tag them all at once
        $responses = Response::where('question_id', $question->id)
            ->where('value', $response->value)->get();
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
        $nextResponse = $this->responseRepository->randomResponse($question);
        return redirect('/responses/' . $nextResponse->id);
    }
}
