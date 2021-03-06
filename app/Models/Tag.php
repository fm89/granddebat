<?php

namespace App\Models;

use App\User;
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'checked' => false,
            'color' => $this->color,
            'label' => $this->getLabel(),
            'name' => $this->name,
            'is_custom' => $this->isCustom(),
        ];
    }

    public function getLabel()
    {
        // Remove the first letter which is used to sort tags
        return preg_replace('/^[A-Z] /', '', $this->name);
    }

    public function isCustom()
    {
        return $this->user_id !== null;
    }
}
