<?php

namespace App\Http\Controllers;

use App\Models\Debate;

class DebateController extends Controller
{
    public function show(Debate $debate)
    {
        return view('debates.show', compact('debate'));
    }
}
