<?php

namespace App\Http\Controllers;


use App\Models\Proposal;

class ProposalController extends Controller
{
    public function show(Proposal $proposal)
    {
        $responses = $proposal->responses()->orderBy('question_id')->get();
        return view('proposals.show', compact('proposal', 'responses'));
    }
}
