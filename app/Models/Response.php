<?php

namespace App\Models;

use App\Logic\Priority;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    public $timestamps = false;
    public $fillable = ['priority'];

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

    public function results()
    {
        return $this->hasMany(Result::class);
    }

    public function skips()
    {
        return $this->hasMany(Skip::class);
    }

    public function setTags(array $tag_ids, User $user)
    {
        $this->deleteOldActions($user);
        $this->insertNewActions($user, $tag_ids);
        $this->updatePriority();
    }

    private function deleteOldActions(User $user)
    {
        $clean_value_group_id = $this->clean_value_group_id;
        $question_id = $this->question_id;
        Action::where('user_id', $user->id)->whereIn('response_id',
            function ($query) use ($clean_value_group_id, $question_id) {
                $query->select('id')->from('responses')
                    ->where('clean_value_group_id', $clean_value_group_id)
                    ->where('question_id', $question_id);
            })->delete();
    }

    private function insertNewActions(User $user, $tag_ids)
    {
        $now = Carbon::now()->toDateTimeString();
        $response_ids = Response::where('question_id', $this->question_id)
            ->where('clean_value_group_id', $this->clean_value_group_id)
            ->where('question_id', $this->question_id)
            ->pluck('id');
        $actions = [];
        foreach ($tag_ids as $tag_id) {
            foreach ($response_ids as $response_id) {
                $actions[] = [
                    'tag_id' => $tag_id,
                    'user_id' => $user->id,
                    'response_id' => $response_id,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }
        Action::insert($actions);
    }

    private function updatePriority()
    {
        $priority = Priority::getFor($this);
        if ($priority != $this->priority) {
            // Save an update query if the priority has not changed
            Response::where('clean_value_group_id', $this->clean_value_group_id)
                ->where('question_id', $this->question_id)
                ->update(['priority' => $priority]);
        }
    }

    public function toArray()
    {
        return [
            'value' => $this->value,
            'proposal_id' => $this->proposal_id,
            'city' => $this->proposal->city,
            'published_at' => $this->proposal->published_at->format('j') . ' '
                . ['01' => 'janvier', '02' => 'février', '03' => 'mars'][$this->proposal->published_at->format('m')]
        ];
    }
}
