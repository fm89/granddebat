<?php

namespace App;

use App\Models\Message;
use App\Models\Question;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Logic\Levels;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'scores' => 'array',
    ];

    public function badgeColor()
    {
        return $this->level()[1];
    }

    public function badgeText()
    {
        return $this->level()[2];
    }

    public function level()
    {
        return Levels::forScore($this->scores['total']);
    }

    public function todoForNextLevel()
    {
        return Levels::todoForNextLevel($this->scores['total']);
    }

    public function addResponseToScore(Question $question)
    {
        $scores = $this->scores;
        $scores['total'] = $scores['total'] + 1;
        $scores['debates'][$question->debate_id] = $scores['debates'][$question->debate_id] + 1;
        if (!array_key_exists($question->id, $scores['questions'])) {
            $scores['questions'][$question->id] = 0;
        }
        $scores['questions'][$question->id] = $scores['questions'][$question->id] + 1;
        $this->scores = $scores;
        $this->save();
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function unreadMessages()
    {
        return $this->messages()->where('read', false);
    }
}
