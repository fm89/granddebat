<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Text extends Model
{
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
