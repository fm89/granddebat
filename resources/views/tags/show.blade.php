@extends('layouts.app')

@section('content')
    <div class="card mb-3">
        <div class="card-header">
            Exemples de réponses annotées avec "<b>{{ $tag->name }}</b>"
        </div>
        <div class="card-body">
            Débat <a href="/debates/{{ $tag->question->debate->id }}">{{ $tag->question->debate->name }}</a> /
            <a href="/questions/{{ $tag->question->id }}">{{ $tag->question->text }}</a>
            <br/><br/>
            @foreach ($responses as $response)
                <blockquote>
                    <p class="quotation">
                        @include('responses.value', ['value' => $response->value])
                    </p>
                    <footer>
                        <a href="/proposals/{{ $response->proposal_id }}">contribution</a>
                    </footer>
                </blockquote>
            @endforeach
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-body">
            Retour aux <a href="/home">Débats</a> /
            <a href="/debates/{{ $tag->question->debate->id }}">Questions</a>
            @auth / <a href="/questions/{{ $tag->question->id }}">Tags</a> @endauth
        </div>
    </div>
@endsection
