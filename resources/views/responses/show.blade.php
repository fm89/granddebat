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
                <input data-style="mb-1" type="checkbox" name="tags[]" value="{{ $tag->id }}"
                       data-onstyle="secondary" data-toggle="toggle" data-on="{{ $tag->name }}"
                       data-off="{{ $tag->name }}"/>
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
            <button class="btn btn-warning" type="submit" name="action" value="lightbulb">
                <i class="fa fa-btn fa-lightbulb"></i>
                <div class="d-none d-sm-inline">Marquer l'idée</div>
            </button>
            <a class="btn btn-light" href="/responses/{{ $next_response->id }}" style="float: right;">
                <i class="fa fa-btn fa-step-forward"></i>
                <div class="d-none d-sm-inline">Passer</div>
            </a>
            {!! Form::close() !!}
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-body">
            Retour aux <a href="/home">Thèmes</a> /
            <a href="/debates/{{ $question->debate->id }}">Questions</a>
            / <a href="/questions/{{ $question->id }}">Question</a>
        </div>
    </div>
    <div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Créer une nouvelle catégorie</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <b>{{ $question->text }}</b>
                    <br/><br/>
                    {!! Form::open(['url' => 'questions/' . $question->id . '/tags']) !!}
                    <input type="hidden" name="response_id" value="{{ $response->id }}"/>
                    <div class="form-group">
                        <label for="name" class="control-label">Nom de la catégorie</label>
                        <input type="text" name="name" id="name" class="form-control"/>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-btn fa-plus"></i> Créer la catégorie
                    </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Annuler
                    </button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
