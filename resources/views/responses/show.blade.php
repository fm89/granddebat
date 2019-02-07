@extends('layouts.app')

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <b>{{ $question->text }}</b>
            <br/><br/>
            @if ($response != null)
                {{ $response->value }} (<a href="/proposals/{{ $response->proposal_id }}">contribution</a>)
                <br/><br/>
                {!! Form::open(['url' => '/responses/' . $response->id]) !!}
                @foreach ($tags as $tag)
                    <input data-style="mb-1" type="checkbox" name="tags[]" value="{{ $tag->id }}"
                           data-onstyle="secondary" data-toggle="toggle" data-on="{{ $tag->name }}"
                           data-off="{{ $tag->name }}"/>
                @endforeach
                <br/><br/>
                <button class="btn btn-primary" type="submit">
                    <i class="fa fa-btn fa-save"></i> Enregistrer
                </button>
                <a class="btn btn-light" href="/responses/{{ $next_response->id }}" style="float: right;">
                    <i class="fa fa-btn fa-step-forward"></i> Passer
                </a>
                {!! Form::close() !!}
            @endif
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-body">
            Retour au débat <a href="/debates/{{ $question->debate->id }}">{{ $question->debate->name }}</a>
            / <a href="/questions/{{ $question->id }}">{{ $question->text }}</a>
        </div>
    </div>
@endsection
