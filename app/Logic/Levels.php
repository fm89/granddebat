<?php

namespace App\Logic;

class Levels
{
    public static function forScore($score)
    {
        $levels = self::levels();
        $result = $levels[0];
        foreach ($levels as $level) {
            if ($score >= $level[0]) {
                $result = $level;
            }
        }
        return $result;
    }

    public static function levels()
    {
        return [
            [0, 'info', 'Piou Piou'],
            [10, 'info', 'Ourson'],
            [25, 'info', 'Flocon'],
            [50, 'primary', 'Première étoile'],
            [100, 'primary', 'Deuxième étoile'],
            [250, 'primary', 'Troisième étoile'],
            [500, 'success', 'Etoile de bronze'],
            [1000, 'success', 'Etoile d\'or'],
            [1500, 'success', 'Fléchette'],
            [2000, 'warning', 'Flèche de bronze'],
            [3000, 'warning', 'Flèche d\'argent'],
            [4000, 'warning', 'Flèche de vermeil'],
            [5000, 'warning', 'Flèche d\'or'],
            [6000, 'danger', 'Cabri'],
            [7000, 'danger', 'Chamois de bronze'],
            [8000, 'danger', 'Chamois d\'argent'],
            [9000, 'danger', 'Chamois de vermeil'],
            [10000, 'danger', 'Chamois d\'or'],
            [12000, 'dark', 'Fusée de bronze'],
            [14000, 'dark', 'Fusée d\'argent'],
            [17000, 'dark', 'Fusée de vermeil'],
            [20000, 'dark', 'Fusée d\'or'],
            [25000, 'dark', 'Record'],
        ];
    }

    public static function todoForNextLevel($score)
    {
        $levels = self::levels();
        foreach ($levels as $level) {
            if ($score < $level[0]) {
                return $level[0] - $score;
            }
        }
        return 0;
    }
}
