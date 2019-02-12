<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Tag;
use App\User;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function store(Request $request)
    {
        $name = $request->input('name');
        $question_id = $request->input('question_id');
        $question = Question::find($question_id);
        $user = $request->user();
        $tag = ['id' => null];
        if ($question != null) {
            $createdTag = $this->doCreate($user, $question, $name);
            if ($createdTag != null) {
                $tag = $createdTag;
            }
        }
        return response()->json($tag);
    }

    public function doCreate(User $user, Question $question, $name)
    {
        $exists = Tag::where('question_id', $question->id)
            ->where('name', 'ILIKE', $name)
            ->where(function ($query) use ($user) {
                $query->whereNull('user_id')
                    ->orWhere('user_id', $user->id);
            })->exists();
        if (!$exists && strlen($name) >= 2) {
            $tag = new Tag();
            $tag->question_id = $question->id;
            $tag->name = $name;
            if ($user->role != 'admin') {
                $tag->user_id = $user->id;
            }
            $tag->save();
            return $tag;
        } else {
            return null;
        }
    }
}
