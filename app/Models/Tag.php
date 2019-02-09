<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Tag extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    const ID_NO_ANSWER = 1;
    const ID_LIGHT_BULB = 2;

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function actions()
    {
        return $this->hasMany(Action::class);
    }
}
