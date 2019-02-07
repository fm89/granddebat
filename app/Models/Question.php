<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    public $timestamps = false;

    public function debate()
    {
        return $this->belongsTo(Debate::class);
    }

    public function responses()
    {
        return $this->hasMany(Response::class);
    }

    public function tags()
    {
        return $this->hasMany(Tag::class);
    }

    public function score()
    {
        return $this->responses()->whereHas('actions')->count();
    }

    public function myScore(User $user)
    {
        $user_id = $user->id;
        return $this->responses()->whereHas('actions', function ($query) use ($user_id) {
            $query->where('user_id', $user_id);
        })->count();
    }
}
