<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Tag;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
                $tag = ['id' => $createdTag->id, 'name' => $createdTag->name, 'label' => $createdTag->getLabel(), 'checked' => false];
            }
        }
        return response()->json($tag);
    }

    public function doCreate(User $user, Question $question, $name)
    {
        $this->authorize('create', [Tag::class, $question]);
        $escaped = DB::connection()->getPdo()->quote($name);
        $exists = Tag::where('question_id', $question->id)
            ->whereRaw("lower(unaccent(name)) = lower(unaccent($escaped))")
            ->where(function ($query) use ($user) {
                $query->whereNull('user_id')
                    ->orWhere('user_id', $user->id);
            })
            ->exists();
        if (!$exists && strlen($name) >= 2) {
            $tag = new Tag();
            $tag->question_id = $question->id;
            $tag->name = $name;
            if ($user->role != 'admin' || $question->status == 'open') {
                $tag->user_id = $user->id;
            }
            $tag->save();
            return $tag;
        } else {
            return null;
        }
    }
}
