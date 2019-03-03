@extends('layouts.app')

@section('content')
    <div class="card mb-3">
        <div class="card-header">
            Suppression d'une catégorie pour la question <i>{{ $question->text }}</i>
        </div>
        <div class="card-body">
            @if ($tag->actions()->exists())
                <div class="alert alert-danger">
                    <b>Attention !</b> Vous allez supprimer une catégorie que vous avez déjà affectée à des
                    contributions. Cette catégorie sera retirée des annotations que vous avez réalisées en l'utilisant.
                    Il se peut que votre score baisse un peu suite à cette manipulation ; mais ça n'est pas très grave !
                    En supprimant d'anciennes catégories que vous ne souhaitez plus utiliser, vous simplifiez votre
                    interface et cela vous permet d'aller plus vite dans le processus d'annotation.
                </div>
            @else
                <div class="alert alert-warning">
                    Vous allez supprimer une catégorie que vous n'avez pas encore utilisée. C'est absolument sans
                    risque, vous pouvez y aller !
                </div>
            @endif
            {!! Form::open(['url' => 'tags/' . $tag->id, 'method' => 'delete']) !!}
            <div class="form-group">
                <label for="name" class="control-label">Nom de la catégorie</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $tag->name }}" disabled/>
            </div>
            <button class="btn btn-danger" type="submit">
                <i class="fa fa-trash"></i> Supprimer la catégorie
            </button>
            <a href="/questions/{{ $question->id }}" class="btn btn-secondary">
                Annuler
            </a>
            {!! Form::close() !!}
        </div>
    </div>
    @include('layouts.back_tags')
@endsection
