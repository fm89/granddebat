@extends('layouts.app')

@section('content')
    <div class="card mb-3">
        <div class="card-header">Rédaction d'un nouveau texte</div>
        <div class="card-body">
            <div class="alert alert-info">
                Cet écran vous permet d'écrire un texte libre de synthèse sur une question pour laquelle vous avez lu
                beaucoup de réponses. Vous pourrez modifier ce texte par la suite en cliquant sur le petit stylo sur
                la page du texte. Vous ne pouvez créer qu'un seul texte par question, mais il vous est bien sûr possible
                de le modifier. Si vous avez beaucoup lu plusieurs questions, vous pouvez créer plusieurs textes
                (un texte par question). Pour mettre en forme légèrement votre texte (gras, italique, listes, titres,
                liens, etc.) vous pouvez utiliser la syntaxe <a href="https://commonmark.org/help/">Markdown</a>.
            </div>
            @if (count($options) > 0)
                {!! Form::open(['url' => 'texts']) !!}
                <div class="form-group">
                    <label for="question" class="control-label">Choix de la question</label>
                    {{ Form::select('question', $options, null, ['class' => 'form-control', 'required' => 'required']) }}
                </div>
                <div class="form-group">
                    <label for="content" class="control-label">Rédaction du texte de synthèse</label>
                    <textarea name="content" id="content" rows=20 style="resize: vertical;" class="form-control"
                              required></textarea>
                </div>
                @include('texts.legal-warning')
                <button class="btn btn-primary" type="submit">
                    <i class="fa fa-btn fa-save"></i> Enregistrer ce texte
                </button>
                {!! Form::close() !!}
            @else
                <div class="alert alert-warning">
                    Pour l'instant, vous ne pouvez pas saisir de texte libre pour de nouvelles questions. Pour modifier
                    vos textes libres déjà écrits, cliquez sur le petit stylo directement sur la page du texte. Pour
                    obtenir le droit de saisir un texte de synthèse sur une nouvelle question, vous devez lire et
                    annoter au moins {{ \App\Policies\TextPolicy::MIN_SCORE_PER_QUESTION }} réponses à
                    cette question. Vous pouvez suivre votre progression dans la page de chaque thème. &Eacute;crire
                    un résumé pertinent de ce qui s'est dit sur une thématique nécessite d'avoir lu beaucoup pour
                    prendre du recul. Bon courage ! En moyenne, il faut quelques heures de lecture et d'annotation pour
                    arriver à ce niveau.
                </div>
            @endif
        </div>
    </div>
@endsection
