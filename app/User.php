<?php

namespace App;

use App\Models\Question;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
        return $this->level()[0];
    }

    public function badgeText()
    {
        return $this->level()[1];
    }

    private function levels()
    {
        return [
            0000 => ['info', 'Piou Piou'],
            0010 => ['info', 'Ourson'],
            0025 => ['info', 'Flocon'],
            0050 => ['primary', 'Première étoile'],
            0100 => ['primary', 'Deuxième étoile'],
            0250 => ['primary', 'Troisième étoile'],
            0500 => ['warning', 'Etoile de bronze'],
            1000 => ['warning', 'Etoile d\'or'],
            1500 => ['warning', 'Fléchette'],
            2000 => ['success', 'Flèche de bronze'],
            3000 => ['success', 'Flèche d\'argent'],
            4000 => ['success', 'Flèche de vermeil'],
            5000 => ['success', 'Flèche d\'or'],
            6000 => ['danger', 'Cabri'],
            7000 => ['danger', 'Chamois de bronze'],
            8000 => ['danger', 'Chamois d\'argent'],
            9000 => ['danger', 'Chamois de vermeil'],
            10000 => ['danger', 'Chamois d\'or'],
            12000 => ['dark', 'Fusée de bronze'],
            14000 => ['dark', 'Fusée d\'argent'],
            17000 => ['dark', 'Fusée de vermeil'],
            20000 => ['dark', 'Fusée d\'or'],
            25000 => ['dark', 'Record'],
        ];
    }

    private function level()
    {
        $levels = $this->levels();
        $levelMeta = $levels[0];
        $score = $this->scores['total'];
        foreach ($levels as $threshold => $meta) {
            if ($score >= $threshold) {
                $levelMeta = $meta;
            }
        }
        return $levelMeta;
    }

    public function todoForNextLevel()
    {
        $levels = $this->levels();
        $score = $this->scores['total'];
        foreach ($levels as $threshold => $meta) {
            if ($threshold > $score) {
                return $threshold - $score;
            }
        }
        return 0;
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
}
