<?php

namespace App;

use App\Models\Action;
use App\Models\Message;
use App\Models\Question;
use App\Notifications\ResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Logic\Levels;
use Illuminate\Support\Facades\DB;

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

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function unreadMessages()
    {
        return $this->messages()->where('read', false);
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

    public function refreshScore()
    {
        $per_question = Action::join('responses', 'responses.id', 'actions.response_id')
            ->groupBy('question_id')
            ->where('user_id', $this->id)
            ->select('question_id', DB::raw('COUNT(DISTINCT clean_value_group_id) AS values'))
            ->pluck('values', 'question_id')
            ->all();
        $per_debate = [1 => 0, 2 => 0, 3 => 0, 4 => 0];
        $total = 0;
        $questions = Question::pluck('debate_id', 'id')->all();
        foreach ($per_question as $question_id => $values) {
            $debate_id = $questions[$question_id];
            $per_debate[$debate_id] = $per_debate[$debate_id] + $values;
            $total += $values;
        }
        $scores = $this->scores;
        $scores['total'] = $total;
        $scores['debates'] = $per_debate;
        $scores['questions'] = $per_question;
        $this->scores = $scores;
        $this->save();
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }
}
