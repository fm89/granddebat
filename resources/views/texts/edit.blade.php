@extends('layouts.app')

@section('content')
    <div class="card mb-3">
        <div class="card-header">&Eacute;dition d'un texte existant</div>
        <div class="card-body">
            <div class="alert alert-info">
                Cet écran vous permet de modifier un texte libre de synthèse que vous avez déjà écrit.
                Pour mettre en forme légèrement votre texte (gras, italique, listes, titres,
                liens, etc.) vous pouvez utiliser la syntaxe <a href="https://commonmark.org/help/">Markdown</a>.
            </div>
            {!! Form::open(['url' => 'texts/' . $text->id, 'method' => 'PUT']) !!}
            <div class="form-group">
                <label for="question" class="control-label">Choix de la question</label>
                <input type="text" id="question" class="form-control" disabled
                       value="{{ $text->question->debate->name . ' / ' . $text->question->text }}"/>
            </div>
            <div class="form-group">
                <label for="content" class="control-label">Rédaction du texte de synthèse</label>
                <textarea name="content" id="content" rows=20 style="resize: vertical;"
                          class="form-control" required>{{ $text->content }}</textarea>
            </div>
            @include('texts.legal-warning')
            <button class="btn btn-primary" type="submit">
                <i class="fa fa-btn fa-save"></i> Enregistrer les modifications
            </button>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
