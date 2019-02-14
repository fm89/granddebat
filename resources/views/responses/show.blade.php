@extends('layouts.app', ['compact' => true])

@section('content')
    @if ($show_easy_help)
        <div class="alert alert-info mb-3">
            <p>Lisez l'intitulé de la question et la réponse apportée par un contributeur ci-dessous.</p>
            <p>Déterminez la ou les catégories qui correspondent le mieux au texte. Cochez-les puis validez.</p>
            <p>Si le texte vous semble hors sujet ou ne pas contenir de réponse à la question, cliquez sur la croix
                grise.</p>
        </div>
    @endif
    @if ($show_bulb_help)
        <div class="alert alert-warning mb-3">
            <p>
                Si le texte vous semble particulièrement riche, argumenté ou étayé, classifiez-le puis utilisez le
                bouton jaune "<b>marquer l'idée</b>". Ces textes de qualité seront ensuite regroupés par thématique
                afin de pouvoir être transmis aux entités concernées.
            </p>
        </div>
    @endif
    <div class="card mb-3">
        <div class="card-body">
            @guest
                <div class="alert alert-danger">
                    <a href="/register">Créez votre compte</a> ou <a href="/login">connectez-vous</a> pour
                    créer vos propres catégories, enregistrer votre catégorisation de cette contribution et
                    aider la communauté à donner du sens au débat !
                    <b>Vos annotations se sont pas enregistrées si vous n'êtes pas connecté.</b>
                </div>
                <br/>
            @endguest
            @if (isset($previous_question))
                <b>{{ $previous_question->text }}</b>
                @if (isset($previous_response))
                    @include('responses.value', ['value' => $previous_response->value])
                @endif
                <br/>
            @endif
            <b>{{ $question->text }}</b>
            <blockquote>
                <p class="quotation">
                    @include('responses.value', ['value' => $response->value])
                </p>
                <footer>
                    <a href="/proposals/{{ $response->proposal_id }}">contribution</a>
                </footer>
            </blockquote>
            <br/>
            {!! Form::open(['url' => '/responses/' . $response->id]) !!}
            @guest
                @if ($question->status == 'open')
                    @foreach ($tags as $tag)
                        <toggle-button :tag="{{ $tag }}"></toggle-button>
                    @endforeach
                    <button class="btn btn-light mb-1" disabled>
                        <i class="fa fa-btn fa-plus"></i> Créer
                    </button>
                    <a class="btn btn-light" href="/responses/{{ $next_response->id }}" style="float: right;">
                        <i class="fa fa-btn fa-step-forward"></i>
                        <div class="d-none d-sm-inline">Suivante</div>
                    </a>
                @else
                    <a class="btn btn-light" href="/responses/{{ $next_response->id }}" style="float: right;">
                        <i class="fa fa-btn fa-step-forward"></i>
                        <div class="d-none d-sm-inline">Suivante</div>
                    </a>
                    <br/><br/><br/>
                    <div class="alert alert-warning">
                        Les catégories pour cette question sont actuellement en cours de préparation.
                    </div>
                @endif
            @endguest
            @auth
                @if (($question->status == 'open') || \Illuminate\Support\Facades\Auth::user()->role == 'admin')
                    @foreach ($tags as $tag)
                        <toggle-button :tag="{{ $tag }}"></toggle-button>
                    @endforeach
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
                    @if ($show_bulb)
                        <button class="btn btn-warning" type="submit" name="action" value="lightbulb">
                            <i class="fa fa-btn fa-lightbulb"></i>
                            <div class="d-none d-sm-inline">Marquer l'idée</div>
                        </button>
                    @endif
                    <a class="btn btn-light" href="/responses/{{ $next_response->id }}" style="float: right;">
                        <i class="fa fa-btn fa-step-forward"></i>
                        <div class="d-none d-sm-inline">Passer</div>
                    </a>
                @else
                    <a class="btn btn-light" href="/responses/{{ $next_response->id }}" style="float: right;">
                        <i class="fa fa-btn fa-step-forward"></i>
                        <div class="d-none d-sm-inline">Passer</div>
                    </a>
                    <div class="alert alert-warning">
                        Les catégories pour cette question sont actuellement en cours de préparation.
                    </div>
                @endif
            @endauth
            {!! Form::close() !!}
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-body">
            Retour aux <a href="/home">Débats</a> /
            <a href="/debates/{{ $question->debate->id }}">Questions</a>
            @auth / <a href="/questions/{{ $question->id }}">Tags</a> @endauth
        </div>
    </div>
    <modal-create-tag :question="{{ $question }}" :can_bulb="{{ $show_bulb }}"></modal-create-tag>
@endsection
