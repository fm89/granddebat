<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Tag extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function actions()
    {
        return $this->hasMany(Action::class);
    }
}
