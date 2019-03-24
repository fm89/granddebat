<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Question;
use App\Models\Text;
use App\Policies\TextPolicy;
use Illuminate\Http\Request;

class TextController extends Controller
{
    public function index()
    {
        $texts = Text::select('texts.*')
            ->with(['question', 'question.debate', 'user'])
            ->join('questions', 'questions.id', 'texts.question_id')
            ->join('debates', 'debates.id', 'questions.debate_id')
            ->join('users', 'users.id', 'texts.user_id')
            ->orderBy('debates.id')
            ->orderBy('questions.order')
            ->orderBy('users.name')
            ->get();
        return view('texts.index', compact('texts'));
    }

    public function create(Request $request)
    {
        $user = $request->user();
        $question_scores = $user->scores['questions'];
        $question_ids = [];
        foreach ($question_scores as $question_id => $question_score) {
            if ($question_score >= TextPolicy::MIN_SCORE_PER_QUESTION) {
                $question_ids[] = $question_id;
            }
        }
        $questions = Question::with('debate')->whereIn('id', $question_ids)->get();
        $options = [];
        foreach ($questions as $question) {
            $options[$question->id] = $question->debate->name . ' / ' . $question->text;
        }
        return view('texts.create', compact('options'));
    }

    public function store(Request $request)
    {
        $question = Question::find($request->input('question'));
        $this->authorize('create', [Text::class, $question]);
        $text = new Text();
        $text->user_id = $request->user()->id;
        $text->question_id = $request->input('question');
        $text->content = $request->input('content');
        $text->save();
        // Send mail to admin
        $message = new Message();
        $message->title = 'Nouveau texte ' . $text->id;
        $message->content = 'Un nouveau texte a été créé, de numéro ' . $text->id;
        $message->user_id = 1;
        $message->save();
        return redirect('/texts/' . $text->id);
    }

    public function show(Request $request, Text $text)
    {
        $user = $request->user();
        return view('texts.show', compact('text', 'user'));
    }

    public function edit(Text $text)
    {
        $this->authorize('update', $text);
        return view('texts.edit', compact('text'));
    }

    public function update(Request $request, Text $text)
    {
        $this->authorize('update', $text);
        $text->content = $request->input('content');
        $text->save();
        // Send mail to admin
        $message = new Message();
        $message->title = 'Texte modifié ' . $text->id;
        $message->content = 'Un texte a été modifié, de numéro ' . $text->id;
        $message->user_id = 1;
        $message->save();
        return redirect('/texts/' . $text->id);
    }

    public function destroy(Text $text)
    {
        //
    }
}
