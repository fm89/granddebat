@extends('layouts.app', ['compact' => true])

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            @if (isset($previous_question))
                <b>{{ $previous_question->text }}</b>
                @if (isset($previous_response))
                    @include('responses.value', ['value' => $previous_response->value])
                @endif
                <br/>
            @endif
            <b>{{ $question->text }}</b>
            <br/><br/>
            @include('responses.value', ['value' => $response->value])
            (<a href="/proposals/{{ $response->proposal_id }}">contribution</a>)
            <br/><br/>
            {!! Form::open(['url' => '/responses/' . $response->id]) !!}
            @foreach ($tags as $tag)
                <toggle-button :tag="{{ $tag }}"></toggle-button>
            @endforeach
            @guest
                <button class="btn btn-light mb-1" disabled>
                    <i class="fa fa-btn fa-plus"></i> Créer
                </button>
                <a class="btn btn-light" href="/responses/{{ $next_response->id }}" style="float: right;">
                    <i class="fa fa-btn fa-step-forward"></i>
                    <div class="d-none d-sm-inline">Suivante</div>
                </a>
                <br/><br/><br/>
                <div class="alert alert-info">
                    <a href="/register">Créez votre compte</a> ou <a href="/login">connectez-vous</a> pour
                    créer vos propres catégories, enregistrer votre catégorisation de cette contribution et
                    aider la communauté à extraire du sens du débat !
                </div>
            @endguest
            @auth
                <a class="btn btn-light mb-1" data-toggle="modal" data-target="#modalCreate">
                    <i class="fa fa-btn fa-plus"></i> Créer
                </a>
                <br/><br/>
                <button class="btn btn-primary" type="submit" name="action" value="save">
                    <i class="fa fa-btn fa-check"></i>
                    <div class="d-none d-sm-inline">Valider</div>
                </button>
                <button class="btn btn-secondary" type="submit" name="action" value="noanswer">
                    <i class="fa fa-btn fa-times-circle"></i>
                    <div class="d-none d-sm-inline">Sans réponse</div>
                </button>
                <button class="btn btn-warning" type="submit" name="action" value="lightbulb">
                    <i class="fa fa-btn fa-lightbulb"></i>
                    <div class="d-none d-sm-inline">Marquer l'idée</div>
                </button>
                <a class="btn btn-light" href="/responses/{{ $next_response->id }}" style="float: right;">
                    <i class="fa fa-btn fa-step-forward"></i>
                    <div class="d-none d-sm-inline">Passer</div>
                </a>
            @endauth
            {!! Form::close() !!}
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-body">
            Retour aux <a href="/home">Thèmes</a> /
            <a href="/debates/{{ $question->debate->id }}">Questions</a>
            @auth / <a href="/questions/{{ $question->id }}">Question</a> @endauth
        </div>
    </div>
    <modal-create-tag :question="{{ $question }}"></modal-create-tag>
@endsection
