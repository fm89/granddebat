<?php

namespace App\Logic;


use App\Models\Response;

class Priority
{
    public static function getFor(Response $response)
    {
        $actions = $response->actions;
        $users_count = $actions->map(function ($action) { return $action->user_id; })->unique()->count();
        if ($users_count >= 7) {
            // Stop tagging if 7 users have given their opinion (whether they agree or not)
            $priority = self::oneTagPresent($actions, $users_count) ? -5 : -1;
        } elseif ($users_count < 3) {
            // Continue tagging if only 1 or 2 users have given their opinion, with high priority
            $priority = 10;
        } else {
            // If 3 to 6 users have given their opinion, continue tagging if we have not settled all tags
            $priority = (self::allTagsSettled($actions, $users_count) && self::oneTagPresent($actions, $users_count)) ? -10 : 5;
        }
        return $priority;
    }

    private static function allTagsSettled($actions, $users_count)
    {
        // We say that a tag is "settled" if there is a majority of users by a margin of at least 2 who agree that the
        // tag is (or is not) associated with the given text.
        $tags = $actions->map(function ($action) { return $action->tag_id; })->unique()->all();
        foreach ($tags as $tag) {
            $users_agree = $actions->filter(function ($action) use ($tag) { return $action->tag_id == $tag; })->count();
            $users_disagree = $users_count - $users_agree;
            if (abs($users_agree - $users_disagree) < 2) {
                return false;
            }
        }
        return true;
    }

    private static function oneTagPresent($actions, $users_count)
    {
        // We say that a tag is "present" if a majority of users agree with it being associated to the given text.
        $tags = $actions->map(function ($action) { return $action->tag_id; })->unique()->all();
        foreach ($tags as $tag) {
            $users_agree = $actions->filter(function ($action) use ($tag) { return $action->tag_id == $tag; })->count();
            $users_disagree = $users_count - $users_agree;
            if ($users_agree > $users_disagree) {
                return true;
            }
        }
        return false;
    }
}