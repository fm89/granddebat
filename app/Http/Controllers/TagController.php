<?php

namespace App\Http\Controllers;


use App\Models\Question;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    private $apiTagController;

    public function __construct(\App\Http\Controllers\Api\TagController $apiTagController)
    {
        $this->apiTagController = $apiTagController;
    }

    public function create(Question $question)
    {
        return view('tags.create', compact('question'));
    }

    public function store(Question $question, Request $request)
    {
        $this->apiTagController->doCreate($request->user(), $question, $request->input('name'));
        return redirect('questions/' . $question->id);
    }

    public function edit(Tag $tag)
    {
        $this->authorize('update', $tag);
        $question = $tag->question;
        return view('tags.edit', compact('question', 'tag'));
    }

    public function update(Tag $tag, Request $request)
    {
        $this->authorize('update', $tag);
        $this->validate($request, [
            'name' => 'required',
        ]);
        $tag->name = $request->input('name');
        $tag->save();
        return redirect('questions/' . $tag->question->id);
    }

    public function delete(Tag $tag)
    {
        $this->authorize('delete', $tag);
        $question = $tag->question;
        $tag->delete();
        return redirect('questions/' . $question->id);
    }

}
