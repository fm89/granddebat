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

    public function previous()
    {
        return $this->belongsTo(Question::class, 'previous_id');
    }

    public function texts()
    {
        return $this->hasMany(Text::class);
    }
}
