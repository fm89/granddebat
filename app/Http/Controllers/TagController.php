<?php

namespace App\Http\Controllers;


use App\Models\Question;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function create(Question $question)
    {
        return view('tags.create', compact('question'));
    }

    public function store(Question $question, Request $request)
    {
        $this->validate($request, [
           'name' => 'required',
        ]);
        $tag = new Tag();
        $tag->question_id = $question->id;
        $tag->name = $request->input('name');
        $tag->save();
        if ($request->has('response_id')) {
            # Tag was create from a modal form within a response page so we should redirect there
            return redirect('/responses/' . $request->input('response_id'));
        }
        return redirect('questions/' . $question->id);
    }

    public function edit(Tag $tag)
    {
        $question = $tag->question;
        return view('tags.edit', compact('question', 'tag'));
    }

    public function update(Tag $tag, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);
        $tag->name = $request->input('name');
        $tag->save();
        return redirect('questions/' . $tag->question->id);
    }

    public function delete(Tag $tag)
    {
        $question = $tag->question;
        if ($tag->actions()->count() == 0) {
            $tag->delete();
        }
        return redirect('questions/' . $question->id);
    }

}
