@extends('layouts.app')

@section('content')
    <div class="card mb-3">
        <div class="card-header">
            Renommage d'une catégorie pour la question <i>{{ $question->text }}</i>
        </div>
        <div class="card-body">
            @if ($tag->actions()->exists())
                <div class="alert alert-warning">
                    <b>Attention !</b> Vous allez renommer une catégorie déjà affectée à des contributions.
                    Faites en sorte que le nouveau nom garde globalement le même sens pour ne pas biaiser
                    vos analyses précédentes. Les contributions attachées à l'ancien nom de la catégorie
                    seront désormais attachées au nouveau nom de la catégorie.
                </div>
            @endif
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
