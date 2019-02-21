<div class="card mb-3">
    <div class="card-body">
        Retour aux <a href="/home">Thèmes</a>
        / <a href="/debates/{{ $question->debate_id }}">Questions</a>
        @if (isset($user))
            @if (($question->status === 'open' && $user->scores['total'] >= $question->minimal_score) || ($user->role === 'admin'))
                / <a href="/questions/{{ $question->id }}">Tags</a>
            @endif
        @endif
    </div>
</div>
