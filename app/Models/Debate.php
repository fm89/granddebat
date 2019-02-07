<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Debate extends Model
{
    public $timestamps = false;

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
