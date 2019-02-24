<?php

namespace App\Repositories;

use App\Models\Question;
use App\User;

class TagRepository
{
    public function getJsonTagsForQuestionUser($question, $user)
    {
        return $this->getTagsForQuestionUser($question, $user)->map(function ($tag) {
            return [
                'id' => $tag->id,
                'name' => $tag->name,
                'label' => $tag->getLabel(),
                'checked' => false
            ];
        });
    }

    public function getTagsForQuestionUser(Question $question, User $user = null)
    {
        return $question->tags()->where(function ($query) use ($user) {
            if ($user == null) {
                return $query->whereNull('user_id');
            } else {
                return $query->whereNull('user_id')->orWhere('user_id', $user->id);
            }
        })->orderBy('name')->get();
    }
}