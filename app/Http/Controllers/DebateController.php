<?php

namespace App\Http\Controllers;

use App\Models\Debate;
use Illuminate\Http\Request;

class DebateController extends Controller
{
    public function show(Request $request, Debate $debate)
    {
        $user = $request->user();
        return view('debates.show', compact('debate', 'user'));
    }
}
