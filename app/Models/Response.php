<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    public $timestamps = false;

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function proposal()
    {
        return $this->belongsTo(Proposal::class);
    }

    public function actions()
    {
        return $this->hasMany(Action::class);
    }
}
