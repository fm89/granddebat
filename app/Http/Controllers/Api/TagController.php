<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function store(Request $request)
    {
        $name = $request->input('name');
        $question_id = $request->input('question_id');
        $question = Question::find($question_id);
        $exists = Tag::where('question_id', $question_id)->where('name', 'ILIKE', $name)->exists();
        if ($question != null && !$exists && strlen($name) >= 2) {
            $tag = new Tag();
            $tag->question_id = $question->id;
            $tag->name = $name;
            $tag->save();
        } else {
            $tag = ['id' => null];
        }
        return response()->json($tag);
    }
}
