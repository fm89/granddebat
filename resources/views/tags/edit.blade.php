@extends('layouts.app')

@section('content')
    <div class="card mb-3">
        <div class="card-header">
            Modification d'une catégorie pour la question <i>{{ $question->text }}</i>
        </div>
        <div class="card-body">
            {!! Form::open(['url' => 'tags/' . $tag->id]) !!}
            <div class="form-group">
                <label for="name" class="control-label">Nom de la catégorie</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $tag->name }}"/>
            </div>
            <button class="btn btn-primary" type="submit">
                <i class="fa fa-btn fa-save"></i> Renommer la catégorie
            </button>
            {!! Form::close() !!}
        </div>
    </div>
    @include('layouts.back_tags')
@endsection
