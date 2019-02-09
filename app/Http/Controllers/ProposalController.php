<?php

namespace App\Http\Controllers;


use App\Models\Debate;
use App\Models\Proposal;

class ProposalController extends Controller
{
    public function show(Proposal $proposal)
    {
        $responses = $proposal->responses()->join('questions', 'questions.id', 'responses.question_id')->orderBy('questions.order')->get();
        $debate = Debate::find(floor($proposal->id / 1000000));
        $next_proposal = Proposal::inRandomOrder()->first();
        return view('proposals.show', compact('debate', 'proposal', 'responses', 'next_proposal'));
    }
}
