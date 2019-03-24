@extends('layouts.app')

@section('content')
    <div class="card mb-3">
        <div class="card-header">
            <b>{{ $text->question->text }}</b>
            <br>
            Texte libre rédigé par {{ $text->user->name }} pour synthétiser
            ses {{ $text->user->scores['questions'][$text->question_id] }} propres lectures de cette question
            du thème {{ $text->question->debate->name }}
        </div>
        <div class="card-body">
            {!! \GrahamCampbell\Markdown\Facades\Markdown::convertToHtml($text->content) !!}
            @auth
                @if ($text->user_id == $user->id)
                    <a href="/texts/{{ $text->id }}/edit" class="btn btn-primary mt-5">
                        <i class="fa fa-btn fa-pen"></i>
                        Modifier ce texte
                    </a>
                @endif
            @endauth
        </div>
    </div>
@endsection
