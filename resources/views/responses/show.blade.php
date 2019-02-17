@extends('layouts.app', ['compact' => true])

@section('content')
    <tagger :question="{{ $question }}"
            @if (isset($previous_question)) :previous-question="{{ $previous_question->toJSON() }}" @endif
            @if (isset($previous_response)) :initial-previous-response="{{ $previous_response->toJSON() }}" @endif
            :initial-tags="{{ json_encode($tags) }}" :initial-key="'{{ $key }}'" :initial-user="{{ json_encode($user) }}"
            :initial-response="{{ json_encode($response) }}"></tagger>
    <div class="card mb-3">
        <div class="card-body">
            Retour aux <a href="/home">Débats</a> /
            <a href="/debates/{{ $question->debate->id }}">Questions</a>
            @auth / <a href="/questions/{{ $question->id }}">Tags</a> @endauth
        </div>
    </div>
@endsection
