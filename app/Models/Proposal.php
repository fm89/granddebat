<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    public $timestamps = false;
    public $dates = ['published_at'];
    
    public function responses()
    {
        return $this->hasMany(Response::class);
    }

    public function reference()
    {
        return '' . floor($this->id / 1000000) . '-' . ($this->id % 1000000);
    }
}
