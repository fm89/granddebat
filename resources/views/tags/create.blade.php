@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            Création d'une catégorie pour une question
        </div>
        <div class="card-body">
            Débat <a href="/debates/{{ $question->debate->id }}">{{ $question->debate->name }}</a> /
            <b>{{ $question->text }}</b>
            <br/><br/>
            {!! Form::open(['url' => 'questions/' . $question->id . '/tags']) !!}
            <div class="form-group">
                <label for="name" class="control-label">Nom de la catégorie</label>
                <input type="text" name="name" id="name" class="form-control"/>
            </div>
            <button class="btn btn-primary" type="submit">
                <i class="fa fa-btn fa-plus"></i> Créer la catégorie
            </button>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
