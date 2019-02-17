<div class="card mb-3">
    <div class="card-body">
        Retour aux <a href="/home">Débats</a>
        / <a href="/debates/{{ $question->debate_id }}">Questions</a>
        @if (($question->status === 'open') || (isset($user) && $user->role === 'admin'))
            / <a href="/questions/{{ $question->id }}">Tags</a>
        @endif
    </div>
</div>
