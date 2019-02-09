<?php

namespace App\Http\Controllers;


use App\Models\Action;
use App\Models\Response;
use App\Models\Tag;
use App\Repositories\ResponseRepository;
use Illuminate\Http\Request;

class ResponseController extends Controller
{
    private $responseRepository;

    public function __construct(ResponseRepository $responseRepository)
    {
        $this->responseRepository = $responseRepository;
    }

    public function show(Response $response)
    {
        $question = $response->question;
        $tags = $question->tags()->orderBy('name')->get();
        $next_response = $this->responseRepository->randomResponse($question);
        return view('responses.show', compact('question', 'response', 'tags', 'next_response'));
    }

    public function update(Response $response, Request $request)
    {
        $tag_ids = [];
        if ($request->has('tags')) {
            $tag_ids = $request->input('tags');
        }
        if ($request->input('action') == 'noanswer') {
            $tag_ids[] = Tag::ID_NO_ANSWER;
        }
        if ($request->input('action') == 'lightbulb') {
            $tag_ids[] = Tag::ID_LIGHT_BULB;
        }
        if (count($tag_ids) > 0) {
            $user_id = $request->user()->id;
            // Find all responses having exactly the same text to tag them all at once
            $responses = Response::where('question_id', $response->question->id)
                ->where('value', $response->value)->get();
            foreach ($responses as $sibling) {
                // Remove old tags by the same user to avoid duplicate tagging
                $sibling->actions()->where('user_id', $user_id)->delete();
                foreach ($tag_ids as $tag_id) {
                    $action = new Action();
                    $action->response_id = $sibling->id;
                    $action->tag_id = $tag_id;
                    $action->user_id = $user_id;
                    $action->save();
                }
            }
        }
        $nextResponse = $this->responseRepository->randomResponse($response->question);
        return redirect('/responses/' . $nextResponse->id);
    }
}
